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
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datepicker/css/datepicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/dashforge.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dashforge.profile.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/skin.light.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @stack('styles')
    <script src="//code-ya.jivosite.com/widget/c4JV4iPW93" async></script>
</head>
<body class="page-profile">

@include('cabinet.blocks._header')


<div class="content @stack('class')">

    @yield('content')

</div>

{{--@include('cabinet.blocks._footer')--}}

@stack('modals')

@include('cabinet.blocks.scripts')

</body>
</html>
