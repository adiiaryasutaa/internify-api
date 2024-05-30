<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Actions\Auth\Contracts\LogoutsUsers;
use App\Models\User;

final class LogoutUser implements LogoutsUsers
{
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
