<header class="navbar navbar-header navbar-header-fixed">
    <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
    <div class="navbar-brand">
        <a href="{{ route('main') }}" class="df-logo"><img width="200px" src="{{ asset('assets/img/logo/Logo_GS.png') }}" alt=""></a>
    </div>
    <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
            <a href="{{ route('main') }}" class="df-logo"><img width="200px" src="{{ asset('assets/img/logo/Logo_GS.png') }}" alt=""></a>
            <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
        </div>
        <ul class="nav navbar-menu">
            <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Навигация</li>
            <li class="nav-item"><a href="{{ route('calculator') }}" class="nav-link"><i data-feather="box"></i> Калькулятор</a></li>
            @if (Auth::check())
                <li class="nav-item"><a href="{{ route('cabinet.main') }}" class="nav-link"><i data-feather="log-in"></i> В кабинет</a></li>
            @else
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link"><i data-feather="log-in"></i> Войти</a></li>
            @endif
        </ul>
    </div>

    <div class="navbar-right">
        <a href="http://facebook.com" class="btn btn-social"><i class="fab fa-facebook"></i></a>
        <a href="https://www.linkedin.com" class="btn btn-social"><i class="fab fa-linkedin"></i></a>
        <a href="https://twitter.com" class="btn btn-social"><i class="fab fa-twitter"></i></a>
        @if (Auth::check())
            <a href="{{ route('cabinet.main') }}" class="btn btn-to-cabinet"><i data-feather="log-in"></i> <span>В кабинет</span></a>
        @endif
    </div>
</header>

@yield('subHeader')
