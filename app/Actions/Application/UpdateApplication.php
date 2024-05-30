<?php

declare(strict_types=1);

namespace App\Actions\Application;

use App\Actions\Application\Contracts\UpdatesApplications;
use App\Models\Application;
use Illuminate\Support\Arr;

final class UpdateApplication implements UpdatesApplications
{
    private array $fills;

    public function __construct(Application $application)
    {
        $this->fills = Arr::except($application->getFillable(), ['apprentice_id', 'vacancy_id']);
    }
    public function update(Application $application, array $inputs): bool
    {
        $data = Arr::only($inputs, $this->fills);

        return $application->update($data);
    }
}
