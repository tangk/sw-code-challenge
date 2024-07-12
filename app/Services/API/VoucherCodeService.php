<?php

namespace App\Services\API;

use App\Models\VoucherCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VoucherCodeService
{
    public function create(int $id): VoucherCode
    {
        $code = Str::random(5);
        return VoucherCode::create(['user_id' => $id, 'code' => $code]);
    }
}
