@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="heading">
                <h1>Books</h1>
                @can('add books')
                    <div>
                        <a href="{{ route('books.create') }}" class="btn btn-default center-v">Add a new book &nbsp;<span style="margin-top: -1px" class="glyphicon glyphicon-plus-sign"></span></a>
                    </div>
                @endcan
            </div>

            <div class="container-fluid">
                <div class="row">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
