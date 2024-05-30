<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

final class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::factory()
            ->has(User::factory()->asAdmin(), 'user')
            ->count(20)
            ->create();
    }
}
