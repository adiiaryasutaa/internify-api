<?php

declare(strict_types=1);

namespace App\Actions\Application\Contracts;

use App\Models\Application;

interface UpdatesApplications
{
    public function update(Application $application, array $inputs);
}
