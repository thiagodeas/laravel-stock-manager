<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Alimentos']);
        Category::create(['name' => 'Bebidas']);
        Category::create(['name' => 'Higiene e Limpeza']);
    }
}
