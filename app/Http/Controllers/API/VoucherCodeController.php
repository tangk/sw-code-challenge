<?php

namespace App\Http\Controllers\API;

use App\Services\API\VoucherCodeService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class VoucherCodeController extends Controller
{
    private VoucherCodeService $voucherCodeService;

    public function __construct(VoucherCodeService $voucherCodeService)
    {
        parent::__construct();
        $this->voucherCodeService = $voucherCodeService;
    }
    public function create(): JsonResponse
    {
        try {
            $this->response['data'] = $this->voucherCodeService->create();
        } catch (Exception $e) {
            $this->response = [ 'error' => $e->getMessage(), 'code' => $e->getCode() ?? 500,];
        }

        return response()->json($this->response, $this->response['code']);
    }

    public function index(): JsonResponse
    {
        try {
            $this->response['data'] = $this->voucherCodeService->index();
        } catch (Exception $e) {
            $this->response = [ 'error' => $e->getMessage(), 'code' => $e->getCode() ?? 500,];
        }

        return response()->json($this->response, $this->response['code']);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->response['data'] = $this->voucherCodeService->delete($id);
        } catch (Exception $e) {
            $this->response = [ 'error' => $e->getMessage(), 'code' => $e->getCode() ?? 500,];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
