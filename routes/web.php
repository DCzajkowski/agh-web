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

Route::get('/books/create', 'BooksController@create')->name('books.create');
Route::post('/books', 'BooksController@store')->name('books.store');
Route::get('/books/{book}/edit', 'BooksController@edit')->name('books.edit');
Route::put('/books/{book}', 'BooksController@update')->name('books.update');
Route::patch('/books/{book}', 'BooksController@update')->name('books.update');
Route::delete('/books/{book}', 'BooksController@destroy')->name('books.destroy');

Route::get('/checkout', 'CheckoutsController@index')->name('checkouts.index');
Route::get('/checkout/create/{bookId?}', 'CheckoutsController@create')->name('checkouts.create');
Route::post('/checkout', 'CheckoutsController@store')->name('checkouts.store');
Route::delete('/checkout/{bookId}', 'CheckoutsController@destroy')->name('checkouts.destroy');

Route::get('/theme/{mode}', 'ThemeController@change')->name('theme.switch');
