<?php

namespace Api\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_login()
    {
        $user = User::factory()
            ->asAdmin()
            ->for(Admin::factory()->owner(), 'userable')
            ->create();

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();

        $response->assertJsonStructure(['message', 'access_token', 'token_type']);
    }

    public function test_login_failed()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'wrong@email.com',
            'password' => 'password',
        ]);

        $response->assertUnauthorized();

        $response->assertJsonStructure(['message']);
    }
}
