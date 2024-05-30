<?php

declare(strict_types=1);

namespace App\Actions\Apprentice;

use App\Actions\Apprentice\Contracts\CreatesApprentices;
use App\Actions\Apprentice\Contracts\GeneratesApprenticesCodes;
use App\Actions\Apprentice\Contracts\GeneratesApprenticesSlugs;
use App\Actions\User\Contracts\CreatesUsers;
use App\Models\Apprentice;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class CreateApprentice implements CreatesApprentices
{
    private array $fills;

    public function __construct(
        Apprentice                          $apprentice,
        protected CreatesUsers              $userCreator,
        protected GeneratesApprenticesCodes $codeGenerator,
        protected GeneratesApprenticesSlugs $slugGenerator,
    ) {
        $this->fills = $apprentice->getFillable();
    }

    public function create(array $inputs): Apprentice
    {
        return DB::transaction(function () use ($inputs) {
            $data = Arr::only($inputs, $this->fills);
            $data['code'] = $this->codeGenerator->generate();
            $data['slug'] = $this->slugGenerator->generate($inputs['name']);

            return tap(
                Apprentice::create($data),
                fn(Apprentice $apprentice) => $this->userCreator->createAsApprentice($apprentice, $inputs),
            );
        });
    }
}
