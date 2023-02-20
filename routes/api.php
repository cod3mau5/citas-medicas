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

// Route::post('/register','AuthController@register');
// Route::post('/login','AuthController@login');
// Route::middleware('auth:sanctum')->post('/userinfo','AuthController@userinfo');

// JSON
Route::get('/specialties','Api\SpecialtyController@index');
Route::get('/specialties/{specialty}/doctors','Api\SpecialtyController@doctors');
Route::get('/schedule/hours', 'Api\ScheduleController@hours');

Route::post('/login','Api\AuthController@login');
Route::middleware('auth:sanctum')->namespace('Api')->group(function(){
    Route::get('/userinfo','UserController@show');
    Route::post('/logout','AuthController@logout');
});
