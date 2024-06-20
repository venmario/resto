<?php

namespace App\Console\Commands;

use App\Models\Fcm;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;

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

        // Retrieve the orders that match the criteria
        $ordersToUpdate = Order::where('order_status', 'Booking')
            ->where('booked_at', '>=', $now)
            ->get();

        // Count the orders to be updated
        $totalOrdersToUpdate = $ordersToUpdate->count();

        // Update the orders
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
            $data = ['status' => 'booked order in waiting list'];
            $message = CloudMessage::new()->withData($data);

            $messaging = app('firebase.messaging');
            $messaging->sendMulticast($message, $deviceTokens);
        }
        // Log::info("Cron job Berhasil di jalankan " . date('Y-m-d H:i:s'));
        // User::create([
        //     'username' => date('Y-m-d H:i:s'),
        //     'firstname' => date('Y-m-d H:i:s'),
        //     'lastname' => date('Y-m-d H:i:s'),
        //     'phonenumber' => date('Y-m-d H:i:s'),
        //     'email' => date('Y-m-d H:i:s'),
        //     'password' => date('Y-m-d H:i:s'),
        // ]);
        // return Command::SUCCESS;
    }
}
