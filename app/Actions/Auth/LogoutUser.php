<?php

namespace App\Actions\Auth;

use App\Actions\Auth\Contracts\LogoutsUsers;
use App\Models\User;

class LogoutUser implements LogoutsUsers
{
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
