<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/register','AuthController@register');
// Route::post('/login','AuthController@login');
// Route::middleware('auth:sanctum')->post('/userinfo','AuthController@userinfo');

Route::post('/login','Api\AuthController@login');
Route::post('/register','Api\AuthController@register');

// JSON
Route::get('/specialties','Api\SpecialtyController@index');
Route::get('/specialties/{specialty}/doctors','Api\SpecialtyController@doctors');
Route::get('/schedule/hours', 'Api\ScheduleController@hours');


Route::middleware('auth:sanctum')->namespace('Api')->group(function(){

    Route::get('/userinfo','UserController@show');
    Route::post('/logout','AuthController@logout');

    // appointments
    Route::get('/appointments', 'AppointmentController@index');
    Route::post('/appointments', 'AppointmentController@store');

    // fcm
    Route::post('/fcm/token','FirebaseController@postToken');

});
