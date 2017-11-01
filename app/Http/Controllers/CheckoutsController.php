<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;

class CheckoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        return view('checkouts.create', [
            'book' => Book::find($id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'barcode' => ['required', 'integer', 'exists:books,barcode'],
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $book = Book::where('barcode', $data['barcode'])->first();

        if (! $book->isAvailable()) {
            return redirect()->back()->withAlert('This book is already lent to someone else.');
        }

        $user = User::where('email', $data['email'])
            ->first()
            ->borrow($book);

        return redirect()->back()->withStatus('Book has been lent.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
