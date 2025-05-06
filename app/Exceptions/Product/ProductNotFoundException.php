<?php

namespace App\Exceptions\Product;

use Exception;

class ProductNotFoundException extends Exception
{
    protected $message = 'Product not found.';
    protected $code = 404;
}
