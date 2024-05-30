<?php

declare(strict_types=1);

namespace App\Actions\Application;

use App\Actions\Application\Contracts\DeletesApplications;
use App\Models\Application;

final class DeleteApplication implements DeletesApplications
{
    public function delete(Application $application): bool
    {
        return $application->delete();
    }
}
