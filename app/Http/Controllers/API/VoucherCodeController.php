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
        try {
            $data = $this->voucherCodeService->create();
            return $this->sendResponse(new VoucherCodeResource($data), 201);
        } catch (Exception $e) {
            return $this->sendResponse($e->getMessage(), $e->getCode());
        }
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->voucherCodeService->index();
            return $this->sendResponse($data, 200);
        } catch (Exception $e) {
            return $this->sendResponse($e->getMessage(), $e->getCode());
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $data = $this->voucherCodeService->delete($id);
            return $this->sendResponse($data, 204);
        } catch (Exception $e) {
            return $this->sendResponse($e->getMessage(), $e->getCode());
        }
    }
}
