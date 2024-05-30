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
    public function definition(): array
    {
        return [
            'code' => app(GeneratesAdminsCodes::class)->generate(),
            'slug' => app(GeneratesAdminsSlugs::class)->generate(),
        ];
    }

    public function withoutSlug(): self
    {
        $this->states->forget('slug');

        return $this;
    }

    public function withoutCode(): self
    {
        $this->states->forget('code');

        return $this;
    }

    public function owner(): self
    {
        return $this->state([
            'is_owner' => true,
        ]);
    }
}
