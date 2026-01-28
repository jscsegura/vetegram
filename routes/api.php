<?php

use Illuminate\Support\Facades\Artisan;
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

Route::group(['prefix' => 'crons'], function () {
    Route::get('/send-notify-list', function () {
        Artisan::call('send:notify'); // every 1 mins
    });
    Route::get('/generate-hours-today', function () {
        Artisan::call('generate:hours'); // every 45 mins
    });
    Route::get('/execute-payments-recurrents', function () {
        Artisan::call('payments:execute'); // every 30 mins
    });
    Route::get('/execute-payments-notifieds', function () {
        Artisan::call('notification:payments'); // every 60 mins
    });
});

Route::post('/migratedb', function(){
    Artisan::call('migrate');
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'Api\UserController@login')->name('app.login');
    Route::post('/verified', 'Api\UserController@verified')->name('app.verified');
    Route::post('/complete-profile', 'Api\UserController@completeProfile')->name('app.completeProfile');
    Route::post('/complete-profile-save', 'Api\UserController@completeProfileSave')->name('app.completeProfileSave');

    Route::post('/get-terms', 'Api\UserController@getTerms')->name('app.getTerms');

    Route::post('/dash', 'Api\DashController@index')->name('app.dash');
    Route::post('/appointment-cancel-or-reschedule', 'Api\DashController@Appointment_cancelOrReschedule')->name('app.cancelOrReschedule');
    Route::post('/appointment-get-hours', 'Api\DashController@Appointment_getHours')->name('app.getHours');
    Route::post('/appointment-reserve-hour', 'Api\DashController@Appointment_reserveHour')->name('app.reserveHour');

    Route::post('/profile', 'Api\ProfileController@index')->name('app.profile');
    Route::post('/profile-set-notifications', 'Api\ProfileController@setNotifications')->name('app.setNotifications');
    Route::post('/profile-update', 'Api\ProfileController@updateProfile')->name('app.updateProfile');
    Route::post('/profile-update-photo', 'Api\ProfileController@updatePhoto')->name('app.updatePhoto');

    Route::post('/appointments', 'Api\AppointmentController@index')->name('app.appointment');

    Route::post('/pets', 'Api\PetController@index')->name('app.myPets');
    Route::post('/pets-save', 'Api\PetController@petSave')->name('app.petSave');
    Route::post('/petdetail', 'Api\PetController@petDetail')->name('app.petDetail');
    Route::post('/petattach', 'Api\PetController@petAttach')->name('app.petAttach');
    Route::post('/petvaccines', 'Api\PetController@petVaccines')->name('app.petVaccines');
    Route::post('/petrecipes', 'Api\PetController@petRecipes')->name('app.petRecipes');
    Route::post('/pets-delete', 'Api\PetController@petDelete')->name('app.petDelete');
    Route::post('/pet-update-photo', 'Api\PetController@updatePhoto')->name('app.updatePhoto');
    Route::post('/pets-edit', 'Api\PetController@editPet')->name('app.editPet');
    Route::post('/save-attach', 'Api\PetController@saveAttach')->name('app.saveAttach');

    Route::post('/search', 'Api\SearchController@search')->name('app.search');
    Route::post('/search-users', 'Api\SearchController@searchUsers')->name('app.searchUsers');
    Route::post('/book-hours', 'Api\SearchController@book')->name('app.bookHours');
    Route::post('/appointment-reserve-hour', 'Api\SearchController@reserveHour')->name('app.reserveHour');
    Route::post('/owner-get-pet-data', 'Api\SearchController@getPetData')->name('app.getPetData');
    Route::post('/get-pet-data-images', 'Api\SearchController@getPetDataImages')->name('app.getPetDataImages');
    Route::post('/owner-saveAppoinment', 'Api\SearchController@saveBook')->name('app.saveBook');
    Route::post('/get-detail-appoinment', 'Api\SearchController@getDetailAppointment')->name('app.getDetailAppointment');

    Route::post('/appointment-view', 'Api\AppointmentController@view')->name('app.appointmentView');
});