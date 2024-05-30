<?php

declare(strict_types=1);

namespace App\Actions\User\Contracts;

use App\Models\Admin;
use App\Models\Apprentice;
use App\Models\Employer;

interface CreatesUsers
{
    public function createAsAdmin(Admin $admin, array $inputs);
    public function createAsEmployer(Employer $employer, array $inputs);
    public function createAsApprentice(Apprentice $apprentice, array $inputs);
}
