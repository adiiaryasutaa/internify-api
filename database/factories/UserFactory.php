<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<User> */
final class UserFactory extends Factory
{
    use ExceptStates;

    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->name,
            'username' => $username = str($name)->lower()->replace(' ', '')->substr(0, 20)->toString(),
            'email' => sprintf('%s@%s', $username, 'gmail.com'),
            'password' => bcrypt('password'),
        ];
    }

    public function withoutPassword(): self
    {
        $this->excepts[] = 'password';

        return $this;
    }

    public function unsafePassword(): self
    {
        return $this->state(['password' => 'password']);
    }

    public function asAdmin(): self
    {
        return $this->state(['role' => Role::ADMIN]);
    }

    public function asEmployer(): self
    {
        return $this->state(['role' => Role::EMPLOYER]);
    }

    public function asApprentice(): self
    {
        return $this->state(['role' => Role::APPRENTICE]);
    }
}
