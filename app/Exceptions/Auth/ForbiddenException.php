<?php

namespace App\Exceptions\Auth;

use Exception;

class ForbiddenException extends Exception
{
    protected $message = 'This action requires administrator privileges.';
    protected $code = 403;
}
