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

    public function getAll(): JsonResponse
    {
        $outputs = $this->outputService->getAllOutputs();

        return response()->json($outputs);
    }

    public function create(CreateOutputRequest $request): JsonResponse
    {
        $data = $request->validated();
        $output = $this->outputService->createOutput($data);

        return response()->json($output, 201);
    }

    public function getById(string $id): JsonResponse
    {
        $output = $this->outputService->getOutputById($id);

        return response()->json($output);
    }

    public function getByProductId(string $productId): JsonResponse
    {
        $outputs = $this->outputService->getOutputsByProductId($productId);

        return response()->json($outputs);
    }

    public function getByDateRange(GetByDateRangeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $outputs = $this->outputService->getOutputsByDateRange($data['start_date'], $data['end_date']);

        return response()->json($outputs);
    }
}