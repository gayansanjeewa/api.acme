<?php

namespace Product\Exceptions;

use Utilities\Exceptions\ValidationException;

class UnprocessableProductException extends ValidationException
{
    protected $code = 'PRO007';

    public function __construct($errors)
    {
        parent::__construct($errors, 422);
    }
}
