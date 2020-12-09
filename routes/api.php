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
    Route::put('book/copies/{id}', 'API\BookController@update_copies')
            ->name('book.updateCopies');
    Route::post('book/inventory', 'API\BookController@inventory')
            ->name('book.inventory');     
    Route::post('book/borrowed', 'API\BookController@borrowed')
            ->name('book.borrowed');  
    Route::post('book/returned', 'API\BookController@returned')
            ->name('book.returned');
    Route::post('book/lost', 'API\BookController@lost')
            ->name('book.lost');
    Route::post('book/overdue', 'API\BookController@overdue')
            ->name('book.overdue');

    Route::apiResource('category', 'API\BookCategoryController');
    Route::apiResource('user', 'API\UserController');
    Route::put('user/{id}/change-password', 'API\UserController@changePassword')
            ->name('user.change-password');
            
    Route::apiResource('student', 'API\StudentController');
    Route::apiResource('faculty', 'API\FacultyController');
    Route::apiResource('borrow', 'API\BorrowController');
    Route::get('borrower/{id}', 'API\BorrowerController@show')
            ->name('borrower.show');

    Route::post('option', 'API\OptionController@index')->name('option.index');
    Route::put('option/{id}', 'API\OptionController@update')->name('option.update');
});

Route::group([
    'middleware' => 'jwt.auth', 
    'prefix' => 'dashboard'
], function() {

    Route::post('books', 'API\DashboardController@booksCount');
    Route::post('books-borrowed', 'API\DashboardController@booksBorrowed');
    Route::post('books-lost', 'API\DashboardController@booksLost');
    Route::post('books-overdue', 'API\DashboardController@booksOverdue');
    Route::post('total-students', 'API\DashboardController@totalStudents');
    Route::post('total-faculties', 'API\DashboardController@totalFaculties');

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