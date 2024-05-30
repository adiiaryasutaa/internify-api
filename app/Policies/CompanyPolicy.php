<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Company;
use App\Models\Employer;
use App\Models\User;

final class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->isAdmin();
    }

    public function view(User $user, Company $company, Employer|null $employer = null): bool
    {
        if ($employer) {
            return $employer->loadMissing('company')->company->is($company);
        }

        return $user->role->isAdmin();
    }

    public function create(User $user, Employer|null $employer = null): bool
    {
        if ($employer) {
            return $employer->loadMissing('company')->company()->doesntExist();
        }

        return $user->role->isAdmin() && Employer::exists();
    }

    public function update(User $user, Company $company, Employer|null $employer = null): bool
    {
        return $this->view($user, $company, $employer);
    }

    public function delete(User $user, Company $company, Employer|null $employer = null): bool
    {
        return $this->view($user, $company, $employer);
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
