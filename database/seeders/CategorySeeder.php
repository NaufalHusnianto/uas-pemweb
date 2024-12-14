<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Shoes', 'description' => 'A variety of stylish and comfortable footwear for all occasions.'],
            ['name' => 'Shirt', 'description' => 'Casual and formal shirts made from high-quality materials.'],
            ['name' => 'Jacket', 'description' => 'Warm and durable jackets to keep you cozy in any weather.'],
            ['name' => 'Hoodie', 'description' => 'Trendy and comfortable hoodies for everyday wear.'],
            ['name' => 'Pants', 'description' => 'A range of pants, from formal to casual styles, for any occasion.'],
            ['name' => 'Accessories', 'description' => 'Enhance your style with a variety of modern accessories.'],
        ]);
        
    }
}
