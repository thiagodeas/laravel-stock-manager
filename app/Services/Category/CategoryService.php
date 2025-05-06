<?php

namespace App\Services\Category;

use App\Exceptions\Category\CategoryNotFoundException;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class CategoryService 
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory(array $data): Category
    {
        $existingCategory = $this->categoryRepository->getByName($data['name']);

        if($existingCategory) {
            throw new InvalidArgumentException('The category already exists.');
        }

        return $this->categoryRepository->create($data);
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function getCategoryById(string $id): Category
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            throw new CategoryNotFoundException();
        }

        return $category;
    }

    public function getCategoryByName(string $name): Category
    {
        $category = $this->categoryRepository->getByName($name);

        if (!$category) {
            throw new ModelNotFoundException('Category not found');
        }

        return $category;
    }

    public function deleteCategory(string $id): bool
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            throw new ModelNotFoundException('Category not found.');
        }

        return $this->categoryRepository->delete($id);
    }
}