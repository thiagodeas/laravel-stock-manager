<?php

namespace App\Http\Controllers\Entry;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entry\CreateEntryRequest;
use App\Http\Requests\GetByDateRangeRequest;
use App\Services\Entry\EntryService;
use Illuminate\Http\JsonResponse;

class EntryController extends Controller
{
    protected EntryService $entryService;

    public function __construct(EntryService $entryService)
    {
        $this->entryService = $entryService;
    }

    /**
     * @OA\Get(
     *     path="/api/entries",
     *     summary="Get all entries",
     *     tags={"Entries"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all entries",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Entry")
     *         )
     *     )
     * )
     */
    public function getAll(): JsonResponse
    {
        $entries = $this->entryService->getAllEntries();

        return response()->json($entries);
    }

    /**
     * @OA\Post(
     *     path="/api/entries",
     *     summary="Create a new entry",
     *     tags={"Entries"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateEntryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Entry created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Entry")
     *     )
     * )
     */
    public function create(CreateEntryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $entry = $this->entryService->createEntry($data);

        return response()->json($entry, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/entries/{id}",
     *     summary="Get an entry by ID",
     *     tags={"Entries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the entry",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entry details",
     *         @OA\JsonContent(ref="#/components/schemas/Entry")
     *     )
     * )
     */
    public function getById(string $id): JsonResponse
    {
        $entry = $this->entryService->getEntryById($id);

        return response()->json($entry);
    }

    /**
     * @OA\Get(
     *     path="/api/entries/product/{productId}",
     *     summary="Get entries by product ID",
     *     tags={"Entries"},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of entries for the specified product",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Entry")
     *         )
     *     )
     * )
     */
    public function getByProductId(string $productId): JsonResponse
    {
        $entries = $this->entryService->getEntriesByProductId($productId);

        return response()->json($entries);
    }

    /**
     * @OA\Post(
     *     path="/api/entries/date-range",
     *     summary="Get entries by date range",
     *     tags={"Entries"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"start_date", "end_date"},
     *             @OA\Property(property="start_date", type="string", format="date", example="2023-01-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2023-01-31")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of entries within the specified date range",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Entry")
     *         )
     *     )
     * )
     */
    public function getByDateRange(GetByDateRangeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $entries = $this->entryService->getEntriesByDateRange($data['start_date'], $data['end_date']);

        return response()->json($entries);
    }
}