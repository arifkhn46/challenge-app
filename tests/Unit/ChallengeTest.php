<?php

namespace Tests\Unit;

use App\Challenge;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChallengeTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function a_challenge_has_progresses()
    {
        $challenge = factory(Challenge::class)->create();

        $this->assertInstanceOf(Collection::class, $challenge->progresses);
    }

    /** @test */
    public function it_can_add_progress()
    {
        
        $challenge = factory(Challenge::class)->create();

        $progress = $challenge->addProgress(1, 1);

        $this->assertCount(1, $challenge->progresses);
        $this->assertTrue($challenge->progresses->contains($progress));

    }
}
