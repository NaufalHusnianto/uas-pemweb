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
            ['name' => 'Shoes', 'description' => 'Discover a wide range of footwear, from casual sneakers to elegant formal shoes.'],
            ['name' => 'Shirt', 'description' => 'High-quality shirts perfect for formal events or casual outings.'],
            ['name' => 'Jacket', 'description' => 'Stay warm and stylish with our durable and trendy jackets.'],
            ['name' => 'Hoodie', 'description' => 'Soft and cozy hoodies ideal for relaxing or staying fashionable on the go.'],
            ['name' => 'Pants', 'description' => 'Versatile pants designed for comfort and style in every setting.'],
            ['name' => 'Accessories', 'description' => 'Add the perfect finishing touch to your outfit with our chic accessories.'],
            ['name' => 'Bags', 'description' => 'Functional and fashionable bags to carry all your essentials with ease.'],
            ['name' => 'Man', 'description' => 'Modern and sophisticated styles crafted exclusively for men.'],
            ['name' => 'Women', 'description' => 'Elegant and fashionable collections tailored for women.'],
            ['name' => 'Kids', 'description' => 'Adorable and durable items designed with kids in mind.'],
            ['name' => 'New', 'description' => 'Explore our latest arrivals with fresh and innovative designs.'],
            ['name' => 'BestSale', 'description' => 'Grab the hottest deals on our best-selling products.'],
            ['name' => 'Trending', 'description' => 'Stay ahead of the curve with our trending and most-loved items.'],
        ]);
    }
}
