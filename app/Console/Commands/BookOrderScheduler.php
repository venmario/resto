<?php

namespace App\Console\Commands;

use App\Models\Fcm;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class BookOrderScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookorder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        $ordersToUpdate = Order::where('order_status', 'Booking')
            ->where('booked_at', '<=', $now)
            ->get();

        $totalOrdersToUpdate = $ordersToUpdate->count();

        Order::whereIn('id', $ordersToUpdate->pluck('id'))
            ->update(['order_status' => 'In Waiting List']);

        if ($totalOrdersToUpdate > 0) {
            $cashierFcmTokens = Fcm::withWhereHas('user', function ($query) {
                $query->where('is_cashier_active', true);
            })->get();

            $deviceTokens = [];
            foreach ($cashierFcmTokens as $fcmToken) {
                $deviceTokens[] = $fcmToken->fcm_token;
            }
            $title = "Booking Order Moved to Waiting List!";
            $body = "Booking orders are in waiting list";
            $notification = Notification::create($title, $body);
            $data = ['status' => 'booked order in waiting list'];
            $message = CloudMessage::new()->withNotification($notification)->withData($data);

            $messaging = app('firebase.messaging');
            $messaging->sendMulticast($message, $deviceTokens);
        }
    }
}
