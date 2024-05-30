<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\Contracts\DeletesUsers;
use App\Models\User;

final class DeleteUser implements DeletesUsers
{
    public function delete(User $user): bool
    {
        $user->getFirstMedia('avatar')?->delete();

        return $user->delete();
    }
}
