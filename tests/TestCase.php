<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getApiPrefix(): string
    {
        return '/api/' . config('app.api_version');
    }
}
