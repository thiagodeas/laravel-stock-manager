<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function getAll(): Collection
    {
        return Category::all();
    }

    public function getById(string $id): ?Category
    {
        return Category::find($id);
    }

    public function getByName(string $name): ?Category
    {
        return Category::where('name', $name)->first();
    }

    public function delete(string $id): bool
    {
        $category = $this->getById($id);

        if ($category) {
            return $category->delete();
        }

        return false;
    }
}