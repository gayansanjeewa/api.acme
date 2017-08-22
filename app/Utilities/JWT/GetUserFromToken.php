<?php

namespace Utilities\JWT;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as JWTTokenExpiredException;
use Tymon\JWTAuth\Middleware\GetUserFromToken as BaseMiddleware;
use Utilities\Exceptions\TokenExpiredException;
use Utilities\Exceptions\TokenInvalidException;
use Utilities\Exceptions\TokenNotProvidedException;
use Utilities\Exceptions\UserNotFoundException;

class GetUserFromToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws TokenExpiredException
     * @throws TokenInvalidException
     * @throws TokenNotProvidedException
     * @throws UserNotFoundException
     */
    public function handle($request, \Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            throw new TokenNotProvidedException('Token Not Provided');
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (JWTTokenExpiredException $e) {
            throw new TokenExpiredException('Token Expired', 401);
        } catch (JWTException $e) {
            throw new TokenInvalidException('Token Invalid', 400);
        }

        if (!$user) {
            throw new UserNotFoundException('User Not Found', 404);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
}
