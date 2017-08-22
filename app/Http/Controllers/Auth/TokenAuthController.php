<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as JWTTokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as JWTTokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Utilities\Exceptions\TokenExpiredException;
use Utilities\Exceptions\TokenInvalidException;
use Utilities\Exceptions\TokenNotProvidedException;
use Utilities\Exceptions\UserNotFoundException;
use Utilities\Exceptions\ValidationException;

class TokenAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = unwrap($request->all(), STEP2);

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                throw new ValidationException('Invalid Credentials', 422);
//                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
//            return response()->json(['error' => 'could_not_create_token'], 500);
            throw new TokenNotProvidedException('Could Not Create Token', 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                throw new UserNotFoundException('User Not Found', 404);
            }
        } catch (JWTTokenExpiredException $e) {
            throw new TokenExpiredException('Token Expired', 401);
        } catch (JWTTokenInvalidException $e) {
            throw new TokenInvalidException('Token Invalid', 400);
        } catch (JWTException $e) {
            throw new TokenNotProvidedException('Token Absent', 400);
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function register(Request $request)
    {
        $credentials = unwrap($request->all(), STEP2);
        $newUser['name'] = $credentials['name'];
        $newUser['email'] = $credentials['email'];
        $newUser['password'] = Hash::make($credentials['password']);
        return User::create($newUser);
    }
}
