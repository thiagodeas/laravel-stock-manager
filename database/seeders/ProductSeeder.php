<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if($categories->isEmpty()) {
            $this->command->error('No categories found. Run the CategorySeeder first.');
            return;
        }

        foreach($categories as $category) {
            Product::create([
                'name' => "Produto da categoria {$category->name}",
                'category_id' => $category->id,
                'price' => rand(100, 10000) / 100
            ]);
        }

        $this->command->info('Products seeded successfully.');
    }
}
