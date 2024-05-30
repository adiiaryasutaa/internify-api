<?php

declare(strict_types=1);

namespace App\Actions\Auth\Contracts;

interface AuthenticatesUsers
{
    public function authenticate(array $credentials);
}
