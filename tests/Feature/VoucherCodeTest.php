<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class VoucherCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_voucher_code(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->postJson('/api/voucher');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_create_voucher_code_unauthenticated(): void
    {
        $response = $this->postJson('/api/voucher');

        $response->assertStatus(401);
    }
}
