<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Apprentice;
use App\Models\Company;
use App\Models\Review;
use Illuminate\Database\Seeder;

final class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all(['id']);
        $apprentices = Apprentice::all(['id']);

        $reviews = $companies->map(function (Company $company) use ($apprentices) {
            $count = random_int(5, 10);

            $apprentices = $apprentices->random($count);

            return $apprentices->map(
                fn(Apprentice $apprentice) => Review::factory()
                    ->for($apprentice)
                    ->for($company)
                    ->make(),
            )->flatten();
        })->flatten(1);
        $chunks = $reviews->chunk(20);

        $chunks->each(fn($chunk) => Review::insert($chunk->toArray()));
    }
}
