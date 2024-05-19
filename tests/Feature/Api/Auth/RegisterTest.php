<?php

namespace Api\Auth;

use App\Enums\Role;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_register(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Adi Aryasuta',
            'username' => 'adiaryasuta',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => Role::EMPLOYER->value,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

    public function test_register_admin(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Adi Aryasuta',
            'username' => 'adiaryasuta',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => Role::ADMIN->value,
        ]);

        $response->assertJsonValidationErrorFor('role');
    }
}
