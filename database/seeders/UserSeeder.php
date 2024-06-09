<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'username' => 'admin',
            'firstname' => 'admin',
            'lastname' => 'rama',
            'phonenumber' => '081234567891',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'poin' => 1000,
            'role' => 'admin',
        ]);
        DB::table('users')->insert([
            'username' => 'rafael',
            'firstname' => 'sugeng',
            'lastname' => 'rafael',
            'phonenumber' => '081234567892',
            'email' => 'rafael@gmail.com',
            'password' => Hash::make('rafael123'),
            'poin' => 1000,
            'role' => 'cashier',
            'is_cashier_active' => 0
        ]);
        DB::table('users')->insert([
            'username' => 'rama',
            'firstname' => 'dion',
            'lastname' => 'rama',
            'phonenumber' => '081234567893',
            'email' => 'rama@gmail.com',
            'password' => Hash::make('rama123'),
            'poin' => 1000,
            'role' => 'customer',
        ]);
    }
}
