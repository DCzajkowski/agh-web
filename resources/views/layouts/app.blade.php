<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css', App::environment('production')) }}" rel="stylesheet">
    @if (session('theme') === 'dark')
        <link href="{{ asset('css/dark.css', App::environment('production')) }}" rel="stylesheet">
    @endif
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li>
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search books..." name="q" value="{{ request('q') }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @can('add users')
                                        <li><a href="{{ route('register') }}"><span style="margin-right: 1rem" class="glyphicon glyphicon-user"></span> Add User</a></li>
                                    @endcan
                                    @can('add books')
                                        <li><a href="{{ route('books.create') }}"><span style="margin-right: 1rem" class="glyphicon glyphicon-book"></span> Add Book</a></li>
                                    @endcan
                                    @can('lend books')
                                        <li><a href="{{ route('checkouts.create') }}"><span style="margin-right: 1rem" class="glyphicon glyphicon-edit"></span> Lend a Book</a></li>
                                    @endcan
                                    <li>
                                        <a href="{{ route('theme.switch', (session('theme') === 'dark') ? 'light' : 'dark') }}"><span style="margin-right: 1rem" class="glyphicon glyphicon-adjust"></span> {{ (session('theme') === 'dark') ? 'Light theme' : 'Dark theme' }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <span style="margin-right: 1rem" class="glyphicon glyphicon-log-out"></span> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
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
