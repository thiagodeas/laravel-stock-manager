<?php

namespace App\Exceptions\Category;

use Exception;

class CategoryNotFoundException extends Exception

{
    protected $message = 'Category not found.';
    protected $code = 404;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}