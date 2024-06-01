<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Apprentice\Traits;

use App\Models\Apprentice;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait ActingAsApprentice
{
    protected User $user;
    protected Apprentice $apprentice;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->asApprentice()
            ->for(Apprentice::factory(), 'userable')
            ->create();

        $this->apprentice = $this->user->userable;

        Sanctum::actingAs($this->user);
    }
}
