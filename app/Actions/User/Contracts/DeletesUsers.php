<?php

declare(strict_types=1);

namespace App\Actions\User\Contracts;

use App\Models\User;

interface DeletesUsers
{
    public function delete(User $user);
}
