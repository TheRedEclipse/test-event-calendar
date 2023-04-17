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

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('sign-in', 'AuthController@signIn');
        Route::post('sign-out', 'AuthController@signOut');
    });

    Route::get('users/public', 'UserController@publicIndex');
    Route::put('users/{id}/restore', 'UserController@restore');
    Route::delete('users/{id}/force', 'UserController@forceDestroy');
    Route::apiResource('users', 'UserController');

    Route::get('departments/public', 'DepartmentController@publicIndex');
    Route::put('departments/{id}/restore', 'DepartmentController@restore');
    Route::delete('departments/{id}/force', 'DepartmentController@forceDestroy');
    Route::apiResource('departments', 'DepartmentController');

    Route::apiResource('calendar-events', 'CalendarEventController');
});
