<?php

namespace App\Http\Controllers\API;

use App\Challenge;
use App\Http\Controllers\Controller;

class ChallengeController extends Controller
{
    
    public function create() {
        return view('challenge.create');
    }

    /**
     * Add a challenge to the users list.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        $challenge = auth()->user()->challenges()->create($this->validateRequest());
        
        return $challenge->toJson();
        
    }

    /**
     * Validate request attributes
     * 
     * @return array
     */
    public function validateRequest()
    {
        return request()->validate(['name' => 'required', 'days' => 'required|Integer']);
    }
}
