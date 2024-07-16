<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VoucherCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class VoucherCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_voucher_codes(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->postJson($this->getApiPrefix() . '/voucher');
        $response->assertStatus(201);
        $response->assertJsonStructure(['data']);
        $this->assertDatabaseHas('voucher_codes', ['id' => 1]);

        $response = $this->getJson($this->getApiPrefix() . '/voucher');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_get_voucher_codes_exception(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->mock(\App\Services\API\VoucherCodeService::class, function ($mock) {
            $mock->shouldReceive('index')
                ->andThrow(new \Exception('Error', 500));
        });

        $response = $this->getJson($this->getApiPrefix() . '/voucher');

        $response->assertStatus(500);
        $response->assertJsonStructure(['error']);
    }
    public function test_create_voucher_code(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->postJson($this->getApiPrefix() . '/voucher');

        $response->assertStatus(201);
        $response->assertJsonStructure(['data']);
        $this->assertDatabaseHas('voucher_codes', ['id' => 1]);
    }

    public function test_create_voucher_code_more_than_10(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        for ($i = 0; $i < 10; $i++) {
            VoucherCode::factory()->create(['user_id' => $user->id]);
        }

        $response = $this->postJson($this->getApiPrefix() . '/voucher');

        $response->assertStatus(400);
        $response->assertJsonStructure(['error']);
    }

    public function test_create_voucher_code_unauthenticated(): void
    {
        $response = $this->postJson($this->getApiPrefix() . '/voucher');

        $response->assertStatus(401);
    }

    public function test_delete_voucher_code(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->postJson($this->getApiPrefix() . '/voucher');
        $this->assertDatabaseHas('voucher_codes', ['id' => 1]);

        $response = $this->deleteJson($this->getApiPrefix() . '/voucher/1');

        $response->assertStatus(204);
        $response->assertNoContent();
        $this->assertDatabaseMissing('voucher_codes', ['id' => 1]);
    }

    public function test_delete_voucher_code_unauthenticated(): void
    {
        $response = $this->deleteJson($this->getApiPrefix() . '/voucher/1');

        $response->assertStatus(401);
    }

    public function test_delete_voucher_code_not_found(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->deleteJson($this->getApiPrefix() . '/voucher/1');

        $response->assertStatus(404);
    }
}
