<?php

namespace Tests\Feature;

use App\Challenge;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChallengeProgressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_add_per_day_progress_to_challenge()
    {        
        $this->signIn();

        $challenge = factory(Challenge::class)->create(['owner_id' => auth()->id()]);

        $this->josnPost(route('api.challenge.add_progress', ['challenge' => $challenge->id]), [
            'day' => 1,
            'progress' => 1,
        ])->assertStatus(200);

        $this->assertDatabaseHas('challenge_progresses', ['challenge_id' => $challenge->id, 'progress' => 1]);
    }
    
    /** @test */
    public function unauthorized_user_can_not_add_progress_to_challenge()
    {
        $user1 = factory(User::class)->create();

        $user1_challenge = factory(Challenge::class)->create(['owner_id' => $user1->id]);

        $this->signIn();

        $this->josnPost(route('api.challenge.add_progress', ['challenge' => $user1_challenge->id]), [
            'day' => 1,
            'progress' => 1
        ])->assertStatus(403);
        
    }
}
