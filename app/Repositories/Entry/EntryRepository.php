<?php

namespace App\Repositories\Entry;

use App\Models\Entry;
use App\Repositories\EntryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EntryRepository implements EntryRepositoryInterface
{
    public function create(array $data): Entry
    {
        return Entry::create($data);
    }

    public function getAll(): Collection
    {
        return Entry::with('product')->get();
    }

    public function getById($id): ?Entry
    {
        return Entry::with('product')->find($id);
    }

    public function delete($id): bool
    {
        $entry = Entry::find($id);
        if ($entry) {
            return $entry->delete();
        }

        return false;
    }
}