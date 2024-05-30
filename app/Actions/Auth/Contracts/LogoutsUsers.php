<?php

declare(strict_types=1);

namespace App\Actions\Auth\Contracts;

use App\Models\User;

interface LogoutsUsers
{
    public function logout(User $user);
}
