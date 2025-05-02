<?php

namespace App\Repositories\Output;

use App\Models\Output;
use DateTimeInterface;
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

    public function getById(string $id): Output
    {
        return Output::with('product')->find($id);
    }

    public function getByProductId(string $productId): Collection
    {
        return Output::where('product_id', $productId)->get();
    }

    public function getByDateRange(DateTimeInterface $startDate, DateTimeInterface $endDate): Collection
    {
        return Output::whereBetween('output_date', [$startDate, $endDate])->get();
    }
}