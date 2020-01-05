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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('characters')->group(function(){
    Route::get('/', 'Api\CharacterController@index')->name('characters.index');
    Route::get('{id}', 'Api\CharacterController@find')->name('characters.find');
});

Route::prefix('matches')->group(function(){
    Route::get('/', 'Api\MatchController@index')->name('matches.index');
    Route::get('{id}', 'Api\MatchesController@find')->name('matches.find');
});