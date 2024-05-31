<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_login(): void
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
    }

    public function test_login_failed(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'wrong@email.com',
            'password' => 'password',
        ]);

        $response->assertUnauthorized();
        $response->assertJsonStructure(['message']);
    }
}
