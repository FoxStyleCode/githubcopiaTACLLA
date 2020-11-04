<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--font awesome-->
    <script src="https://kit.fontawesome.com/7309319a36.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stilos.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}" defer></script>

    @yield('css')
</head>
<body>
    
    <div id="app">
        <nav class="navbar navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            
                            @can('leer-usuarios')
                            <li>
                            <a href="{{url('usuarios')}}" class="nav-link">Usuarios</a>
                            </li>
                            @endcan
                            @can('leer-roles')
                            <li>
                                <a href="{{url('roles')}}" class="nav-link">Roles</a>
                            </li>
                            @endcan
                            @can('ver-proyecto')
                            <li>
                                <a href="{{url('proyectos')}}" class="nav-link">Proyectos</a>
                            </li>
                            @endcan
                            @can('ver-log')
                            <li>
                                <a href="{{url('logs')}}" class="nav-link">Log</a>
                            </li>
                            @endcan
                            
                            <li>
                                <a href="{{url('plantillas')}}" class="nav-link">Links</a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#">
                                    <i class="far fa-comment"></i>
                                    <span class="badge badge-warning navbar-badge">
                                    @if(count(auth()->user()->unreadNotifications))
                                        <span class="badge badge-warning">{{count(auth()->user()->unreadNotifications)}}</span>
                                    @endif
                                </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                    <span class="dropdown-header">Notificacion no leidas</span>
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-envelope mr-2"></i> {{$notification->data['usuario']}}
                                        <span class="pull-right text-muted ml-3 text-sm">{{$notification->created_at->diffForHumans()}}</span>
                                    </a>
                                    @endforeach
                                <div class="dropdown-divider"></div>
                                    <span class="dropdown-header center">Notificacion leidas</span>
                                    @forelse (auth()->user()->readNotifications as $notification)
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-envelope mr-2"></i> {{$notification->data['usuario']}}
                                        <span class="ml-3 pull-right text-muted ml-3 text-sm">{{$notification->created_at->diffForHumans()}}</span>
                                    </a>
                                    @empty
                                    <hr>
                                    <span class="ml-4 pull-right text-muted text-sm">Sin notificaciones leidas</span>
                                    @endforelse
                        
                                <div class="dropdown-divider"></div>
                                <a href="{{route('marcarLeidas')}}" class="dropdown-item dropdown-footer">Marcar todas como leidas</a>
                                </div>
                            </li>
                            @yield('ItemNa')

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>  

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <div class="scripts">
        @yield('scripts')
    </div>
    
</body>
</html>
