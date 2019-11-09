<?php

namespace App\Policies;

use App\Challenge;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChallengePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given challenge can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Challenge  $post
     * @return bool
     */
    public function store(User $user, Challenge $challenge)
    {
        return $user->id == $challenge->owner_id;
    }
}
