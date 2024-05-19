<?php

namespace App\Exceptions;

use Exception;

class AdminCannotRegisteredPubliclyException extends Exception
{
    public function __construct()
    {
        parent::__construct('Admin cannot registered publicly');
    }
}
