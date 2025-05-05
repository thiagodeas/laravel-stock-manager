<?php

namespace App\Services\Output;

use App\Models\Output;
use App\Repositories\Output\OutputRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

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
                throw new ModelNotFoundException('Product not found');
            }

            if ($product->quantity < $data['quantity']) {
                throw new InvalidArgumentException('Insufficient product quantity in stock');
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

    public function getOutputById($id): Output
    {
        $output = $this->outputRepository->getById($id);

        if(!$output) {
            throw new ModelNotFoundException('Output not found');
        }

        return $output;
    }

    public function getOutputsByProductId(string $productId): Collection
    {
        return $this->outputRepository->getByProductId($productId);
    }

    public function getOutputsByDateRange(Carbon $startDate, Carbon $endDate): Collection
    {   
        return $this->outputRepository->getByDateRange($startDate, $endDate);
    }
}