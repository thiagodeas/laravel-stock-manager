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
}