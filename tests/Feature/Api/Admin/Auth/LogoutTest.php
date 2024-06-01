<?php

declare(strict_types=1);

namespace Api\Admin\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout(): void
    {
        $user = User::factory()
            ->asAdmin()
            ->for(Admin::factory()->owner(), 'userable')
            ->create();
        $this->assertModelExists($user);
        $this->assertModelExists($user->userable);

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['message', 'access_token', 'token_type']);

        $token = $response->original['access_token'];
        $response = $this->postJson(route('logout'), headers: [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
    }

    public function test_logout_failed(): void
    {
        $response = $this->postJson(route('logout'));

        $response->assertUnauthorized();
        $response->assertJsonStructure(['message']);
    }
}
