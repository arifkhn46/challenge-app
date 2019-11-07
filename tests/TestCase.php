<?php

namespace Tests;

use JWTAuth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private $token = null;

    /**
     * Sign in the given user or create new one if not provided.
     * 
     * @param $user \App\User
     * 
     * @return \App\User
     */
    protected function signIn($user = null)
    {
        $user = $user ?: factory('App\User')->create();
        $this->actingAs($user);
        $token = JWTAuth::fromUser($user);
        $user->api_token = $token;
        $this->token = $token;
        return $user;
    }

    /**
     * Add headers to the request.
     * 
     */
    protected function josnPost($path, $data)
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->json('POST', $path, $data);
    }
}
