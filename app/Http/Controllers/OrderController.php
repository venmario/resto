<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class OrderController extends Controller
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
    public function index()
    {
        //
        $orderid = rand();
        $params = [
            'transaction_details' => [
                'order_id' => $orderid,
                'gross_amount' => 10000,
            ],
            'customer_details' => [
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ],
            'page_expiry' => [
                'duration' => 5,
                'unit' => "minutes",
            ],
            "bca_va" => [
                "va_number" => "081358084101",
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

        return response()->json([
            'token' => $snapToken,
            'redirect_url' => "https://app.sandbox.midtrans.com/snap/v4/redirection/$snapToken",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return response()->json($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function getStatus($id)
    {
        $status = Transaction::status($id);
        Log::info("transaction status : " . json_encode($status));
        return $status;
    }

    public function test(Request $request)
    {
        $req = [
            "transaction_time" => $request->transaction_time,
            "transaction_status" => $request->transaction_status,
            "transaction_id" => $request->transaction_id,
            "status_message" => $request->status_message,
            "status_code" => $request->status_code,
            "signature_key" => $request->signature_key,
            "settlement_time" => $request->settlement_time,
            "payment_type" => $request->payment_type,
            "order_id" => $request->order_id,
            "merchant_id" => $request->merchant_id,
            "gross_amount" => $request->gross_amount,
            "fraud_status" => $request->fraud_status,
            "currency" => $request->currency,
        ];
        Log::info("transaction request : " . json_encode($req));
        return response()->json($request);
    }
}
