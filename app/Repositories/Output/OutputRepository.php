<?php

namespace App\Repositories\Output;

use App\Models\Output;
use Illuminate\Database\Eloquent\Collection;

class OutputRepository implements OutputRepositoryInterface
{
    public function create(array $data): Output
    {
        return Output::create($data);
    }

    public function getAll(): Collection
    {
        return Output::with('product')->get();
    }

    public function getById(int $id): ?Output
    {
        return Output::with('product')->find($id);
    }

    public function getByProductId(string $productId): Collection
    {
        return Output::where('product_id', $productId)->get();
    }

    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return Output::whereBetween('output_date', [$startDate, $endDate])->get();
    }
}