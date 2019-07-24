<?php

namespace App\Exceptions;

class OrderException extends \Exception
{
    public static function productNotAvailableInStock()
    {
        return new static('Product is not available in stock');
    }
}
