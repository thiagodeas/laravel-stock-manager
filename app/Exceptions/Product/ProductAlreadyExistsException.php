<?php

namespace App\Exceptions\Product;

use Exception;

class ProductAlreadyExistsException extends Exception
{
    protected $message = 'Product already exists.';
    protected $code = 409;

    public function __construct()
    {
        parent::__construct('Product not found.', 404);
    }
}
