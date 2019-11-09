<?php

namespace App\Http\Controllers\API;

use App\Challenge;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChallengeProgressRequest;
use Illuminate\Http\Request;

class ChallengeProgressController extends Controller
{
    /**
     * Add challenge progress to the given challenge.
     *
     * @param $challenge \App\Challenge
     * 
     * @param $request \App\Http\Requests\StoreChallengeProgressRequest
     * 
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Challenge $challenge, StoreChallengeProgressRequest $request)
    {
        $data = $request->validated();
        extract($data);
        $challenge->addProgress($day, $progress, $description);

        return [
            'updated' => true
        ];
        
    }
}
