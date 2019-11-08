<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegisterationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register()
    {
        $this->withoutExceptionHandling();

        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];
        
        $response = $this->json('POST', route('api.user.register'), $data);

        $response->assertStatus(200);
        
        $response_data = $response->json();
        $this->assertArrayHasKey('access_token', $response_data);
        
        $this->assertDatabaseHas('users', ['name' => $data['name']]);

        // Confirm user can access his profile
        $user_profile_respone = $this->withHeaders([
            'Authorization' => 'Bearer '. $response_data['access_token'],
            ])->json('POST', route('api.user.profile'))->json();

        $this->assertEquals($data['name'], $user_profile_respone['name']);

    }
}
