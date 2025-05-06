<?php

namespace App\Exceptions\Category;

use Exception;

class CategoryNotFoundException extends Exception

{
    protected $message = 'Category not found.';
    protected $code = 404;
}