<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Apprentice;
use App\Models\User;
use Illuminate\Database\Seeder;

final class ApprenticeSeeder extends Seeder
{
    public function run(): void
    {
        Apprentice::factory()
            ->has(User::factory()->asApprentice(), 'user')
            ->count(20)
            ->create();
    }
}
