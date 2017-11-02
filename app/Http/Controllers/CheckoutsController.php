<?php

namespace App\Http\Controllers;

use App\Book;
use App\Checkout;
use App\User;
use Illuminate\Http\Request;

class CheckoutsController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(optional($this->request->user())->hasPermissionTo('lend books'), 403);

        return view('checkouts.index', [
            'checkouts' => Checkout::with(['book', 'user'])->where('is_returned', false)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        abort_unless(optional($this->request->user())->hasPermissionTo('lend books'), 403);

        return view('checkouts.create', [
            'book' => Book::find($id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        abort_unless(optional($this->request->user())->hasPermissionTo('lend books'), 403);

        $data = $this->request->validate([
            'barcode' => ['required', 'numeric', 'exists:books,barcode'],
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
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
        abort_unless(optional($this->request->user())->hasPermissionTo('lend books'), 403);

        $checkout = Checkout::where('book_id', $id)->where('is_returned', false)->first();

        if (is_null($checkout)) {
            return redirect()->back()->withAlert('This book is not lent to anyone.');
        }

        $checkout->is_returned = true;
        $checkout->save();

        return redirect()->back()->withStatus('Book returned successfully.');
    }
}
