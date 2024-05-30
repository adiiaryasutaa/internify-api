<?php

declare(strict_types=1);

namespace App\Actions\Apprentice;

use App\Actions\Apprentice\Contracts\DeletesApprentices;
use App\Actions\User\Contracts\DeletesUsers;
use App\Models\Apprentice;

final class DeleteApprentice implements DeletesApprentices
{
    public function __construct(protected DeletesUsers $userDeleter) {}

    public function delete(Apprentice $apprentice): bool
    {
        return $apprentice->delete() && $this->userDeleter->delete($apprentice->user);
    }
}
