<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Actions\Admin\Contracts\GeneratesAdminsSlugs;
use App\Actions\Admin\Contracts\UpdatesAdmins;
use App\Actions\User\Contracts\UpdatesUsers;
use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class UpdateAdmin implements UpdatesAdmins
{
    private array $fills;

    public function __construct(
        Admin                          $admin,
        protected UpdatesUsers         $userUpdater,
        protected GeneratesAdminsSlugs $slugGenerator,
    ) {
        $this->fills = array_diff($admin->getFillable(), ['code']);
    }

    public function update(Admin $admin, array $inputs): bool
    {
        return DB::transaction(function () use ($admin, $inputs) {
            $admin = $admin->loadMissing('user');

            $data = Arr::only($inputs, $this->fills);
            $data['slug'] = $this->slugGenerator->generate($inputs['name']);

            return $admin->update($data) && $this->userUpdater->update($admin->user, $inputs);
        });
    }
}
