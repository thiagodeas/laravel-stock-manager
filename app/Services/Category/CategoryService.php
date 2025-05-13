<?php

namespace App\Services\Category;

use App\Exceptions\Auth\ForbiddenException;
use App\Exceptions\Auth\TokenNotProvidedException;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryAlreadyExistsException;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoryService 
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory(array $data): Category
    {
        $authUser = JWTAuth::user(); 

        if (!$authUser) {
            throw new TokenNotProvidedException();
        }

        if ($authUser->role !== 'admin') {
            throw new ForbiddenException();
        }

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
        $authUser = JWTAuth::user(); 

        if (!$authUser) {
            throw new TokenNotProvidedException();
        }

        if ($authUser->role !== 'admin') {
            throw new ForbiddenException();
        }

        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            throw new CategoryNotFoundException();
        }

        return $this->categoryRepository->delete($id);
    }
}