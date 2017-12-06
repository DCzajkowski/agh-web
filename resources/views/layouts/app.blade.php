<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="search" content="{{ request('search') }}">
    <meta name="page" content="{{ request('page') }}">
    <meta name="order" content="{{ request('order') }}">
    <meta name="sort" content="{{ request('sort') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css', App::environment('production')) }}" rel="stylesheet">
    @if (session('theme') === 'dark')
        <link href="{{ asset('css/dark.css', App::environment('production')) }}" rel="stylesheet">
    @endif
</head>
<body>
    <div id="app" class="library">
        <nav>
            <div class="container nav">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        @include('layouts.logo')
                    </a>
                </div>
                <div class="dropdown">
                    <div class="dropdown-activator" onclick="document.querySelector('.dropdown-content').style.display = (document.querySelector('.dropdown-content').style.display == 'flex') ? 'none' : 'flex'">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    @auth
                        <div class="dropdown-content">
                            <div class="menu">
                                <ul>
                                    <li><a class="{{ Request::class('home') }}" href="{{ route('home') }}">Books</a></li>
                                    @can('add users')
                                        <li><a class="{{ Request::class('register') }}" href="{{ route('register') }}">Add User</a></li>
                                    @endcan
                                    @can('add books')
                                        <li><a class="{{ Request::class('books/create') }}" href="{{ route('books.create') }}">Add Book</a></li>
                                    @endcan
                                    @can('lend books')
                                        <li><a class="{{ Request::class('checkout') }}" href="{{ route('checkouts.index') }}">Current Checkouts</a></li>
                                        <li><a class="{{ Request::class('checkout/create') }}" href="{{ route('checkouts.create') }}">Lend a Book</a></li>
                                    @endcan
                                </ul>
                            </div>
                            <div class="right-menu">
                                <ul>
                                    <li><a title="Chat" href="{{ route('chat.index') }}"><span class="glyphicon glyphicon-envelope"></span></a></li>
                                    <li><a title="Switch theme" href="{{ route('theme.switch', (session('theme') === 'dark') ? 'light' : 'dark') }}"><span class="glyphicon glyphicon-adjust"></span></a></li>
                                    <li>
                                        <a title="Logout" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <span class="glyphicon glyphicon-log-out"></span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        @if (session('status'))
            <div class="container">
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if (session('alert'))
            <div class="container">
                <div class="alert alert-danger">
                    {{ session('alert') }}
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="{{ asset('js/app.js', App::environment('production')) }}"></script>
</body>
</html>
