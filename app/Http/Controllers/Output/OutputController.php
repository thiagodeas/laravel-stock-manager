<?php

namespace App\Http\Controllers\Output;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetByDateRangeRequest;
use App\Http\Requests\Output\CreateOutputRequest;
use App\Services\Output\OutputService;
use Illuminate\Http\JsonResponse;

class OutputController extends Controller
{
    protected OutputService $outputService;

    public function __construct(OutputService $outputService)
    {
        $this->outputService = $outputService;
    }

    /**
     * @OA\Get(
     *     path="/outputs",
     *     summary="Get all outputs",
     *     tags={"Outputs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all outputs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Output")
     *         )
     *     )
     * )
     */
    public function getAll(): JsonResponse
    {
        $outputs = $this->outputService->getAllOutputs();

        return response()->json($outputs);
    }

    /**
     * @OA\Post(
     *     path="/outputs",
     *     summary="Create a new output",
     *     tags={"Outputs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateOutputRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Output created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Output")
     *     )
     * )
     */
    public function create(CreateOutputRequest $request): JsonResponse
    {
        $data = $request->validated();
        $output = $this->outputService->createOutput($data);

        return response()->json($output, 201);
    }

    /**
     * @OA\Get(
     *     path="/outputs/{id}",
     *     summary="Get an output by ID",
     *     tags={"Outputs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the output",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Output details",
     *         @OA\JsonContent(ref="#/components/schemas/Output")
     *     )
     * )
     */
    public function getById(string $id): JsonResponse
    {
        $output = $this->outputService->getOutputById($id);

        return response()->json($output);
    }

    /**
     * @OA\Get(
     *     path="/outputs/product/{productId}",
     *     summary="Get outputs by product ID",
     *     tags={"Outputs"},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of outputs for the specified product",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Output")
     *         )
     *     )
     * )
     */
    public function getByProductId(string $productId): JsonResponse
    {
        $outputs = $this->outputService->getOutputsByProductId($productId);

        return response()->json($outputs);
    }

    /**
     * @OA\Post(
     *     path="/outputs/date-range",
     *     summary="Get outputs by date range",
     *     tags={"Outputs"},
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
     *         description="List of outputs within the specified date range",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Output")
     *         )
     *     )
     * )
     */
    public function getByDateRange(GetByDateRangeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $outputs = $this->outputService->getOutputsByDateRange($data['start_date'], $data['end_date']);

        return response()->json($outputs);
    }
}