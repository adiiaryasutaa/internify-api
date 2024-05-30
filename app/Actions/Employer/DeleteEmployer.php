<?php

declare(strict_types=1);

namespace App\Actions\Employer;

use App\Actions\Employer\Contracts\DeletesEmployers;
use App\Actions\User\Contracts\DeletesUsers;
use App\Models\Employer;

final class DeleteEmployer implements DeletesEmployers
{
    public function __construct(protected DeletesUsers $userDeleter) {}

    public function delete(Employer $employer): bool
    {
        return $employer->delete() && $this->userDeleter->delete($employer->user);
    }
}
