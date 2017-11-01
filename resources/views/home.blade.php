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

            <table class="table bg-white">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th style="width: 190px">Author</th>
                        <th>Publisher</th>
                        <th style="width: 110px">Release Date</th>
                        @if ($user->can('update books') or $user->can('delete books'))
                            <th style="width: 140px"></th></tr>
                        @endif
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr class="visible-on-hover">
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher->name }}</td>
                            <td>{{ $book->release_date }}</td>
                            @if ($user->can('update books') or $user->can('delete books'))
                                <td class="books-controls">
                                    @can('update books')
                                        <a href="{{ route('books.edit', $book) }}" class="should-appear" style="margin-right: 1rem"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                    @endcan
                                    @can('delete books')
                                        <form action="{{ route('books.destroy', $book) }}" method="post" accept-charset="utf-8">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}

                                            <button type="submit" class="should-appear btn btn-link text-danger inline">
                                                <span class="glyphicon glyphicon-trash"></span> Delete
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center paginator">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
