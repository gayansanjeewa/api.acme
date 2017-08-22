<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use InteractsWithDatabase;

    protected $headers;
    protected $user;

    /**
     * @param array $userData
     * @return array
     */
    protected function signUp($userData = ['name' => 'john', 'email' => 'john@email.com', 'password' => 123456])
    {
        $this->user = User::create($userData);
        $this->headers = [
            'Accept' => 'application/vnd.laravel.v1+json',
            'Authorization' => 'Bearer ' . JWTAuth::fromUser($this->user)
        ];
    }
}
