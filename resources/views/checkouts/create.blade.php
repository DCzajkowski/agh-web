@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Lend a book</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('checkouts.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('barcode') ? ' has-error' : '' }}">
                            <label for="barcode" class="col-md-4 control-label">Book barcode</label>
                            <div class="col-md-6">
                                <check-availability value="{{ old('barcode') ?? optional($book)->barcode }}" :focus="{{ is_null($book) ? 'true' : 'false' }}"></check-availability>

                                @if ($errors->has('barcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('barcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">User email</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-user"></span></span>
                                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                                </div>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Lend a book
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
