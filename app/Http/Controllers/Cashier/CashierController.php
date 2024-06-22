<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Fcm;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CashierController extends Controller
{
    public $messaging;
    public function __construct()
    {
        $this->messaging = app('firebase.messaging');
    }

    public function finishOrder(Order $order)
    {
        $fcmTokens = Fcm::where('user_id', $order->user_id)->get();

        $deviceTokens = [];
        foreach ($fcmTokens as $fcmToken) {
            $deviceTokens[] = $fcmToken->fcm_token;
        }
        DB::beginTransaction();
        try {
            $transactionId = $order->transaction[0]->transaction_id;
            $order->order_status = "Collected";
            $order->finished_at = Carbon::now();
            $order->save();
            $title = "Finished!";
            $body = "Order " . $order->id . " has picked up. Please enjoy the meal!";
            $notification = Notification::create($title, $body);

            $data = ['transaction_id' => $transactionId];
            $message = CloudMessage::new()->withNotification($notification)->withData($data);

            $this->messaging->sendMulticast($message, $deviceTokens);
            DB::commit();
            return response()->json(['isSuccess' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage()]);
        }
    }
    public function readyToPickUpOrder(Order $order)
    {
        $fcmTokens = Fcm::where('user_id', $order->user_id)->get();

        $deviceTokens = [];
        foreach ($fcmTokens as $fcmToken) {
            $deviceTokens[] = $fcmToken->fcm_token;
        }
        DB::beginTransaction();
        try {
            $transactionId = $order->transaction[0]->transaction_id;
            $order->order_status = "Ready to Pick Up";
            $order->save();
            $title = "Ready to pick up!";
            $body = "Order " . $order->id . " is ready to pick up!. Please take your order as soon as possible";
            $notification = Notification::create($title, $body);

            $data = ['transaction_id' => $transactionId];
            $message = CloudMessage::new()->withNotification($notification)->withData($data);

            $this->messaging->sendMulticast($message, $deviceTokens);
            DB::commit();
            return response()->json(['isSuccess' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage()]);
        }
    }

    public function confirmOrder(Order $order, Request $request)
    {
        $estimation = $request->estimation;
        Log::info("request : " . json_encode($request));
        Log::info("estimation time : " . $estimation);
        $fcmTokens = Fcm::where('user_id', $order->user_id)->get();

        $deviceTokens = [];
        foreach ($fcmTokens as $fcmToken) {
            $deviceTokens[] = $fcmToken->fcm_token;
        }
        DB::beginTransaction();
        try {
            $transactionId = $order->transaction[0]->transaction_id;
            $order->order_status = "Processing";
            $order->estimation = Carbon::now()->addMinutes($estimation);
            $order->save();
            $title = "Order confirmed!";
            $body = "Order " . $order->id . " has been processed!. We will serve your order as soon as possible";
            $notification = Notification::create($title, $body);

            $data = ['transaction_id' => $transactionId];
            $message = CloudMessage::new()->withNotification($notification)->withData($data);

            $this->messaging->sendMulticast($message, $deviceTokens);
            DB::commit();
            return response()->json(['isSuccess' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage()]);
        }
    }

    public function getOrderById($id)
    {
        try {
            $orderDetails = [];
            Log::info("orderID : " . $id);
            $order = Order::with('product')->find($id);
            Log::info("order : " . $order);
            foreach ($order['product'] as $od) {
                $orderDetails[] = [
                    'product' => $od['name'],
                    'quantity' => $od['pivot']['quantity'],
                    'price' => $od['pivot']['price'],
                    'note' => $od['pivot']['note']
                ];
            }

            // Log::info("new Order : " . $newOrder);
            return response()->json(['isSuccess' => true, 'errorMessage' => null, 'data' => $orderDetails]);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e);
            return response()->json(['isSuccess' => false, 'errorMessage' => "Something went wrong while getting order"]);
        }
    }

    public function getOrders()
    {
        try {
            $transactions = Transaction::with(['order' => function ($query) {
                $query->with(['product' => function ($query) {
                    $query->select("name")->withPivot("price", "quantity", "note")->get();
                },  'user'])->get(); //order
            }])->where('transaction_status', 'settlement')->where('settlement_time', '>',  Carbon::today())->orderBy("settlement_time", "desc")->get();


            $statuses = [
                [
                    'status' => "In Waiting List",
                    'orders' => []
                ],
                [
                    'status' => "Processing",
                    'orders' => []
                ],
                [
                    'status' => 'Ready to Pick Up',
                    'orders' => []
                ],
                [
                    "status" => "Collected",
                    'orders' => []
                ],
                [
                    "status" => "Booking",
                    "orders" => []
                ]
            ];

            foreach ($transactions as $transaction) {
                $status = $transaction['order']['order_status'];

                $totalItem = 0;
                $products = $transaction['order']['product'];
                foreach ($products as $product) {
                    $totalItem += $product['pivot']['quantity'];
                }

                $order = [
                    'order_id' => $transaction['order_id'],
                    'status' => $transaction['order']['order_status'],
                    'fullname' => $transaction['order']['user']['firstname'] . " " . $transaction['order']['user']['lastname'],
                    'bank' => isset($transaction['bank']) ? $transaction['bank'] : null,
                    'payment_type' => $transaction['payment_type'],
                    'total_item' => $totalItem,
                    'grand_total' => $transaction['order']['grandtotal']
                ];
                if ($status == "In Waiting List") {
                    $statuses[0]['orders'][] = $order;
                } else if (strtolower($status) == "processing") {
                    $statuses[1]['orders'][] = $order;
                } else if ($status == "Ready to Pick Up") {
                    $statuses[2]['orders'][] = $order;
                } else if ($status == "Collected") {
                    $statuses[3]['orders'][] = $order;
                } else if ($status == "Booking") {
                    $statuses[4]['orders'][] = $order;
                }
            }

            return response()->json(['isSuccess' => true, 'errorMessage' => null, 'data' => $statuses]);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e);
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage()]);
        }
    }

    //authentication
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        //Create token
        try {
            $token = JWTAuth::attempt($credentials);
            Log::info("token : " . $token);
            if (!$token) {
                Log::info("Login credentials are invalid.");
                return response()->json([
                    'isSuccess' => false,
                    'errorMessage' => 'Login credentials are invalid.',
                    'code' => Response::HTTP_NOT_FOUND
                ]);
            }
        } catch (JWTException $e) {
            // return $credentials;
            Log::info("error login " . $e->getMessage());
            return response()->json([
                'isSuccess' => false,
                'errorMessage' => 'Could not create token',
                'code' => 500
            ]);
        }
        $user = User::where('username', $request->username)->first();
        if ($user->role != "cashier") {
            return response()->json([
                'isSuccess' => false,
                'errorMessage' => 'Unauthorized',
                'code' => 403
            ]);
        }
        //Token created, return with success response and jwt token
        Log::info("Token : $token");

        $oldFcmToken = $request->oldFcmToken;
        $currentFcmToken = $request->currentFcmToken;
        Log::info("old fcm token : " . $oldFcmToken);
        Log::info("current fcm token : " . $currentFcmToken);


        $updatedFcmToken = false;
        DB::beginTransaction();
        try {
            if ($oldFcmToken == $currentFcmToken) {
                $userFcmTokens = $user->fcm;
                $found = false;
                foreach ($userFcmTokens as $userFcmToken) {
                    if ($userFcmToken == $currentFcmToken) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    Fcm::create(['fcm_token' => $currentFcmToken, 'user_id' => $user->id]);
                    $updatedFcmToken = true;
                }
            } else {
                Fcm::find($oldFcmToken)->delete();
                Fcm::create(['fcm_token' => $currentFcmToken, 'user_id' => $user->id]);
                $updatedFcmToken = true;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("error message : " . $e->getMessage());
        }

        $user->is_cashier_active = true;
        $user->save();
        return response()->json([
            'isSuccess' => true,
            'token' => $token,
            'data' => $user,
            'updatedFcmToken' => $updatedFcmToken,
            'code' => Response::HTTP_OK
        ]);
    }

    public function logout(Request $request)
    {
        $fcmToken = $request->fcmToken;
        try {
            Fcm::find($fcmToken)->delete();
            $user = JWTAuth::parseToken()->authenticate();
            $user->is_cashier_active = false;
            $user->save();
            return response()->json(['isSuccess' => true]);
        } catch (Exception $e) {
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage()]);
        }
    }
}
