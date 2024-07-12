<?php

namespace App\Http\Controllers\API;

use App\Services\API\VoucherCodeService;
use Exception;
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
        $user = auth()->user();
        try {
            $this->response['data'] = $this->voucherCodeService->create($user->id);
        } catch (Exception $e) {
            $this->response = [ 'error' => $e->getMessage(), 'code' => 500,];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
