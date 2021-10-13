<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container " id="app">
        <div class="row">
            <div class="col-6 d-inline-flex">
                <img src="{{asset('/images/index.svg')}}" height="400px" width="600px"  alt="book"/>
            </div>
            <div class="col-6 d-inline-flex">
                <div class="align-self-center text-center">
                        <h1>Gestion bibliothéque </h1>
                        <p>Pour faciliter la gestion du bibliothéque </p>
                        <a class="h1 btn btn-primary btn-block" href="{{route('login')}}">Entrer</a>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p class="text-center">Copyright © 2020 Tizsoft </p>
    </footer>
</body>

</html>
