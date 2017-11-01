<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', config('app.url') . '/home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/books', 'BooksController');

Route::get('/checkout/{bookId?}', 'CheckoutsController@create')->name('checkouts.create');
Route::post('/checkout', 'CheckoutsController@store')->name('checkouts.store');
