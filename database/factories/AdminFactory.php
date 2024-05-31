<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Admin\Contracts\GeneratesAdminsCodes;
use App\Actions\Admin\Contracts\GeneratesAdminsSlugs;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Admin> */
final class AdminFactory extends Factory
{
    use ExceptStates;

    public function definition(): array
    {
        return [
            'code' => app(GeneratesAdminsCodes::class)->generate(),
            'slug' => app(GeneratesAdminsSlugs::class)->generate(),
        ];
    }

    public function withoutCode(): self
    {
        $this->excepts[] = 'code';

        return $this;
    }

    public function withoutSlug(): self
    {
        $this->excepts[] = 'slug';

        return $this;
    }

    public function owner(): self
    {
        return $this->state(['is_owner' => true]);
    }
}
