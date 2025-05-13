<?php

namespace App\Exceptions\Auth;

use Exception;

class LogoutFailedException extends Exception
{
    protected $message = 'Failed to logout.';
    protected $code = 500;
}