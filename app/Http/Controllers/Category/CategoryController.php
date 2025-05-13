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

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Create a new category (requires an admin role JWT token)",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - User is not authorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Forbidden")
     *         )
     *     )
     * )
     */
    public function create(CreateCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());

        return response()->json($category, 201);
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     tags={"Categories"},
     *     summary="Retrieve all categories",
     *     @OA\Response(
     *         response=200,
     *         description="List of categories",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Category")
     *         )
     *     )
     * )
     */
    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all categories",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Category")
     *         )
     *     )
     * )
     */
    public function getAll(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return response()->json($categories);
    }

    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Get a category by ID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category details",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function getById(string $id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);

        return response()->json($category);
    }

    /**
     * @OA\Get(
     *     path="/categories/search",
     *     summary="Get a category by name",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Name of the category",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category details",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function getByName(GetCategoryByNameRequest $request): JsonResponse
    {
        $name = $request->query('name');
        
        $category = $this->categoryService->getCategoryByName($name);

        return response()->json($category);
    }

    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     summary="Delete a category by ID (requires an admin role JWT token)",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Category deleted successfully"
     *     )
     * )
     */
    public function delete(string $id): JsonResponse
    {
        $category = $this->categoryService->deleteCategory($id);

        return response()->json(null, 204);
    }
}
