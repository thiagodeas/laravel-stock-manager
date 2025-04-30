<?php

namespace App\Http\Controllers\Entry;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entry\CreateEntryRequest;
use App\Http\Requests\Entry\GetEntriesByDateRangeRequest;
use App\Services\Entry\EntryService;
use Illuminate\Http\JsonResponse;

class EntryController extends Controller
{
    protected EntryService $entryService;

    public function __construct(EntryService $entryService)
    {
        $this->entryService = $entryService;
    }

    public function getAll(): JsonResponse
    {
        $entries = $this->entryService->getAllEntries();

        return response()->json($entries);
    }

    public function create(CreateEntryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $entry = $this->entryService->createEntry($data);

        return response()->json($entry, 201);
    }

    public function getById(string $id): JsonResponse
    {
        $entry = $this->entryService->getEntryById($id);

        return response()->json($entry);
    }

    public function getByProductId(string $productId): JsonResponse
    {
        $entries = $this->entryService->getEntriesByProductId($productId);

        return response()->json($entries);
    }

    public function getByDateRange(GetEntriesByDateRangeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $entries = $this->entryService->getEntriesByDateRange($data['start_date'], $data['end_date']);

        return response()->json($entries);
    }
}