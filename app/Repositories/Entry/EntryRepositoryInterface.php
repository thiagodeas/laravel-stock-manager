<?php

namespace App\Repositories\Entry;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Collection;

interface EntryRepositoryInterface 
{
    public function create(array $data): Entry;
    public function getAll(): Collection;
    public function getById(string $id): ?Entry;
    public function getByProductId(string $productId): Collection;
    public function getByDateRange(string $startDate, string $endDate): Collection;
}   