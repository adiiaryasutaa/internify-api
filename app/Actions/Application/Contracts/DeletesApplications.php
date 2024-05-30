<?php

declare(strict_types=1);

namespace App\Actions\Application\Contracts;

use App\Models\Application;

interface DeletesApplications
{
    public function delete(Application $application);
}
