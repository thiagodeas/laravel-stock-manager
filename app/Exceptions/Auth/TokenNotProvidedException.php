<?php

namespace App\Exceptions\Auth;

use Exception;

class TokenNotProvidedException extends Exception
{
    protected $message = 'Token not provided or invalid.';
    protected $code = 401;
}