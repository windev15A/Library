<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <!-- Custom styles for this template --> --}}
    <link href="{{asset('css/style4.css')}}" rel="stylesheet">

   
</head>

<body>
    <div class="wrapper" id="app">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 class="text-center">Gestion Bibliothéque</h3>
                <strong>GB</strong>
            </div>

            <ul class="list-unstyled components">
                <!--   <li class="active">
            <a
              href="#homeSubmenu"
              data-toggle="collapse"
              aria-expanded="false"
              class="dropdown-toggle"
            >
              <i class="fas fa-home"></i>
              Home
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
              <li>
                <a href="#">Home 1</a>
              </li>
              <li>
                <a href="#">Home 2</a>
              </li>
              <li>
                <a href="#">Home 3</a>
              </li>
            </ul>
          </li> -->

                <li class="{{ (request()->is('home')) ? 'active' : '' }}">
                    <a href="/home">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Tableau de bord
                    </a>
                </li>
                {{-- @if (auth()->user()->isAdmin) --}}

                <li class="{{ (request()->is('users')) ? 'active' : '' }}">
                    <a href="/users">
                        <i class="fas fa-user"></i>
                        Utilisateur
                    </a>
                </li>
                {{-- @endif --}}
                <li class="{{ (request()->is('adherents')) ? 'active' : '' }}">
                    <a href="/adherents">
                        <i class="fa fa-address-card"></i>
                        Adhérents
                    </a>
                </li>
                <li class="{{ (request()->is('auteurs')) ? 'active' : '' }}">
                    <a href="/auteurs">
                        <i class="fas fa-edit"></i>
                        Auteurs
                    </a>
                </li>
                <li class="{{ (request()->is('livres*')) ? 'active' : '' }}">
                    <a href="/livres">
                        <i class="fas fa-book"></i>
                        Livres
                    </a>
                </li>
                <li class="{{ (request()->is('categories')) ? 'active' : '' }}">
                    <a href="/categories">
                        <i class="fa fa-align-justify" aria-hidden="true"></i>
                        Catégories
                    </a>
                </li>
                
                <li class="{{ (request()->is('gestion')) ? 'active' : '' }}">
                    <a href="/gestion">
                        <i class="fas fa-tasks"></i>
                        Gestion
                    </a>
                </li>
                
                <li>
                    <a href="/about">
                        <i class="fas fa-briefcase"></i>
                        À propos
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                            <i class="fas fa-bars"></i>
                        </button>
                        <ul class="navbar-nav m-auto pt-2">
                            <h2 class="text-light">Bibliothéque Hassan II</h2>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
            @auth
            <router-view></router-view>
            @else
            @yield('content')

            @endauth


        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    {{-- <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script> --}}

    <script type="text/javascript">
        $(document).ready(function () {
        $("#sidebarCollapse").on("click", function () {
          $("#sidebar").toggleClass("active");
        });
      });
    </script>
</body>

</html>