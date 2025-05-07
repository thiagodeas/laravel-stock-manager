<?php

namespace App\Exceptions\Output;

use Exception;

class OutputNotFoundException extends Exception
{
    protected $message = 'Output not found.';
    protected $code = 404;
}
