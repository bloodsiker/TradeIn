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

    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/dashforge.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dashforge.auth.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="page-profile">

@include('site.blocks._header')



<div class="content content-fixed content-auth">

    @yield('content')

</div>

@include('site.blocks._footer')

@stack('modals')

@include('site.blocks.scripts')

</body>
</html>
