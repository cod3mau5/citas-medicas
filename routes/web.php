<?php

use Illuminate\Support\Facades\Route;

/*
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
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

    //FCM
    Route::post('/fcm/send','FirebaseController@sendAll')->name('FCMWeb');

});

Route::middleware(['auth','doctor'])->namespace('Doctor')->group(function(){
    Route::get('/schedule','ScheduleController@edit')->name('schedule.edit');
    Route::post('/schedule','ScheduleController@store')->name('schedule.store');
});


Route::middleware('auth')->group(function(){

        Route::get('/profile', 'UserController@edit')->name('profile.edit');
        Route::post('/profile', 'UserController@update')->name('profile.update');



    Route::get('/appointments', 'AppointmentController@index')->name('appointments.index');
    Route::middleware('phone')->group(function(){
        Route::get('/appointments/create', 'AppointmentController@create')->name('appointments.create');
        Route::post('/appointments/store', 'AppointmentController@store')->name('appointments.store');
    });

    Route::get('/appointments/{appointment}', 'AppointmentController@show')->name('appointments.show');
    Route::get('/appointments/{appointment}/cancel', 'AppointmentController@showCancelForm')->name('appointments.showCancelForm');
    Route::post('/appointments/{appointment}/cancel', 'AppointmentController@postCancel')->name('appointments.postCancel');
    Route::post('/appointments/{appointment}/confirm', 'AppointmentController@postConfirm')->name('appointments.confirm');
    // Charts
	Route::get('/charts/appointments/line', 'Admin\ChartController@appointments')->name('charts.appointments');
	Route::get('/charts/doctors/column', 'Admin\ChartController@doctors')->name('charts.doctors');
	Route::get('/charts/doctors/column/data', 'Admin\ChartController@doctorsJson');

});

