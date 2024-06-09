<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Fcm;
use App\Models\Order;
use Exception;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class CashierController extends Controller
{
    public function readyToPickUpOrder(Order $order)
    {
        $messaging = app('firebase.messaging');
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
            $body = "Please take your order as soon as possible";
            $notification = Notification::create($title, $body);

            $data = ['transaction_id' => $transactionId];
            // $message = CloudMessage::withTarget('tokens', $deviceTokens)
            //     ->withNotification($notification)
            //     ->withData($data);
            $message = CloudMessage::new()->withNotification($notification)->withData($data);

            $messaging->sendMulticast($message, $deviceTokens);
            DB::commit();
            return response()->json(['isSuccess' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage()]);
        }
    }
}
