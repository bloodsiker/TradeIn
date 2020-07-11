<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Cabinet trade">
    <meta name="author" content="Dmitry Ovsiichuk">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <link href="{{ asset('assets/homepage/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/homepage/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/homepage/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/homepage/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/homepage/css/menu.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/homepage.css') }}" rel="stylesheet">
</head>
<body>
<div class="wrapper">

    @yield('content')

</div>

<script src="{{ asset('assets/homepage/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/homepage/js/tether.min.js') }}"></script>
<script src="{{ asset('assets/homepage/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/homepage/js/script.js') }}"></script>

@stack('scripts')

</body>
</html>
