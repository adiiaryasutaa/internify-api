<?php

declare(strict_types=1);

namespace App\Actions\Apprentice;

use App\Actions\Apprentice\Contracts\GeneratesApprenticesSlugs;
use App\Actions\Apprentice\Contracts\UpdatesApprentices;
use App\Actions\User\Contracts\UpdatesUsers;
use App\Models\Apprentice;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class UpdateApprentice implements UpdatesApprentices
{
    private array $fills;

    public function __construct(
        Apprentice                          $apprentice,
        protected UpdatesUsers              $userUpdater,
        protected GeneratesApprenticesSlugs $slugGenerator,
    ) {
        $this->fills = $apprentice->getFillable();
    }

    public function update(Apprentice $apprentice, array $inputs): bool
    {
        return DB::transaction(function () use ($apprentice, $inputs) {
            $apprentice = $apprentice->loadMissing('user');

            $data = Arr::only($inputs, $this->fills);
            $data['slug'] = $this->slugGenerator->generate($inputs['name']);

            return $apprentice->update($data) && $this->userUpdater->update($apprentice->user, $inputs);
        });
    }
}
