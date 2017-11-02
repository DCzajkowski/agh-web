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
                base-url="{{ config('app.url') }}"
                :books="{{ $books }}"
                :search="search"
                :can-update-books="{{ $user->can('update books') ? 'true' : 'false' }}"
                :can-delete-books="{{ $user->can('delete books') ? 'true' : 'false' }}"
                :can-lend-books="{{ $user->can('lend books') ? 'true' : 'false' }}"
            ></books-table>
        </div>
    </div>
</div>
@endsection
