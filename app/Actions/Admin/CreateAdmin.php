<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Actions\Admin\Contracts\CreatesAdmins;
use App\Actions\Admin\Contracts\GeneratesAdminsCodes;
use App\Actions\Admin\Contracts\GeneratesAdminsSlugs;
use App\Actions\User\Contracts\CreatesUsers;
use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class CreateAdmin implements CreatesAdmins
{
    private array $fills;

    public function __construct(
        Admin                          $admin,
        protected CreatesUsers         $userCreator,
        protected GeneratesAdminsCodes $codeGenerator,
        protected GeneratesAdminsSlugs $slugGenerator,
    ) {
        $this->fills = $admin->getFillable();
    }

    public function create(array $inputs): Admin
    {
        return DB::transaction(function () use ($inputs) {
            $data = Arr::only($inputs, $this->fills);
            $data['code'] = $this->codeGenerator->generate();
            $data['slug'] = $this->slugGenerator->generate($inputs['name']);

            return tap(
                Admin::create($data),
                fn(Admin $admin) => $this->userCreator->createAsAdmin($admin, $inputs),
            );
        });
    }
}
