@extends('layouts.app')

@section('content')
<div class="container">
    <chat-box
        :users="{{ $users }}"
        :auth="{{ $auth }}"
    ></chat-box>
</div>
@endsection
