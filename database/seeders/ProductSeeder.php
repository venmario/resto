<?php

namespace Database\Seeders;

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
                'name' => 'Cheese Fries',
                'description' => 'shoestring cut fries and cheese souce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 20,
                'price' => 25,
                'poin' => 25
            ],
            [
                'name' => 'Onion Ring',
                'description' => 'fried onion with cheese souce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 20,
                'price' => 30,
                'poin' => 30
            ],
            [
                'name' => 'BBQ Chicken Wing',
                'description' => 'fried onion with cheese souce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 20,
                'price' => 30,
                'poin' => 30
            ],
            [
                'name' => 'Mozza Garlic Bread',
                'description' => 'crusty garlic bread with topped with melting mozza cheese',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 20,
                'price' => 35,
                'poin' => 35
            ],
            [
                'name' => 'Creamy Chicken Soup',
                'description' => 'chicken chunks, beef & chicken sausage, mushroom broth',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 21,
                'price' => 25,
                'poin' => 25
            ],
            [
                'name' => 'Creamy Pumpkin Soup',
                'description' => 'pumpkin soup with creamy broth',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 21,
                'price' => 25,
                'poin' => 25
            ],
            [
                'name' => 'Grilled Chicken Salad',
                'description' => 'fresh green salad with grilled BBQ chicken',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 21,
                'price' => 30,
                'poin' => 30
            ],
            [
                'name' => 'Pizza Aussie',
                'description' => 'napoly sauce, smoked beef, onion, sausage, pineapple, triple cheese & egg',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 19,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'BBQ Chicken Mushroom',
                'description' => 'napoly sauce, grilled BBQ chicken, sausage, mushroom, bell pepper and triple cheese',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 19,
                'price' => 55,
                'poin' => 55
            ],
            [
                'name' => 'Cream Cheese Pizza',
                'description' => 'homemade cheese sauce, chicken chunks, smoked beef, mushroom, bell pepper, sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 19,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Pepperoni Mushroom',
                'description' => 'napoly sauce, pepperoni, sausage, mushroom, onion and triple cheese',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 19,
                'price' => 55,
                'poin' => 55
            ],
            [
                'name' => 'Grill Honey Chicken',
                'description' => 'chicken steak with honey sauce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 16,
                'price' => 50,
                'poin' => 50
            ],
            [
                'name' => 'Mexican Grill Chicken',
                'description' => 'chicken breast fillet steak with sweet spicy sauce ala mexico',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 16,
                'price' => 50,
                'poin' => 50
            ],
            [
                'name' => 'Spicy Bake Chicken',
                'description' => 'half roast bake chicken with spicy herbs',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 16,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Chicken Parmagiana',
                'description' => 'chicken breast stuffed with smoked beef & mozarella cheese, coated with japanese flour',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 16,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Chicken Parmagiana',
                'description' => 'chicken breast stuffed with smoked beef & mozarella cheese, coated with japanese flour',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 16,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Chicken Cordon  Bleu',
                'description' => 'chicken breast stuffed with smoked beef & mozarella cheese, coated with japanese flour',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 16,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Happy Steak',
                'description' => 'chicken steak served with beef & chicken sausage and french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 17,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Kiddy Steak',
                'description' => 'steak stuffed with chicken & beef sausage, nugget, and french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 17,
                'price' => 55,
                'poin' => 55
            ],
            [
                'name' => 'Joy Steak',
                'description' => 'beef steak with chicken & beef sausage and french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 17,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Crispy Chicken Steak',
                'description' => 'chicken thigh fillet, coated with special crispy flour & smeared with smoky sauce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 18,
                'price' => 45,
                'poin' => 45
            ],
            [
                'name' => 'Crispy Beef Steak',
                'description' => 'beef fillet, coated with special crispy flour & smeared with smoky BBQ sauce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 18,
                'price' => 50,
                'poin' => 50
            ],
            [
                'name' => 'Crispy Fish Steak',
                'description' => 'deep fried fish fillet with smoky BBQ sauce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 18,
                'price' => 50,
                'poin' => 50
            ],
            [
                'name' => 'Fish and Chips',
                'description' => 'deep fried fish fillet with smoky BBQ sauce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 18,
                'price' => 55,
                'poin' => 55
            ],
            [
                'name' => 'Mix Crispy Steak',
                'description' => 'deep fried fish fillet with smoky BBQ sauce',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 18,
                'price' => 75,
                'poin' => 75
            ],
            [
                'name' => 'Sirloin 160gr',
                'description' => 'sirloin steak 160gr served with french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 65,
                'poin' => 65
            ],
            [
                'name' => 'Sirloin 220gr',
                'description' => 'sirloin steak 220gr served with french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 95,
                'poin' => 95
            ],
            [
                'name' => 'Tenderloin 160gr',
                'description' => 'tenderloin steak 160gr served with french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 70,
                'poin' => 70
            ],
            [
                'name' => 'Tenderloin 220gr',
                'description' => 'tenderloin steak 220gr served with french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 98,
                'poin' => 98
            ],
            [
                'name' => 'Rib Eye Steak 220gr',
                'description' => 'rib eye steak 220gr served with french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 98,
                'poin' => 98
            ],
            [
                'name' => 'Matador Steak 200gr',
                'description' => 'minced beef steak 200gr served with french fries',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 85,
                'poin' => 85
            ],
            [
                'name' => 'DS Platter',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 95,
                'poin' => 95
            ],
            [
                'name' => 'Ox-Tongue Steak 200gr',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 85,
                'poin' => 85
            ],
            [
                'name' => 'Beef Mozza Steak 200gr',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 14,
                'price' => 105,
                'poin' => 105
            ],
            [
                'name' => 'Moist Dory Steak',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 15,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Tasmania Salmon',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 15,
                'price' => 98,
                'poin' => 98
            ],
            [
                'name' => 'Dino Beef Rib 400gr',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 12,
                'price' => 155,
                'poin' => 155
            ],
            [
                'name' => 'AUS Marbling Tenderloin 250gr',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 12,
                'price' => 175,
                'poin' => 175
            ],
            [
                'name' => 'AUS Marbling Sirloin 250gr',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 12,
                'price' => 160,
                'poin' => 160
            ],
            [
                'name' => 'AUS Marbling Rib Eye 250gr',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 12,
                'price' => 185,
                'poin' => 185
            ],
            [
                'name' => 'AUS Marbling T-Bone 300gr',
                'description' => 'a combination of beef & chicken steak, beef & chicken sausage',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 12,
                'price' => 210,
                'poin' => 210
            ],
            [
                'name' => 'Wagyu Rib Eye MB +5 100gr',
                'description' => 'Wagyu Rib Eye MB +5',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 11,
                'price' => 135,
                'poin' => 135
            ],
            [
                'name' => 'Wagyu Sirloin MB +5 100gr',
                'description' => 'Wagyu Sirloin MB +5',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 11,
                'price' => 120,
                'poin' => 120
            ],
            [
                'name' => 'US Prime Porter House 100gr',
                'description' => 'US Prime Porter House',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 11,
                'price' => 95,
                'poin' => 95
            ],
            [
                'name' => 'Grill Chicken',
                'description' => 'Grill Chicken',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 10,
                'price' => 40,
                'poin' => 40
            ],
            [
                'name' => 'Chicken Katsu',
                'description' => 'Chicken Katsu',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 10,
                'price' => 40,
                'poin' => 40
            ],
            [
                'name' => 'Kalbi Beef',
                'description' => 'Kalbi Beef',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 10,
                'price' => 45,
                'poin' => 45
            ],
            [
                'name' => 'Grill Salmon Mentai',
                'description' => 'Grill Salmon Mentai',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 10,
                'price' => 55,
                'poin' => 55
            ],
            [
                'name' => 'Saikoro Beef',
                'description' => 'Saikoro Beef',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 10,
                'price' => 55,
                'poin' => 55
            ],
            [
                'name' => 'Beef and Tendon Stew',
                'description' => 'Beef and Tendon Stew',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 10,
                'price' => 55,
                'poin' => 55
            ],
            [
                'name' => 'Bolognese',
                'description' => 'Bolognese',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 8,
                'price' => 35,
                'poin' => 35
            ],
            [
                'name' => 'Carbonara',
                'description' => 'Carbonara',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 8,
                'price' => 45,
                'poin' => 45
            ],
            [
                'name' => 'Aglio Olio Seafood',
                'description' => 'Aglio Olio Seafood',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 8,
                'price' => 50,
                'poin' => 50
            ],
            [
                'name' => 'Black Ink Squid',
                'description' => 'Black Ink Squid',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 8,
                'price' => 55,
                'poin' => 55
            ],
            [
                'name' => 'Mac and Cheese',
                'description' => 'Mac and Cheese',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 8,
                'price' => 50,
                'poin' => 50
            ],
            [
                'name' => 'Classic Burger',
                'description' => 'Classic Burger',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 9,
                'price' => 45,
                'poin' => 45
            ],
            [
                'name' => 'Chicken Burger',
                'description' => 'Chicken Burger',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 9,
                'price' => 40,
                'poin' => 40
            ],
            [
                'name' => 'Fish Burger',
                'description' => 'Fish Burger',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 9,
                'price' => 40,
                'poin' => 40
            ],
            [
                'name' => 'Chunky Tuna Toast',
                'description' => 'Chunky Tuna Toast',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 9,
                'price' => 60,
                'poin' => 60
            ],
            [
                'name' => 'Philly Cheese Steak',
                'description' => 'Philly Cheese Steak',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 9,
                'price' => 65,
                'poin' => 65
            ],
            [
                'name' => 'Moka Pot Espresso',
                'description' => 'Moka Pot Espresso',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 25,
                'poin' => 25
            ],
            [
                'name' => 'Dirt Coffee',
                'description' => 'Dirt Coffee',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 20,
                'poin' => 20
            ],
            [
                'name' => 'Cappucino Hot',
                'description' => 'Cappucino Hot',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 28,
                'poin' => 28
            ],
            [
                'name' => 'Cappucino Ice',
                'description' => 'Cappucino Ice',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 28,
                'poin' => 28
            ],
            [
                'name' => 'Latte Hot',
                'description' => 'Latte Hot',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 28,
                'poin' => 28
            ],
            [
                'name' => 'Latte Ice',
                'description' => 'Latte Ice',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 28,
                'poin' => 28
            ],
            [
                'name' => 'Matcha Coffee Hot',
                'description' => 'Matcha Coffee Hot',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 30,
                'poin' => 30
            ],
            [
                'name' => 'Matcha Coffee Ice',
                'description' => 'Matcha Coffee Ice',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 30,
                'poin' => 30
            ],
            [
                'name' => 'Ice Hazelnut Coffee Float',
                'description' => 'Ice Hazelnut Coffee Float',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 34,
                'poin' => 34
            ],
            [
                'name' => 'Avocado Coffee',
                'description' => 'Avocado Coffee',
                'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'available' => 1,
                'category_id' => 6,
                'price' => 38,
                'poin' => 38
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'description' => $product['description'],
                'image' => $product['image'],
                'available' => $product['available'],
                'category_id' => $product['category_id'],
                'price' => $product['price'],
                'poin' => $product['poin'],
            ]);
        }
    }
}
