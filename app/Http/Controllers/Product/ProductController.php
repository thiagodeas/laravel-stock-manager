<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAll(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return response()->json($products);
    }

    public function create(CreateProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $product = $this->productService->createProduct($data);

        return response()->json($product, 201);
    }

    public function getById(string $id): JsonResponse 
    {
        $product = $this->productService->findProductById($id);

        return response()->json($product);
    }

    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();
        $updatedProduct = $this->productService->updateProduct($id, $data);

        return response()->json($updatedProduct);
    }

    public function delete(string $id): JsonResponse
    {
        $this->productService->deleteProduct($id);

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
