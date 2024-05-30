<?php

declare(strict_types=1);

use App\Actions\Admin\Contracts\GeneratesAdminsCodes;
use App\Actions\Admin\Contracts\GeneratesAdminsSlugs;
use App\Enums\Role;
use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        $data = [
            'name' => 'Internify Admin',
            'username' => 'internify-admin',
            'email' => 'internify@gmail.com',
            'password' => 'password',
            'role' => Role::ADMIN,
        ];

        Admin::forceCreate([
            'slug' => app(GeneratesAdminsSlugs::class)->generate($data['name']),
            'code' => app(GeneratesAdminsCodes::class)->generate(),
            'is_owner' => true,
        ])->user()->create($data);
    }
};
