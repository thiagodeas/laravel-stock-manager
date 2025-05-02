<?php

namespace App\Repositories\Output;

use App\Models\Output;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;

interface OutputRepositoryInterface
{
    public function create(array $data): Output; 
    public function getAll(): Collection;
    public function getById(string $id): Output;
    public function getByProductId(string $productId): Collection;
    public function getByDateRange(DateTimeInterface $startDate, DateTimeInterface $endDate): Collection;
}