<?php

namespace Utilities\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;

class UserNotFoundException extends JWTException
{
    protected $statusCode = 404;

    /**
     * @param string $message
     * @param int $statusCode
     */
    public function __construct($message = 'An error occurred', $statusCode = null)
    {
        parent::__construct($message);

        if (!is_null($statusCode)) {
            $this->setStatusCode($statusCode);
        }
    }
}
