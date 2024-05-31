<?php

declare(strict_types=1);

namespace App\Actions\Employer;

use App\Actions\Employer\Contracts\CreatesEmployers;
use App\Actions\Employer\Contracts\GeneratesEmployersCodes;
use App\Actions\Employer\Contracts\GeneratesEmployersSlugs;
use App\Actions\User\Contracts\CreatesUsers;
use App\Models\Employer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class CreateEmployer implements CreatesEmployers
{
    private array $fills;

    public function __construct(
        Employer                          $employer,
        protected CreatesUsers            $userCreator,
        protected GeneratesEmployersCodes $codeGenerator,
        protected GeneratesEmployersSlugs $slugGenerator,
    ) {
        $this->fills = array_diff($employer->getFillable(), ['code', 'slug']);
    }

    public function create(array $inputs): Employer
    {
        return DB::transaction(function () use ($inputs) {
            $data = Arr::only($inputs, $this->fills);
            $data['code'] = $this->codeGenerator->generate();
            $data['slug'] = $this->slugGenerator->generate($inputs['name']);

            return tap(
                Employer::create($data),
                fn(Employer $employer) => $this->userCreator->createAsEmployer($employer, $inputs),
            );
        });
    }
}
