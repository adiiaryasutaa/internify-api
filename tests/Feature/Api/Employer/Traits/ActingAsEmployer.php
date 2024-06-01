<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Employer\Traits;

use App\Models\Employer;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait ActingAsEmployer
{
    protected User $user;
    protected Employer $employer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->asEmployer()
            ->for(Employer::factory(), 'userable')
            ->create();

        $this->employer = $this->user->userable;

        Sanctum::actingAs($this->user);
    }
}
