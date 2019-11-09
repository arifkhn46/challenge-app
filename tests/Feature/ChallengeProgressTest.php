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
    public function a_chellenge_progress_requires_a_progress_id()
    {
        $this->signIn();

        $challenge = factory(Challenge::class)->create(['owner_id' => auth()->id()]);

        $response = $this->requestChallengeProgress($challenge->id, [
                'progress' => ''
            ])->assertStatus(422);

        $this->assertArrayHasKey('progress', $response->json()['errors']);
        $this->assertCount(1, $response->json()['errors']);
    }

    /** @test */
    public function a_challenge_progress_requires_progress_id_must_be_an_integer()
    {
        $this->signIn();

        $challenge = factory(Challenge::class)->create(['owner_id' => auth()->id()]);

        $response = $this->requestChallengeProgress($challenge->id, [
                'progress' => 'asdf'
            ])->assertStatus(422);

        $this->assertArrayHasKey('progress', $response->json()['errors']);

        $this->assertCount(1, $response->json()['errors']);
    }

    /** @test */
    public function a_challenge_progress_requires_valid_progress_id()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $challenge = factory(Challenge::class)->create(['owner_id' => auth()->id()]);

        $response = $this->requestChallengeProgress($challenge->id, [
                'progress' => 1000
            ])->assertStatus(422);

        $this->assertArrayHasKey('progress', $response->json()['errors']);

        $this->assertCount(1, $response->json()['errors']);

        $response = $this->requestChallengeProgress($challenge->id)->assertStatus(200);
        
        $this->assertArrayNotHasKey('errors', $response->json());
    }

    /** @test */
    public function a_chellenge_progress_requires_a_day_number()
    {
        $this->signIn();

        $challenge = factory(Challenge::class)->create(['owner_id' => auth()->id()]);

        $response = $this->requestChallengeProgress($challenge->id, [
                'day' => ''
            ])->assertStatus(422);

        $this->assertArrayHasKey('day', $response->json()['errors']);
        $this->assertCount(1, $response->json()['errors']);
    }

    /** @test */
    public function a_challenge_progress_requires_day_number_must_be_an_integer()
    {
        $this->signIn();

        $challenge = factory(Challenge::class)->create(['owner_id' => auth()->id()]);

        $response = $this->requestChallengeProgress($challenge->id, [
                'day' => 'asdf'
            ])->assertStatus(422);

        $this->assertArrayHasKey('day', $response->json()['errors']);
        $this->assertCount(1, $response->json()['errors']);
    }

    /** @test */
    public function authorized_user_may_add_description_of_progress()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $challenge = factory(Challenge::class)->create(['owner_id' => auth()->id()]);
        $challengeProgressDescription = 'I am feeling awesome today!';
        $this->requestChallengeProgress($challenge->id, [
                'description' => $challengeProgressDescription
            ])->assertStatus(200);

        $this->assertDatabaseHas('challenge_progresses', [
                'challenge_id' => $challenge->id,
                'progress' => 1,
                'description' => $challengeProgressDescription
            ]);
      
    }

    /** @test */
    public function a_user_can_add_per_day_progress_to_challenge()
    {        
        $this->signIn();

        $challenge = factory(Challenge::class)->create(['owner_id' => auth()->id()]);

        $this->requestChallengeProgress($challenge->id)->assertStatus(200);

        $this->assertDatabaseHas('challenge_progresses', ['challenge_id' => $challenge->id, 'progress' => 1]);
    }
    
    /** @test */
    public function unauthorized_user_can_not_add_progress_to_challenge()
    {
        $user1 = factory(User::class)->create();

        $user1_challenge = factory(Challenge::class)->create(['owner_id' => $user1->id]);

        $this->signIn();

        $this->requestChallengeProgress($user1_challenge->id)->assertStatus(403);
        
    }

    /**
     * Create challenge progress.
     */
    function requestChallengeProgress($challenge_id, $data = [])
    {
        $data =  array_merge([
            'day' => 1,
            'progress' => 1,
            'description' => "description"
        ], $data);
        
        return $this->josnPost(route('api.challenge.add_progress', ['challenge' => $challenge_id]), $data);
    }
}
