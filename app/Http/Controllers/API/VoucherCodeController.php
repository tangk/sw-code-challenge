<?php

namespace App\Http\Controllers\API;

use App\Models\VoucherCode;
use Exception;
use Illuminate\Support\Str;

class VoucherCodeController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        try {
            $code = Str::random(5);
            $voucherCode = VoucherCode::create(['user_id' => $user->id, 'code' => $code]);
            $this->response['data'] = $voucherCode->toArray();
        } catch (Exception $e) {
            $this->response = [ 'error' => $e->getMessage(), 'code' => 500,];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
