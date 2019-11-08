<?php

namespace App;

use App\ChallengeProgress;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    /**
     * Attributes to guard against mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get challenge progresses
     */
    public function progresses()
    {
        return $this->hasMany(ChallengeProgress::class);
    }

    /**
     * Add progress to challenge.
     *
     * @param int $day
     * @param int $progress
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function addProgress($day, $progress)
    {
        return $this->progresses()->create([
            'day' => $day,
            'progress' => $progress
        ]);
    }
}
