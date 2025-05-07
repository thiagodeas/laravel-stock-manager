<?php

namespace App\Services\Output;

use App\Exceptions\InvalidDateRangeException;
use App\Exceptions\Output\OutputNotFoundException;
use App\Exceptions\Product\InsufficientStockException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Output;
use App\Repositories\Output\OutputRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OutputService
{
    protected OutputRepositoryInterface $outputRepository;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        OutputRepositoryInterface $outputRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->outputRepository = $outputRepository;
        $this->productRepository = $productRepository;
    }

    public function createOutput(array $data): Output
    {
        return DB::transaction(function () use($data) {
            $product = $this->productRepository->findById($data['product_id']);

            if (!$product) {
                throw new ProductNotFoundException();
            }

            if ($product->quantity < $data['quantity']) {
                throw new InsufficientStockException();
            }

            $product->quantity -= $data['quantity'];
            $product->save();

            $data['output_date'] = Carbon::today()->toDateString();

            return $this->outputRepository->create($data);
        });
    }

    public function getAllOutputs(): Collection
    {
        return $this->outputRepository->getAll();
    }

    public function getOutputById($id): ?Output
    {
        $output = $this->outputRepository->getById($id);

        if(!$output) {
            throw new OutputNotFoundException();
        }

        return $output;
    }

    public function getOutputsByProductId(string $productId): Collection
    {
        $outputs = $this->outputRepository->getByProductId($productId);

        if($outputs->isEmpty()) {
            throw new ProductNotFoundException();
        }

        return $outputs;
    }

    public function getOutputsByDateRange(?Carbon $startDate, ?Carbon $endDate): Collection
    {   
        if(!$startDate || !$endDate) {
            throw new InvalidDateRangeException();
        }

        return $this->outputRepository->getByDateRange($startDate, $endDate);
    }
}