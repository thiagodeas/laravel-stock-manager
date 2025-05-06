<?php

namespace App\Services\Category;

use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryAlreadyExistsException;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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
            throw new CategoryAlreadyExistsException();
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
            throw new CategoryNotFoundException();
        }

        return $category;
    }

    public function deleteCategory(string $id): bool
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            throw new CategoryNotFoundException();
        }

        return $this->categoryRepository->delete($id);
    }
}