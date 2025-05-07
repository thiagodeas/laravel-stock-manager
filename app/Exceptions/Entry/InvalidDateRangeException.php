<?php

namespace App\Exceptions\Entry;

use Exception;

class InvalidDateRangeException extends Exception
{
    protected $message = 'The start date and end date must be provided.';
    protected $code = 400;
}
