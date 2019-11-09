<?php

namespace App;

use App\ChallengeProgress;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    /**
     * Attribute consist valid progress values.
     */
    public $validProgresses = [1, 2];
    

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
    public function addProgress($day, $progress, $description = '')
    {
        return $this->progresses()->updateOrCreate([
            'day' => $day,
            'progress' => $progress,
            'description' => $description
        ]);
    }
}
