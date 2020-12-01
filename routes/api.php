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

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::apiResource('book', 'API\BookController');
    Route::put('book/copies/{id}', 'API\BookController@update_copies');
    Route::apiResource('category', 'API\BookCategoryController');
    Route::apiResource('user', 'API\UserController');
    Route::apiResource('student', 'API\StudentController');
    Route::apiResource('faculty', 'API\FacultyController');
    Route::apiResource('borrower', 'API\BorrowerController');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'API\AuthController@login')->name('login');
    Route::post('register', 'API\AuthController@register')->name('register');
    Route::post('logout', 'API\AuthController@logout')->name('logout');
    Route::post('refresh', 'API\AuthController@refresh')->name('refresh');
    Route::post('me', 'API\AuthController@me')->name('me');

});