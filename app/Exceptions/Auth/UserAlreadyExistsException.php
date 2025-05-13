<?php

namespace App\Exceptions\Auth;

use Exception;

class UserAlreadyExistsException extends Exception
{
    protected $message = 'User already exists.';
    protected $code = 409;
}