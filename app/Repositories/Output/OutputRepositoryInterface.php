<?php

namespace App\Repositories\Output;

use App\Models\Output;
use Illuminate\Database\Eloquent\Collection;

interface OutputRepositoryInterface
{
    public function create(array $data): Output; 
    public function getAll(): Collection;
    public function getById(int $id): ?Output;
}