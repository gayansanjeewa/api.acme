<?php

namespace Utilities\Exceptions;

use Tymon\JWTAuth\Exceptions\TokenInvalidException as BaseTokenInvalidException;

class TokenInvalidException extends BaseTokenInvalidException
{
    protected $statusCode = 400;

    /**
     * @param string $message
     * @param int $statusCode
     */
    public function __construct($message = 'An error occurred', $statusCode = null)
    {
        parent::__construct($message);

        if (! is_null($statusCode)) {
            $this->setStatusCode($statusCode);
        }
    }
}
