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
        request()->validate(['name' => 'required', 'days' => 'required|Integer']);
        
        $challeng = new Challenge();

        $challeng->name = request('name');
        $challeng->days = request('days');

        $challeng->save();

        return ['success' => true];
        // $this->authorize('update', $project);
        // return redirect($project->path());
    }
}
