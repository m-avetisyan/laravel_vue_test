<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout');
});
Route::group(['middleware' => ['auth.jwt']], function () {

    /* Teams Routes*/
    Route::get('/team', 'TeamController@index');
    Route::get('/team/{id}', 'TeamController@show');
    Route::post('/team/new/', 'TeamController@store');
    Route::put('/team/{id}', 'TeamController@update');
    Route::delete('/team/{id}', 'TeamController@destroy');
    Route::get('/teams', 'TeamController@all');
    /* END*/


    /* Players Routes*/
    Route::get('/player', 'PlayerController@index');
    Route::get('/player/{id}', 'PlayerController@show');
    Route::post('/player/new/', 'PlayerController@store');
    Route::put('/player/{id}', 'PlayerController@update');
    Route::delete('/player/{id}', 'PlayerController@destroy');
    /*END */

    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}', 'UserController@show');
    Route::put('/users/{id}', 'UserController@update');
    Route::delete('/user/{id}', 'UserController@destroy');



});
