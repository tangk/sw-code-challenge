<?php

namespace App\Services\API;

use App\Exceptions\VoucherCodeLimitReachedException;
use App\Exceptions\VoucherCodeNotFoundException;
use App\Models\VoucherCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class VoucherCodeService
{
    const MAX_VOUCHER_CODES = 10;
    const VOUCHER_CODE_LENGTH = 5;

    /**
     * @throws VoucherCodeLimitReachedException
     */
    public function create(): VoucherCode
    {
        $user = auth()->user();
        $count = $user->voucherCodes->count();

        if ($count >= self::MAX_VOUCHER_CODES) {
            throw new VoucherCodeLimitReachedException();
        }

        do {
            $code = strtoupper(Str::random(self::VOUCHER_CODE_LENGTH));
        } while ($user->voucherCodes()->where('code', $code)->exists());

        return $user->voucherCodes()->create(['code' => $code]);
    }

    /**
     * @throws VoucherCodeNotFoundException
     */
    public function delete(int $id): bool
    {
        $user = auth()->user();
        try {
            $voucherCode = $user->voucherCodes()->findOrFail($id);
            return $voucherCode->delete();
        } catch (ModelNotFoundException $e) {
            throw new VoucherCodeNotFoundException();
        }
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        $user = auth()->user();
        return $user->voucherCodes;
    }
}
