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

    public function update(string $id, array $data): bool
    {
        $product = $this->findById($id);

        if ($product) {
            return $product->update($data);
        }

        return false;
    }

    public function delete(string $id): bool
    {
        $product = $this->findById($id);

        if($product) {
            return $product->delete();
        }

        return false;
    }
}