<?php

namespace App\Exceptions;

use Exception;

class VoucherCodeLimitReachedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Voucher code limit reached', 400);
    }
}
