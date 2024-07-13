<?php

namespace App\Exceptions;

use Exception;

class VoucherCodeNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Voucher code not found', 404);
    }
}
