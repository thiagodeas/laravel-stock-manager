<?php

namespace App\Repositories;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Collection;

interface EntryRepositoryInterface 
{
    public function create(array $data): Entry;
    public function getAll(): Collection;
    public function getById(string $id): ?Entry;
    public function delete($id): bool;
}   