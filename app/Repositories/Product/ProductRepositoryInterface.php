<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function create(array $data): Product;
    public function getAll(): Collection;
    public function findById(string $id): ?Product;
    public function findByName(string $name): ?Product;
    public function update(string $id, array $data): ?Product;
    public function delete(string $id): void;
}