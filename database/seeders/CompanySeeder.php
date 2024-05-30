<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employer;
use Illuminate\Database\Seeder;

final class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $employers = Employer::all(['id']);

        $employers = $employers->map(fn(Employer $employer) => Company::factory()->for($employer)->make());

        $chunks = $employers->chunk(20);

        $chunks->each(fn($chunk) => Company::insert($chunk->toArray()));
    }
}
