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
            ['name' => 'Makanan', 'parent_id' => null],
            ['name' => 'Minuman', 'parent_id' => null],
            ['name' => 'Dessert', 'parent_id' => null],
            ['name' => 'Non Coffee', 'parent_id' => 2],
            ['name' => 'Refreshing Drink', 'parent_id' => 2],
            ['name' => 'Coffee', 'parent_id' => 2],
            ['name' => 'Fresh Juice', 'parent_id' => 2],
            ['name' => 'Pasta', 'parent_id' => 1],
            ['name' => 'Toast Bread', 'parent_id' => 1],
            ['name' => 'Butter Rice Bowl', 'parent_id' => 1],
            ['name' => 'Cold Smoke 24 Day Aged Beef', 'parent_id' => 1],
            ['name' => 'Hot Stone Steak', 'parent_id' => 1],
            ['name' => 'Side Dish', 'parent_id' => 1],
            ['name' => 'Import Beef Steak', 'parent_id' => 1],
            ['name' => 'Seafood Steak', 'parent_id' => 1],
            ['name' => 'Chicken Steak', 'parent_id' => 1],
            ['name' => 'Kids Steak', 'parent_id' => 1],
            ['name' => 'Crispy & Tasty Steak', 'parent_id' => 1],
            ['name' => 'Gourmet Pizza', 'parent_id' => 1],
            ['name' => 'Appetizer', 'parent_id' => 1],
            ['name' => 'Soup & Salad', 'parent_id' => 1],
        ];

        $i=1;
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'id'=>$i++,
                'name' => $category['name'],
                'parent_id' => $category['parent_id'],
            ]);
        }
    }
}
