<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        Log::info("Cron job Berhasil di jalankan " . date('Y-m-d H:i:s'));
        User::create([
            'username' => date('Y-m-d H:i:s'),
            'firstname' => date('Y-m-d H:i:s'),
            'lastname' => date('Y-m-d H:i:s'),
            'phonenumber' => date('Y-m-d H:i:s'),
            'email' => date('Y-m-d H:i:s'),
            'password' => date('Y-m-d H:i:s'),
        ]);
        // return Command::SUCCESS;
    }
}
