<?php

declare(strict_types=1);

namespace App\Actions\User\Contracts;

use App\Models\User;

interface UpdatesUsers
{
    public function update(User $user, array $inputs);
}
