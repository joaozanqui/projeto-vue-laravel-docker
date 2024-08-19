<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\StudentController;
use App\Http\Controllers\api\v1\ActivityController;
use App\Http\Controllers\api\v1\EnrollmentController;

Route::prefix('v1')->group(function() {
    Route::namespace('App\Http\Controllers\api\v1')->group(function() {
        Route::resource('/students', 'StudentController');
        Route::resource('/activities', 'ActivityController');

        Route::post('/students/{student}/activities/{activity}', 'EnrollmentController@store');
        Route::delete('/students/{student}/activities/{activity}', 'EnrollmentController@destroy');
        Route::get('/students/{student}/activities', 'EnrollmentController@showStudentsActivities');
        Route::get('/activities/{activity}/students', 'EnrollmentController@showActivitiesStudents');
    });
});