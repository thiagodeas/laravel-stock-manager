<?php

namespace App\Services\Entry;

use App\Exceptions\Entry\EntryNotFoundException;
use App\Exceptions\Entry\InvalidDateRangeException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Entry;
use App\Repositories\Entry\EntryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EntryService
{
    protected EntryRepositoryInterface $entryRepository;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        EntryRepositoryInterface $entryRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->entryRepository = $entryRepository;
        $this->productRepository = $productRepository;
    }

    public function createEntry(array $data): Entry
    {
        return DB::transaction(function () use ($data) {
            $product = $this->productRepository->findById($data['product_id']);

            if (!$product) {
            throw new ProductNotFoundException();
            }

            $product->quantity += $data['quantity'];
            $product->save();

            $data['entry_date'] = Carbon::today()->toDateString();

            return $this->entryRepository->create($data);
        });
    }

    public function getAllEntries(): Collection
    {
        return $this->entryRepository->getAll();
    }

    public function getEntryById($id): ?Entry
    {
        $entry = $this->entryRepository->getById($id);

        if (!$entry) {
            throw new EntryNotFoundException();
        }

        return $entry;
    }

    public function getEntriesByProductId(string $productId): Collection
    {
        $entries = $this->entryRepository->getByProductId($productId);

        if ($entries->isEmpty()) {
            throw new ProductNotFoundException();
        }

        return $entries;
    }

    public function getEntriesByDateRange(?Carbon $startDate, ?Carbon $endDate): Collection
    {
        if (!$startDate || !$endDate) {
            throw new InvalidDateRangeException(); 
        }

        return $this->entryRepository->getByDateRange($startDate, $endDate);
    }
}