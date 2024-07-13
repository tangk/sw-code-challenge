<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\VoucherCodeResource;
use App\Services\API\VoucherCodeService;
use Exception;
use Illuminate\Http\JsonResponse;

class VoucherCodeController extends Controller
{
    private VoucherCodeService $voucherCodeService;

    public function __construct(VoucherCodeService $voucherCodeService)
    {
        $this->voucherCodeService = $voucherCodeService;
    }

    public function create(): JsonResponse
    {
        $data = $this->voucherCodeService->create();
        return $this->sendResponse(new VoucherCodeResource($data), 201);
    }

    public function index(): JsonResponse
    {
        $data = $this->voucherCodeService->index();
        return $this->sendResponse(VoucherCodeResource::collection($data), 200);
    }

    public function delete(int $id): JsonResponse
    {
        $data = $this->voucherCodeService->delete($id);
        return $this->sendResponse($data, 204);
    }
}
