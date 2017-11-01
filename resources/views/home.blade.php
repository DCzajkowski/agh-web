@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="heading">
                <h1>Books</h1>
                @can('add books')
                    <div>
                        <a href="{{ route('books.create') }}" class="btn btn-default center-v">Add a new book &nbsp;<span style="margin-top: -1px" class="glyphicon glyphicon-plus-sign"></span></a>
                    </div>
                @endcan
            </div>

            <books-table
                :books="{{ $books }}"
                :can-update-books="{{ Auth::user()->can('update books') ? 'true' : 'false' }}"
                :can-delete-books="{{ Auth::user()->can('delete books') ? 'true' : 'false' }}"
            ></books-table>
        </div>
    </div>
</div>
@endsection
