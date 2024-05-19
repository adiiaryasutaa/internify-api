<?php

namespace App\Actions\Auth\Contracts;

interface RegistersUsers
{
    public function register(array $inputs);
}
