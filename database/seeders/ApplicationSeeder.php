<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Apprentice;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

final class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $vacancies = Vacancy::all(['id']);
        $apprentices = Apprentice::without('user')->get(['id']);

        $applications = $vacancies->map(function (Vacancy $vacancy) use ($apprentices) {
            $count = random_int(3, 10);

            $apprentices = $apprentices->random($count);

            return $apprentices->map(
                fn(Apprentice $apprentice) => Application::factory()
                    ->for($vacancy)
                    ->for($apprentice)
                    ->make(),
            )->flatten();
        })->flatten(1);

        $chunks = $applications->chunk(20);

        $chunks->each(fn($chunk) => Application::insert($chunk->toArray()));
    }
}
