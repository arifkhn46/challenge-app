<?php

namespace App\Http\Controllers\API;

use App\Challenge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChallengeProgressController extends Controller
{
    /**
     * Add challenge progress to the given challenge.
     *
     * @param $challenge \App\Challenge
     * 
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Challenge $challenge)
    {
        // request()->validate(['day' => 'required', 'progress' => 'required']);
        
        $challenge->addProgress(request('day'), request('progress'));

        return [
            'updated' => true
        ];
        
    }
}
