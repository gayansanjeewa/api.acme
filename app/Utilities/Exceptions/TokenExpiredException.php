<?php

namespace Utilities\Exceptions;

use Tymon\JWTAuth\Exceptions\TokenExpiredException as BaseTokenExpiredException;

class TokenExpiredException extends BaseTokenExpiredException
{
    protected $statusCode = 401;

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
