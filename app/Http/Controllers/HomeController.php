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
        $books = collect(DB::select('
            select `books`.*, `publishers`.`name` as publisher, case when `checkouts`.`is_returned` is null then 0 else 1 end as is_available
            from `books`
            left join `publishers` on `books`.`publisher_id` = `publishers`.`id`
            left join `checkouts` on `checkouts`.`book_id` = `books`.`id`
        '))
        ->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'publisher' => [
                    'name' => $book->publisher,
                ],
                'publisher_id' => $book->publisher_id,
                'release_date' => $book->release_date,
                'is_available' => $book->is_available,
            ];
        });

        return view('home', [
            'books' => $books,
            'user' => Auth::user(),
        ]);
    }
}
