<?php

use App\Enums\Role;
use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Admin::forceCreate(['is_owner' => true])->user()->create([
            'name' => 'Ir. H. Jokowi Dodo',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => Role::ADMIN,
        ]);
    }
};
