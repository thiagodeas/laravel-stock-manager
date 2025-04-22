<?php

namespace Database\Seeders;

use App\Models\Entry;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            Entry::create([
                'product_id' => $product->id,
                'quantity' => rand(10, 40),
                'reason' => 'Compra',
                'entry_date' => now(),
            ]);
        }

        $this->command->info('Entries seeded successfully.');
    }
}
