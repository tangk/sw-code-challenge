<?php

namespace Tests\Feature;

use App\Models\User;
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

        $response = $this->postJson('/api/voucher');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
        $this->assertDatabaseHas('voucher_codes', ['id' => 1]);

        $response = $this->getJson('/api/voucher');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
        $response->assertJsonFragment(['id' => 1]);
    }
    public function test_create_voucher_code(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->postJson('/api/voucher');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
        $this->assertDatabaseHas('voucher_codes', ['id' => 1]);
    }

    public function test_create_voucher_code_unauthenticated(): void
    {
        $response = $this->postJson('/api/voucher');

        $response->assertStatus(401);
    }

    public function test_delete_voucher_code(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->postJson('/api/voucher');
        $this->assertDatabaseHas('voucher_codes', ['id' => 1]);

        $response = $this->deleteJson('/api/voucher/1');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
        $this->assertDatabaseMissing('voucher_codes', ['id' => 1]);
    }

    public function test_delete_voucher_code_unauthenticated(): void
    {
        $response = $this->deleteJson('/api/voucher/1');

        $response->assertStatus(401);
    }

    public function test_delete_voucher_code_not_found(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->deleteJson('/api/voucher/1');

        $response->assertStatus(404);
    }
}
