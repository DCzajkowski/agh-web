<?php

namespace App\Http\Controllers;

use App\Book;
use App\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $books = Book::with(['publisher', 'checkouts'])
            ->get()
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'publisher' => [
                        'name' => $book->publisher->name,
                    ],
                    'publisher_id' => $book->publisher_id,
                    'release_date' => $book->release_date,
                    'is_available' => $book->isAvailable(),
                ];
            });

        return view('home', [
            'books' => $books,
            'user' => Auth::user(),
        ]);
    }
}
