<?php

namespace App\Http\Controllers;

use App\Book;
use App\Publisher;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(optional($this->request->user())->hasPermissionTo('add books'), 403);

        return view('books.create', ['publishers' => Publisher::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        abort_unless(optional($this->request->user())->hasPermissionTo('add books'), 403);

        $data = $this->request->validate([
            'title' => ['required'],
            'author' => ['required'],
            'publisher_id' => ['required', 'exists:publishers,id'],
            'release_date' => ['required'],
            'barcode' => ['required', 'numeric', 'unique:books,barcode', 'digits:13'],
        ]);

        Book::create($data);

        return redirect(route('home'))->withStatus('Successfully added a book');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(optional($this->request->user())->hasPermissionTo('update books'), 403);

        return view('books.edit', [
            'book' => Book::findOrFail($id),
            'publishers' => Publisher::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        abort_unless(optional($this->request->user())->hasPermissionTo('update books'), 403);

        $data = $this->request->validate([
            'title' => ['required'],
            'author' => ['required'],
            'publisher_id' => ['required', 'exists:publishers,id'],
            'release_date' => ['required'],
            'barcode' => ['required', 'numeric', 'unique:books,barcode,' . $id, 'digits:13'],
        ]);

        Book::findOrFail($id)->update($data);

        return redirect()->back()->withStatus('All changes saved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(optional($this->request->user())->hasPermissionTo('delete books'), 403);

        Book::findOrFail($id)->delete();

        return redirect()->back()->withStatus('Successfully removed a book from the database');
    }
}
