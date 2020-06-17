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
    <link href="{{ asset('assets/css/dashforge.chat.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="app-chat">

@include('cabinet.blocks._header')


<div class="chat-wrapper @stack('class')">

    @yield('content')

</div>

{{--@include('cabinet.blocks._footer')--}}

@stack('modals')

{{--@include('cabinet.blocks.scripts')--}}

<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('assets/js/dashforge.js') }}"></script>
<script src="{{ asset('assets/js/dashforge.chat.js') }}"></script>

<script src="{{ asset('lib/js-cookie/js.cookie.js') }}"></script>



@stack('scripts')

</body>
</html>
