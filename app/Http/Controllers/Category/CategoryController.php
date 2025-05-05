<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\GetCategoryByNameRequest;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(CreateCategoryRequest $request): JsonResponse
    {
        $product = $this->categoryService->createCategory($request->validated());

        return response()->json($product, 201);
    }

    public function getAll(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return response()->json($categories);
    }

    public function getById(string $id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);

        return response()->json($category);
    }

    public function getByName(GetCategoryByNameRequest $request): JsonResponse
    {
        $name = $request->query('name');
        
        $category = $this->categoryService->getCategoryByName($name);

        return response()->json($category);
    }
}
