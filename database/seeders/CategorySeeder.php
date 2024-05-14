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
            ['name' => 'Makanan', 'parent_id' => null], //1
            ['name' => 'Minuman', 'parent_id' => null], //2
            ['name' => 'Dessert', 'parent_id' => null], //3
            ['name' => 'Non Coffee', 'parent_id' => 2], //4
            ['name' => 'Refreshing Drink', 'parent_id' => 2], //5
            ['name' => 'Coffee', 'parent_id' => 2], //6
            ['name' => 'Fresh Juice', 'parent_id' => 2], //7
            ['name' => 'Pasta', 'parent_id' => 1], //8
            ['name' => 'Toast Bread', 'parent_id' => 1], //9
            ['name' => 'Butter Rice Bowl', 'parent_id' => 1], //10
            ['name' => 'Cold Smoke 24 Day Aged Beef', 'parent_id' => 1], //11
            ['name' => 'Hot Stone Steak', 'parent_id' => 1], //12
            ['name' => 'Side Dish', 'parent_id' => 1], //13
            ['name' => 'Import Beef Steak', 'parent_id' => 1], //14
            ['name' => 'Seafood Steak', 'parent_id' => 1], //15
            ['name' => 'Chicken Steak', 'parent_id' => 1], //16
            ['name' => 'Kids Steak', 'parent_id' => 1], //17
            ['name' => 'Crispy & Tasty Steak', 'parent_id' => 1], //18
            ['name' => 'Gourmet Pizza', 'parent_id' => 1], //19
            ['name' => 'Appetizer', 'parent_id' => 1], //20
            ['name' => 'Soup & Salad', 'parent_id' => 1], //21
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
