<?php

namespace App\Services\Product;

use App\Exceptions\Product\ProductAlreadyExistsException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            throw new ProductAlreadyExistsException();
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
            throw new ProductNotFoundException();
        }

        return $product;
    }

    public function findProductByName(string $name): ?Product
    {
        $product = $this->productRepository->findByName($name);

        if(!$product) {
            throw new ProductNotFoundException();
        }

        return $product;
    }

    public function updateProduct(string $id, array $data): ?Product
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(string $id): void 
    {
        $product = $this->productRepository->findById($id);

        if(!$product) {
            throw new ProductNotFoundException();
        }
        
        $this->productRepository->delete($id);
    }
}