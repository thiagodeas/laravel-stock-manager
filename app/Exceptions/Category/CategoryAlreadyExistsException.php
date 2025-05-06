<?php

namespace App\Exceptions\Category;

use Exception;

class CategoryAlreadyExistsException extends Exception
{
    protected $message = 'Category already exists.';
    protected $code = 409;
}
