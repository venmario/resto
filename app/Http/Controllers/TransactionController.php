<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        Config::$serverKey = env('SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    public function CreateTransaction(Request $request)
    {
        $nextId = Order::generateOrderId();
        Log::info("nextId : " . $nextId);
        DB::beginTransaction();
        try {
            $order = $request->except('order_detail');
            $order['id'] = $nextId;
            $order['order_at'] = Carbon::now();

            $grandtotal = 0;
            $grandtotalpoin = 0;
            $orderDetails = $request->input('order_detail');
            Log::info("od", $orderDetails);

            foreach ($orderDetails as &$od) {
                $od['order_id'] = $nextId;
                $totalPrice = $od['price'] * $od['quantity'] * 1000;
                $totalPoin = $od['poin'] * $od['quantity'];
                $grandtotal += $totalPrice;
                $grandtotalpoin += $totalPoin;
                $od['price'] *= 1000;
            }
            $order['grandtotal'] = $grandtotal;
            $order['grandtotalpoin'] = $grandtotalpoin;

            $user = JWTAuth::authenticate($request->token);

            $order['user_id'] = $user['id'];
            $params = [
                'transaction_details' => [
                    'order_id' => $nextId,
                    'gross_amount' => $grandtotal,
                ],
                'customer_details' => [
                    'first_name' => $user['firstname'],
                    'last_name' => $user['lastname'],
                    'email' => $user['email'],
                    'phone' => $user['phonenumber'],
                ],
                'page_expiry' => [
                    'duration' => 1,
                    'unit' => "hours",
                ],
                "bca_va" => [
                    "va_number" => $user['phonenumber'],
                ],
                "enabled_payments" => [
                    "bca_va",
                    "bri_va",
                    "gopay",
                    "shopeepay",
                    "other_qris",
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            Log::info("snap token : " . $snapToken);
            $order['snap_token'] = $snapToken;
            $objOrder = Order::create($order);
            $objOrder->product()->attach($orderDetails);
            DB::commit();
            return response()->json([
                'token' => $snapToken,
                'redirect_url' => "https://app.sandbox.midtrans.com/snap/v4/redirection/$snapToken",
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $request->flash();
            // dd($e->getTrace());
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function transactionNotification(Request $request)
    {
        $transactionData = $request->all();
        Log::info("transaction data : " . json_encode($transactionData));
        DB::beginTransaction();
        try {
            Log::info("finding a transaction");
            $transaction = Transaction::find($transactionData['transaction_id']);
            if ($transaction) {
                $transaction->order_id = $transactionData['order_id'];
                $transaction->gross_amount = $transactionData['gross_amount'];
                $transaction->transaction_time = $transactionData['transaction_time'];
                $transaction->transaction_status = $transactionData['transaction_status'];
                $transaction->status_message = $transactionData['status_message'];
                $transaction->status_code = $transactionData['status_code'];
                $transaction->settlement_time = isset($transactionData['settlement_time']) ? $transactionData['settlement_time'] : null;
                $transaction->payment_type = isset($transactionData['payment_type']) ? $transactionData['payment_type'] : null;
                $transaction->issuer = isset($transactionData['issuer']) ? $transactionData['issuer'] : null;
                $transaction->va_number = isset($transactionData['va_numbers']) ? $transactionData['va_numbers'][0]['va_number'] : null;
                $transaction->bank = isset($transactionData['va_numbers']) ? $transactionData['va_numbers'][0]['bank'] : null;
                $transaction->fraud_status = $transactionData['fraud_status'];
                $transaction->save();
                if ($transactionData['transaction_status'] == "settlement") {
                    //ganti status order ke processing
                    $order = Order::find($transaction->order_id);
                    $order->order_status = "processing";
                    $order->save();

                    //ambil id user
                    $userId = $order->user_id;

                    //tambah poin user
                    $user = User::findOrFail($userId);
                    $poin = $user->poin;
                    $newPoin = $poin + (int)($transaction->gross_amount / 1000);
                    $user->poin = $newPoin;
                    $user->save();
                }
                DB::commit();
                return;
            }
            Log::info("no trasaction found");
            $transaction = new Transaction();
            $transaction->transaction_id = $transactionData['transaction_id'];
            $transaction->order_id = $transactionData['order_id'];
            $transaction->gross_amount = $transactionData['gross_amount'];
            $transaction->transaction_time = $transactionData['transaction_time'];
            $transaction->transaction_status = $transactionData['transaction_status'];
            $transaction->status_message = $transactionData['status_message'];
            $transaction->status_code = $transactionData['status_code'];
            $transaction->settlement_time = isset($transactionData['settlement_time']) ? $transactionData['settlement_time'] : null;
            $transaction->payment_type = isset($transactionData['payment_type']) ? $transactionData['payment_type'] : null;
            $transaction->issuer = isset($transactionData['issuer']) ? $transactionData['issuer'] : null;
            $transaction->va_number = isset($transactionData['va_numbers']) ? $transactionData['va_numbers'][0]['va_number'] : null;
            $transaction->bank = isset($transactionData['va_numbers']) ? $transactionData['va_numbers'][0]['bank'] : null;
            $transaction->fraud_status = $transactionData['fraud_status'];
            $transaction->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $request->flash();
            Log::error($e->getMessage());
        }
    }

    public function getTransactions()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;
        $transactions = Transaction::with(['order' => function ($query) use ($userId) {
            $query->with('product')->where('user_id', $userId);
        }])->where('transaction_status', 'settlement')->orWhere('transaction_status', 'pending')->orderBy('updated_at', 'desc')->get();
        $orders = [];
        foreach ($transactions as $transaction) {

            $totalItem = 0;
            $products = [];
            foreach ($transaction['order']['product'] as $product) {
                $productQty = $product['pivot']['quantity'];
                $totalItem += $productQty;
                $product = [
                    'name' => $product->name,
                    'quantity' => $productQty,
                ];
                $products[] = $product;
            }
            $date = Carbon::parse($transaction['order']['updated_at']);
            $formattedDate = $date->isoFormat('dddd, D MMM YYYY HH:mm');

            $order = [
                'order_id' => $transaction['order_id'],
                'status' => $transaction['order']['order_status'],
                'grandtotal' => $transaction['order']['grandtotal'],
                'total_item' => $totalItem,
                'updated_at' => $formattedDate,
                'details' => $products
            ];

            $orders[] = $order;
        }
        return response()->json($orders);
    }
    public function getOrderById($orderId)
    {
        $order = Order::with('product')->find($orderId);

        $products = [];
        foreach ($order['product'] as $product) {
            $productQty = $product['pivot']['quantity'];
            $price = $product['pivot']['price'];
            $note = $product['pivot']['note'];
            $product = [
                'name' => $product->name,
                'image' => $product->image,
                'quantity' => $productQty,
                'description' => $product->description,
                'price' => $price,
                'note' => $note
            ];
            $products[] = $product;
        }

        $date = Carbon::parse($order['updated_at']);
        $formattedDate = $date->isoFormat('dddd, D MMM YYYY');
        $formattedTime = $date->isoFormat("HH:mm");
        $order = [
            'order_id' => $order['id'],
            'status' => $order['order_status'],
            'grandtotal' => $order['grandtotal'],
            'updated_at_date' => $formattedDate,
            'updated_at_time' => $formattedTime,
            'details' => $products
        ];
        return response()->json($order);
    }
}
