<?php

namespace Tests\Feature;

use App\Challenge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageChallengesTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_challenge_requires_a_name()
    {
        $this->signIn();
        $attributes = factory('App\Challenge')->raw(['name' => '']);
        $response = $this->josnPost(route('challenge.create'), $attributes);
        $this->assertArrayHasKey('name', $response->json()['errors']);
    }

    /** @test */
    public function a_challenge_requires_number_of_days()
    {
        $this->signIn();
        $attributes = factory('App\Challenge')->raw(['days' => '']);
        $response = $this->josnPost(route('challenge.create'), $attributes);        
        $this->assertArrayHasKey('days', $response->json()['errors']);

    }

    /** @test */
    public function a_challenge_must_have_integer_number_of_days()
    {
        $this->signIn();
        $attributes = factory('App\Challenge')->raw(['days' => '23.5']);
        $response = $this->josnPost(route('challenge.create'), $attributes);
        $this->assertArrayHasKey('days', $response->json()['errors']);

    }

    /** @test */
    function unauthorized_users_cannot_create_a_challenge()
    {
        $this->josnPost(
            route('challenge.create'), 
            $attribute = factory(Challenge::class)->raw()
        )->assertStatus(401);
        
        $this->assertDatabaseMissing('challenges', [
            'name' => $attribute['name']
        ]);
    }

    /** @test */
    public function a_user_can_create_a_challenge() 
    {
        $this->signIn();    
        $response = $this->josnPost(
            route('challenge.create'), $attribute = factory(Challenge::class)->raw()
        )->assertStatus(200);

        $this->assertDatabaseHas('challenges', [
            'name' => $attribute['name']
        ]);
        
        $this->assertArrayHasKey('name', $response->json());
    }
}
