<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function getAll(): Collection
    {
        return Product::all();
    }

    public function findById(string $id): ?Product
    {
        return Product::find($id);
    }

    public function findByName(string $name): ?Product
    {
        return Product::where('name', $name)->first();
    }

    public function update(string $id, array $data): ?Product
    {
        $product = $this->findById($id);

        if ($product) {
            $product->update($data);
            return $product;
        }

        return null;
    }

    public function delete(string $id): void
    {
        $product = $this->findById($id);

        if($product) {
            $product->delete();
        }
    }
}