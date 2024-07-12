<?php

namespace App\Http\Controllers\API;

abstract class Controller
{
    public array $response;

    public function __construct()
    {
        $this->response = ['code' => 200];
    }
}
