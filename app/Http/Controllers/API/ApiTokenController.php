<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    /**
     * Generate a new token.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate()
    {
        $token = auth()->user()->generateApiToken();

        return [
            'token' => $token
        ];
    }

}
