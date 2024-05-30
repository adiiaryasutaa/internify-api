<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Seeder;

final class EmployerSeeder extends Seeder
{
    public function run(): void
    {
        Employer::factory()
            ->has(User::factory()->asEmployer(), 'user')
            ->count(20)
            ->create();
    }
}
