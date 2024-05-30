<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Enums\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use function str;

use Tests\TestCase;

final class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_register(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => $name = $this->faker->name,
            'username' => $username = str($name)->lower()->replace(' ', '')->substr(0, 19),
            'email' => "{$username}@gmail.com",
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => Role::EMPLOYER->value,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

    public function test_register_admin(): void
    {
        $response = $this->postJson(route('register'), [
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
