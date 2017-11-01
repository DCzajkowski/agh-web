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
        if ($q = request('q')) {
            $publishers = Publisher::where('name', 'LIKE', "%{$q}%")
                ->get()
                ->map(function ($publisher) {
                    return $publisher->id;
                })
                ->toArray();

            $books = Book::with('publisher')
                ->where('title', 'LIKE', "%{$q}%")
                ->orWhere('author', 'LIKE', "%{$q}%")
                ->orWhereIn('publisher_id', $publishers)
                ->paginate(30);
        } else {
            $books = Book::with('publisher')->get();
        }

        return view('home', [
            'books' => $books,
            'user' => Auth::user(),
        ]);
    }
}
