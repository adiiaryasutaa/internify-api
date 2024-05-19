<?php

namespace App\Actions\Auth\Contracts;

interface AuthenticatesUsers
{
    public function authenticate(array $credentials);
}
