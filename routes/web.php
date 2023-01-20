<?php

use Illuminate\Support\Facades\Route;

/*
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth','admin'])->namespace('Admin')->group(function(){
   //Specialty
    Route::get('specialties','SpecialtyController@index')->name('specialties.index');
    Route::get('specialties/create','SpecialtyController@create')->name('specialties.create');; // Form Registro
    Route::get('specialties/{specialty}/edit','SpecialtyController@edit')->name('specialties.edit');//Form edición

    Route::post('specialties','SpecialtyController@store')->name('specialties.store');//Envio del Form
    Route::put('specialties/{specialty}','SpecialtyController@update')->name('specialties.update');//Envio de la edición
    Route::delete('specialties/{specialty}','SpecialtyController@destroy')->name('specialties.delete');//Eliminacion de la especialidad

    //Doctors
    Route::resource('doctors','DoctorsController');

    //Patients
    Route::resource('patients','PatientsController');
});

Route::middleware(['auth','doctor'])->namespace('Doctor')->group(function(){
    Route::get('/schedule','ScheduleController@edit')->name('schedule.edit');
    Route::post('/schedule','ScheduleController@store')->name('schedule.store');
});


Route::middleware('auth')->group(function(){
    Route::get('/appointments/create', 'AppointmentController@create')->name('appointments.create');
    Route::post('/appointments', 'AppointmentController@store')->name('appointments.store');
    // JSON
    Route::get('/api/specialties/{specialty}/doctors','Api\SpecialtyController@doctors');
    Route::get('/api/schedule/hours', 'Api\ScheduleController@hours');
});

