<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data): Product
    {   
        $existingProduct = $this->productRepository->findByName($data['name']);

        if($existingProduct) {
            throw new InvalidArgumentException('The product already exists.');
        }

        return $this->productRepository->create($data);
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function findProductById(string $id): ?Product
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            throw new ModelNotFoundException('Product not found.');
        }

        return $product;
    }

    public function findProductByName(string $name): ?Product
    {
        $product = $this->productRepository->findByName($name);

        if(!$product) {
            throw new ModelNotFoundException('Product not found.');
        }

        return $product;
    }

    public function updateProduct(string $id, array $data): bool
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            throw new ModelNotFoundException('Product not found.');
        }

        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(string $id): bool 
    {
        $product = $this->productRepository->findById($id);

        if(!$product) {
            throw new ModelNotFoundException('Product not found.');
        }
        return $this->productRepository->delete($id);
    }
}