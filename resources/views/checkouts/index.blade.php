@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="heading">
                <h1>Checkouts</h1>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Book Title</th>
                        <th>Date of lending</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checkouts as $checkout)
                        <tr class="visible-on-hover">
                            <td>{{ $checkout->user->email }}</td>
                            <td>{{ $checkout->book->title }}</td>
                            <td>{{ $checkout->created_at }} ({{ $checkout->created_at->diffForHumans() }})</td>
                            <td>
                                <form
                                    action="{{ route('checkouts.destroy', $checkout->book->id) }}"
                                    method="post"
                                    accept-charset="utf-8"
                                >
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}

                                    <button type="submit" class="should-appear btn btn-link inline">
                                        <span class="glyphicon glyphicon-repeat"></span> Return
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
