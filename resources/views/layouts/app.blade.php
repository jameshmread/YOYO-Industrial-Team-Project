<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>YOYO - Statistics</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img width="100" alt="Yoyo Logo" src="data:image/png;base64,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">
                    </a>
                </div>
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else

                            @if(Auth::user()->is_admin === 1)
                                <li>
                                    <a href="{{route('admin.dashboard')}}">Admin Dashboard</a>
                                </li>
                            @endif

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        View Data <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li class="dropdown-header"><h5>Stores</h5></li>
                                        <li>
                                            <a href="{{route('store.revenue')}}">Transaction average per Store</a>
                                        </li>

                                        <li>
                                            <a href="{{route('store.retained')}}">User retention rate per Store</a>
                                        </li>

                                        <li>
                                            <a href="{{route('store.unique')}}">Unique users per Store</a>
                                        </li>

                                        <li>
                                            <a href="{{route('store.date')}}">Sales over date range per Store</a>
                                        </li>

                                        <li>
                                            <a href="{{route('store.total')}}">Total sales per Store</a>
                                        </li>

                                        <br>

                                        <li class="dropdown-header"><h5>Users</h5></li>
                                        <li>
                                            <a href="{{route('user.volumeperstore')}}">User Volume per Store</a>
                                        </li>
                                    </ul>
                                </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{route('user.edit', Auth::user()->id)}}">Edit profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
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

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
