<?php

namespace App\Exceptions\Product;

use Exception;

class InsufficientStockException extends Exception
{
    protected $message = 'Insufficient product quantity in stock.';
    protected $code = 400; 
}