<?php

namespace App\Exceptions\Auth;

use Exception;

class UserNotAuthenticatedException extends Exception
{
    protected $message = 'User not authenticated';
    protected $code = 401;
}