<?php

namespace Api\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout()
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

        $token = $response->original['access_token'];
        $response = $this->postJson('/api/v1/auth/logout', headers: [
            'Authorization' => 'Bearer '.$token,
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
    }

    public function test_logout_failed()
    {
        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertUnauthorized();
        $response->assertJsonStructure(['message']);
    }
}
