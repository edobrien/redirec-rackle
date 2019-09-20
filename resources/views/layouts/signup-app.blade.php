<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="img/fav.png">
    <title>Recdirec</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Used for google recaptcha-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="/js/jquery.min.js"></script>
    <!-- Used for yajra datatables-->
    <script src="/js/jquery.dataTables.min.js"></script>
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    @yield('head')
</head>
<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
    <div raw-ajax-busy-indicator class="bg_load text-center" style="display: none !important;">
        <img src="/img/loader.gif" style="margin-top:25%;margin-left:50%">
    </div>
</body>
</html>
