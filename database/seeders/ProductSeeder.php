<?php

namespace Database\Seeders;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = [
            [
                'id' => 1,
                'name' => 'Cheese Fries',
                'description' => 'shoestring cut fries and cheese souce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 20,
            ],
            [
                'id' => 2,
                'name' => 'Onion Ring',
                'description' => 'fried onion with cheese souce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 20,
            ],
            [
                'id' => 3,
                'name' => 'BBQ Chicken Wing',
                'description' => 'fried onion with cheese souce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 20,
            ],
            [
                'id' => 4,
                'name' => 'Mozza Garlic Bread',
                'description' => 'crusty garlic bread with topped with melting mozza cheese',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 20,
            ],
            [
                'id' => 5,
                'name' => 'Creamy Chicken Soup',
                'description' => 'chicken chunks, beef & chicken sausage, mushroom broth',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 21,
            ],
            [
                'id' => 6,
                'name' => 'Creamy Pumpkin Soup',
                'description' => 'pumpkin soup with creamy broth',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 21,
            ],
            [
                'id' => 7,
                'name' => 'Grilled Chicken Salad',
                'description' => 'fresh green salad with grilled BBQ chicken',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 21,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'id' => $product['id'],
                'name' => $product['name'],
                'description' => $product['description'],
                'image' => $product['image'],
                'available' => $product['available'],
                'category_id' => $product['category_id'],
            ]);
        }
    }
}
