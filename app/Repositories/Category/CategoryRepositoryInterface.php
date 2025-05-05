<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function create(array $data): Category;
    public function getAll(): Collection;
    public function getById(string $id): Category;
    public function getByName(string $name): Category;
    public function delete(string $id): bool;
}