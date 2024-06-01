<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Admin\Traits;

use App\Models\Admin;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait ActingAsAdmin
{
    protected User $user;
    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->asAdmin()
            ->for(Admin::factory()->owner(), 'userable')
            ->create();
        $this->admin = $this->user->userable;


        Sanctum::actingAs($this->user);
    }
}
