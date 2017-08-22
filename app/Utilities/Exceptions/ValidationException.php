<?php

namespace Utilities\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
    protected $messages = "Validation failed!";
    protected $code = "";
    protected $errors = [];

    public function __construct($errors, $code = 422)
    {
        $this->errors = $errors;
        parent::__construct($code, $this->messages);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
