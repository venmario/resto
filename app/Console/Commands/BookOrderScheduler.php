<?php

namespace App\Console\Commands;

use App\Models\Fcm;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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

        $stores = Store::all();
        $store = $stores[0];

        $openTime = $store->open;
        $closeTime = $store->close;

        $parsedTimeOpen = Carbon::createFromTimeString($openTime);
        $parsedTimeClose = Carbon::createFromTimeString($closeTime);

        if ($now->between($parsedTimeOpen, $parsedTimeClose)) {
            DB::table('products')->update(['available' => true]);
        } else {
            DB::table('products')->update(['available' => false]);
        }

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
            if (count($deviceTokens) > 0) {
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
}
