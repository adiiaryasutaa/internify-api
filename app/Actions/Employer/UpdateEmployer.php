<?php

declare(strict_types=1);

namespace App\Actions\Employer;

use App\Actions\Employer\Contracts\GeneratesEmployersSlugs;
use App\Actions\Employer\Contracts\UpdatesEmployers;
use App\Actions\User\Contracts\UpdatesUsers;
use App\Models\Employer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class UpdateEmployer implements UpdatesEmployers
{
    private array $fills;

    public function __construct(
        Employer                          $employer,
        protected UpdatesUsers            $userUpdater,
        protected GeneratesEmployersSlugs $slugGenerator,
    ) {
        $this->fills = array_diff($employer->getFillable(), ['code', 'slug']);
    }

    public function update(Employer $employer, array $inputs)
    {
        return DB::transaction(function () use ($employer, $inputs) {
            $employer = $employer->loadMissing('user');

            $data = Arr::only($inputs, $this->fills);
            $data['slug'] = $this->slugGenerator->generate($inputs['name']);

            return $employer->update($data) && $this->userUpdater->update($employer->user, $inputs);
        });
    }
}
