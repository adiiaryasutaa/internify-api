<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Company;
use App\Models\Employer;
use App\Models\User;

final class CompanyPolicy
{
    public function viewAny(User $user, ?Employer $employer = null): bool
    {
        return true;
    }

    public function view(User $user, Company $company, ?Employer $employer = null): bool
    {
        return true;
    }

    public function create(User $user, ?Employer $employer = null): bool
    {
        if ($employer) {
            return $employer->loadMissing('company')->company()->doesntExist();
        }

        return $user->role->isAdmin() && Employer::exists();
    }

    public function update(User $user, Company $company, ?Employer $employer = null): bool
    {
        return $user->role->isAdmin() || ($employer && $company->loadMissing('employer')->employer->is($employer));
    }

    public function delete(User $user, Company $company, Employer|null $employer = null): bool
    {
        return $user->role->isAdmin();
    }

    public function restore(User $user, Company $company): bool
    {
        return $user->role->isAdmin();
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return false;
    }
}
