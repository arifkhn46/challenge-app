<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'API',
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login')->name('api.user.login');
    Route::post('logout', 'AuthController@logout')->name('api.user.logout');
    Route::post('refresh', 'AuthController@refresh')->name('api.user.token_refresh');
    Route::post('me', 'AuthController@me')->name('api.user.profile');

});

Route::post('register', 'Auth\RegisterController@register')->name('api.user.register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'namespace' => 'API'], function () {
    Route::middleware('auth:api')->post('/challenges', 'ChallengeController@store')->name('challenge.create');
});

