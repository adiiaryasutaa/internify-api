<?php

declare(strict_types=1);

namespace App\Actions\Auth\Contracts;

interface RegistersUsers
{
    public function register(array $inputs);
}
