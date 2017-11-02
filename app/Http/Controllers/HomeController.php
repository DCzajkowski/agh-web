<?php

namespace App\Http\Controllers;

use App\Book;
use App\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = DB::select('
            SELECT
                books.*,
                publishers.name AS publisher,
                CASE WHEN checkouts.is_returned IS NULL THEN 1 ELSE 0 END AS is_available
            FROM books
            LEFT JOIN publishers
                ON books.publisher_id = publishers.id
            LEFT JOIN checkouts
                ON checkouts.book_id = books.id
        ');

        return view('home', [
            'books' => json_encode($books),
            'user' => Auth::user(),
        ]);
    }
}
