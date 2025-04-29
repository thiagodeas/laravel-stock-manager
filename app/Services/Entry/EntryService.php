<?php

namespace App\Services\Entry;

use App\Models\Entry;
use App\Repositories\Entry\EntryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
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
            throw new ModelNotFoundException('Product not found.');
            }

            $product->quantity += $data['quantity'];
            $product->save();

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
            throw new ModelNotFoundException('Entry not found.');
        }

        return $entry;
    }

    public function getEntriesByProductId(string $productId): Collection
    {
        return $this->entryRepository->getByProductId($productId);
    }

    public function getEntriesByDateRange(string $startDate, string $endDate): Collection
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        return $this->entryRepository->getByDateRange($startDate, $endDate);
    }
}