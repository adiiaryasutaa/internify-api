<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Application\Contracts\GeneratesApplicationsCodes;
use App\Actions\Application\GenerateApplicationSlug;
use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Application> */
final class ApplicationFactory extends Factory
{
    use ExceptStates;

    public function definition(): array
    {
        return [
            'code' => app(GeneratesApplicationsCodes::class)->generate(),
            'slug' => app(GenerateApplicationSlug::class)->generate(),
            'name' => $name = $this->faker->name(),
            'email' => sprintf('%s@%s', str($name)->lower()->replace(' ', '')->substr(0, 20)->toString(), 'gmail.com'),
            'phone' => $this->faker->numerify('0###########'),
            'resume' => $this->faker->paragraph(5),
            'status' => ApplicationStatus::PENDING,
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

    public function pending(): self
    {
        return $this->state(['status' => ApplicationStatus::PENDING]);
    }

    public function reviewed(): self
    {
        return $this->state(['status' => ApplicationStatus::REVIEWED]);
    }

    public function rejected(): self
    {
        return $this->state(['status' => ApplicationStatus::REJECTED]);
    }

    public function accepted(): self
    {
        return $this->state(['status' => ApplicationStatus::ACCEPTED]);
    }
}
