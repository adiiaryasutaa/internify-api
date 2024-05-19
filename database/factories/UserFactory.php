<?php

namespace Database\Factories;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->name,
            'username' => $username = str($name)->lower()->replace(' ', '')->substr(0, 20)->toString(),
            'email' => sprintf('%s@%s', $username, 'gmail.com'),
            'password' => bcrypt('password'),
        ];
    }

    public function unsafePassword(): self
    {
        return $this->state([
            'password' => 'password',
        ]);
    }

    public function asAdmin(): self
    {
        return $this->state([
            'role' => Role::ADMIN,
        ]);
    }

    public function asEmployer(): self
    {
        return $this->state([
            'role' => Role::EMPLOYER,
        ]);
    }

    public function asApprentice(): self
    {
        return $this->state([
            'role' => Role::APPRENTICE,
        ]);
    }
}
