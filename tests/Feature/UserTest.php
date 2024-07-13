<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private array $validUserData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validUserData = [
            'username' => 'testuser',
            'first_name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
        ];
    }

    public function test_user_registration(): void
    {
        $response = $this->postJson('/api/user', $this->validUserData);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data']);
        $this->assertDatabaseHas('users', ['email' => $this->validUserData['email']]);
    }

    public function test_user_registration_exception(): void
    {
        $this->mock(\App\Services\API\UserService::class, function ($mock) {
            $mock->shouldReceive('create')
                ->andThrow(new \Exception('Error', 500));
        });

        $response = $this->postJson('/api/user', $this->validUserData);

        $response->assertStatus(500);
        $response->assertJsonStructure(['error']);
    }

    public function test_user_registration_with_invalid_data(): void
    {
        $response = $this->postJson('/api/user', array_merge($this->validUserData, ['email' => 'invalid']));

        $response->assertStatus(422);
        $response->assertJsonStructure(['error']);
    }

    public function test_user_registration_with_existing_email(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/user', [
            'username' => 'testuser2',
            'first_name' => 'Test',
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_user_registration_with_existing_username(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/user', [
            'username' => $user->username,
            'first_name' => 'Test',
            'email' => 'test2@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_user_registration_with_existing_username_and_email(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/user', [
            'username' => $user->username,
            'first_name' => 'Test',
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_user_registration_with_missing_data(): void
    {
        $response = $this->postJson('/api/user', [
            'username' => 'testuser2',
            'first_name' => 'Test',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error']);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_user_login(): void
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_user_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'invalid',
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['error']);
    }

    public function test_user_login_exception(): void
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $this->mock(\App\Services\API\UserService::class, function ($mock) {
            $mock->shouldReceive('login')
                ->andThrow(new \Exception('Error', 500));
        });

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(500);
        $response->assertJsonStructure(['error']);
    }
}
