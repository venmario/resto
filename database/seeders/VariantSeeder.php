<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $variants = [
            ['type' => 'reguler', 'product_id' => 1, 'price' => 25, 'poin' => 25],
            ['type' => 'reguler', 'product_id' => 2, 'price' => 30, 'poin' => 30],
            ['type' => 'reguler', 'product_id' => 3, 'price' => 30, 'poin' => 30],
            ['type' => 'reguler', 'product_id' => 4, 'price' => 35, 'poin' => 35],
            ['type' => 'reguler', 'product_id' => 5, 'price' => 25, 'poin' => 25],
            ['type' => 'reguler', 'product_id' => 6, 'price' => 25, 'poin' => 25],
            ['type' => 'reguler', 'product_id' => 7, 'price' => 30, 'poin' => 30],
            // ['type' => 'reguler', 'product_id' => 8,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 9,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 10,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 11,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 12,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 13,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 14,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 15,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 16,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 17,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 18,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 19,'price'=>0,'poin'=>],
            // ['type' => 'reguler', 'product_id' => 20,'price'=>0,'poin'=>],
        ];

        foreach ($variants as $variant) {
            DB::table('categories')->insert([
                'type' => $variant['type'],
                'product_id' => $variant['product_id'],
                'price' => $variant['price'],
                'poin' => $variant['poin'],
            ]);
        }
    }
}
