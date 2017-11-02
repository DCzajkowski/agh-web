@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit a book</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('books.update', $book) }}">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') ?? $book->title }}"  autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
                            <label for="author" class="col-md-4 control-label">Author</label>

                            <div class="col-md-6">
                                <input id="author" type="text" class="form-control" name="author" value="{{ old('author') ?? $book->author }}" >

                                @if ($errors->has('author'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('author') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('publisher_id') ? ' has-error' : '' }}">
                            <label for="publisher_id" class="col-md-4 control-label">Publisher</label>

                            <div class="col-md-6">
                                <select id="publisher_id" type="text" class="form-control" name="publisher_id">
                                    <option value="" {{ old('publisher_id') ? '' : 'selected' }} disabled></option>
                                    @foreach($publishers as $publisher)
                                        <option
                                            value="{{ $publisher->id }}"
                                            {{ ($publisher->id == (old('publisher_id') ?? $book->publisher->id)) ? 'selected' : '' }}
                                        >{{ $publisher->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('publisher_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('publisher_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('release_date') ? ' has-error' : '' }}">
                            <label for="release_date" class="col-md-4 control-label">Release Date</label>

                            <div class="col-md-6">
                                <input id="release_date" type="date" class="form-control" name="release_date" value="{{ old('release_date') ?? $book->release_date }}" >

                                @if ($errors->has('release_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('release_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('barcode') ? ' has-error' : '' }}">
                            <label for="barcode" class="col-md-4 control-label">Barcode</label>

                            <div class="col-md-6">
                                <input id="barcode" type="text" class="form-control" name="barcode" value="{{ old('barcode') ?? $book->barcode }}" >

                                @if ($errors->has('barcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('barcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
