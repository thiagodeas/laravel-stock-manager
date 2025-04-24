<?php

namespace App\Services\Entry;

use App\Models\Entry;
use App\Repositories\EntryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

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
        $product = $this->productRepository->findById($data['product_id']);

        if (!$product) {
            throw new InvalidArgumentException('Product not found.');
        }

        return $this->entryRepository->create($data);
    }

    public function getAllEntries(): Collection
    {
        return $this->entryRepository->getAll();
    }

    public function getById($id): ?Entry
    {
        $entry = $this->entryRepository->getById($id);

        if (!$entry) {
            throw new ModelNotFoundException('Entry not found.');
        }

        return $entry;
    }

    public function delete($id): bool
    {
        $entry = $this->entryRepository->getById($id);

        if (!$entry) {
            throw new ModelNotFoundException('Entry not found.');
        }

        return $this->entryRepository->delete($id);
    }
}