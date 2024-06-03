<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = [
            ['name' => 'Makanan', 'parent_id' => null, 'sequence' => null], // 1
            ['name' => 'Minuman', 'parent_id' => null, 'sequence' => null], // 2
            ['name' => 'Dessert', 'parent_id' => null, 'sequence' => 19], // 3
            ['name' => 'Non Coffee', 'parent_id' => 2, 'sequence' => 15], // 4
            ['name' => 'Refreshing Drink', 'parent_id' => 2, 'sequence' => 16], // 5
            ['name' => 'Coffee', 'parent_id' => 2, 'sequence' => 17], // 6
            ['name' => 'Fresh Juice', 'parent_id' => 2, 'sequence' => 18], // 7
            ['name' => 'Pasta', 'parent_id' => 1, 'sequence' => 4], // 8
            ['name' => 'Toast Bread', 'parent_id' => 1, 'sequence' => 5], // 9
            ['name' => 'Butter Rice Bowl', 'parent_id' => 1, 'sequence' => 6], // 10
            ['name' => 'Cold Smoke 24 Day Aged Beef', 'parent_id' => 1, 'sequence' => 7], // 11
            ['name' => 'Hot Stone Steak', 'parent_id' => 1, 'sequence' => 8], // 12
            ['name' => 'Side Dish', 'parent_id' => 1, 'sequence' => 9], // 13
            ['name' => 'Import Beef Steak', 'parent_id' => 1, 'sequence' => 10], // 14
            ['name' => 'Seafood Steak', 'parent_id' => 1, 'sequence' => 11], // 15
            ['name' => 'Chicken Steak', 'parent_id' => 1, 'sequence' => 12], // 16
            ['name' => 'Kids Steak', 'parent_id' => 1, 'sequence' => 13], // 17
            ['name' => 'Crispy & Tasty Steak', 'parent_id' => 1, 'sequence' => 14], // 18
            ['name' => 'Gourmet Pizza', 'parent_id' => 1, 'sequence' => 2], // 19
            ['name' => 'Appetizer', 'parent_id' => 1, 'sequence' => 1], // 20
            ['name' => 'Soup & Salad', 'parent_id' => 1, 'sequence' => 3], // 21
        ];

        $i = 1;
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'id' => $i++,
                'name' => $category['name'],
                'parent_id' => $category['parent_id'],
            ]);
        }
    }
}
