<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Actions\Auth\Contracts\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class AuthenticateUser implements AuthenticatesUsers
{
    public function authenticate(User|array $credentials): array|false
    {
        if (is_a($credentials, User::class)) {
            $user = $credentials;
        } else {
            $user = User::query()
                ->whereEmail($credentials['email'])
                ->first(['id', 'password'])
                ?? User::query()
                    ->whereUsername($credentials['email'])
                    ->first(['id', 'password']);

            if ( ! $user) {
                return false;
            }
        }

        $user = $user->setVisible(['password']);

        if ( ! Hash::check($credentials['password'], $user->password)) {
            return false;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }
}
