<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_login()
    {
        $user = factory('App\User')->create();

        $response = $this->json('POST', route('api.user.login'), [
            'email'=> $user->email,
            'password' => 'password'
        ])->assertStatus(200);

        $this->assertArrayHasKey('access_token', $response->json());
    }

    /** @test */
    public function a_user_can_logout()
    {
    
        $this->josnPost(route('api.user.logout'))->assertStatus(401);

        $this->signIn();

        $this->josnPost(route('api.user.logout'))->assertStatus(200);

        $this->josnPost(route('api.user.profile'))->assertStatus(401);
    }
}
