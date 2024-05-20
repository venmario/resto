<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
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
        $maxId = Order::max('id');
        $nextId = $maxId ? str_pad(++$maxId, 4, '0', STR_PAD_LEFT) : 'DS0001';

        DB::beginTransaction();
        try {
            $order = $request->except('order_detail');
            $order['id'] = $nextId;
            $order['order_at'] = Carbon::now();

            $grandtotal = 0;
            $grandtotalpoin = 0;
            $orderDetails = $request->input('order_detail');

            foreach ($orderDetails as &$od) {
                $od['order_id'] = $nextId;
                $totalPrice = $od['price'] * $od['quantity'];
                $totalPoin = $od['poin'] * $od['quantity'];
                $grandtotal += $totalPrice;
                $grandtotalpoin += $totalPoin;
            }
            $order['grandtotal'] = $grandtotal;
            $order['grandtotalpoin'] = $grandtotalpoin;

            $user = JWTAuth::authenticate($request->token);

            $order['user_id'] = $user['id'];

            $objOrder = Order::create($order);

            $objOrder->product()->attach($orderDetails);
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
                    'duration' => 5,
                    'unit' => "minutes",
                ],
                "bca_va" => [
                    "va_number" => $user['phonenumber'],
                ],
                "enabled_payments" => [
                    "permata_va",
                    "bca_va",
                    "bni_va",
                    "bri_va",
                    "cimb_va",
                    "other_va",
                    "gopay",
                    "shopeepay",
                    "other_qris",
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            Log::info("snap token : " . $snapToken);
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
                if ($transaction->update($transactionData) === false) {
                    Log::info("bad request");
                }
                Log::info("transaction updated");
                DB::commit();
            }
            Log::info("no trasaction found");
            Transaction::create($transactionData);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $request->flash();
            Log::error($e->getMessage());
        }
    }
}
