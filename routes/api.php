<?php

use App\Book;
use Illuminate\Http\Request;

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

Route::get('/books/{barcode}/is-available', function ($barcode) {
    $book = \App\Book::where('barcode', $barcode)->first();

    if (is_null($book)) {
        return '0';
    }

    return $book->isAvailable() ? '2' : '1';
});
