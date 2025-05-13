<?php

namespace App\Exceptions\Auth;

use Exception;

class UserAlreadyExistsException extends Exception
{
    protected $message = 'There is already a user registered with this email.';
    protected $code = 409;
}