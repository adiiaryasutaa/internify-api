<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Traits;

use App\Models\Admin;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait ActingAsAdmin
{
    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            User::factory()
                ->asAdmin()
                ->for(Admin::factory()->owner(), 'userable')
                ->create(),
        );
    }
}
