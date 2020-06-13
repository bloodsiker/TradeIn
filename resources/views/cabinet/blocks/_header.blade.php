<header class="navbar navbar-header navbar-header-fixed">
    <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
    <div class="navbar-brand">
        <a href="{{ route('cabinet.main') }}"><img width="200px" src="{{ asset('assets/img/logo/Logo_GS.png') }}" alt=""></a>
    </div>
    <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
            <a href="{{ route('cabinet.main') }}"><img width="200px" src="{{ asset('assets/img/logo/Logo_GS.png') }}" alt=""></a>
            <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
        </div>
        <ul class="nav navbar-menu">
            <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Навигация</li>
            <li class="nav-item {{ request()->is('cabinet/calculator*') ? 'active' : null }}"><a href="{{ route('cabinet.main') }}" class="nav-link"><i data-feather="box"></i> Калькулятор</a></li>
            <li class="nav-item with-sub">
                <a href="" class="nav-link"><i data-feather="package"></i> Заявки</a>
                <ul class="navbar-menu-sub">
                    <li class="nav-sub-item"><a href="{{ route('cabinet.buyback_request.list') }}" class="nav-sub-link"><i data-feather="mail"></i>Заявки на выкуп</a></li>
                    @if(Auth::user()->isAdmin() || Auth::user()->isShop())
                        <li class="nav-sub-item"><a href="{{ route('cabinet.model_request.list') }}" class="nav-sub-link"><i data-feather="mail"></i>Заявки на добавление в калькулятор</a></li>
                    @endif
                </ul>
            </li>
            @if(Auth::user()->isAdmin())
                <li class="nav-item with-sub">
                    <a href="" class="nav-link"><i data-feather="package"></i> Справочник</a>
                    <ul class="navbar-menu-sub">
                        <li class="nav-sub-item"><a href="{{ route('cabinet.network.list') }}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Торговые сети</a></li>
                        <li class="nav-sub-item"><a href="{{ route('cabinet.shop.list') }}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Магазины</a></li>
                        <li class="nav-sub-item"><a href="{{ route('cabinet.brand.list') }}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Производители</a></li>
                        <li class="nav-sub-item"><a href="{{route('cabinet.model.list')}}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Базы данных смартфонов</a></li>
                        <li class="nav-sub-item"><a href="{{route('cabinet.buyback_bonus.list')}}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Таблица бонусов</a></li>
                    </ul>
                </li>
            @endif

            <li class="nav-item {{ request()->is('cabinet/help*') ? 'active' : null }}"><a href="{{ route('cabinet.help.list') }}" class="nav-link"><i data-feather="box"></i> Инструкции</a></li>

            @if(Auth::user()->isAdmin() || Auth::user()->isNetwork())
                <li class="nav-item {{ request()->is('cabinet/users*') ? 'active' : null }}"><a href="{{ route('cabinet.user.list') }}" class="nav-link"><i data-feather="box"></i> Пользователи</a></li>
            @endif
        </ul>
    </div>
    <div class="navbar-right">
{{--        <div class="dropdown dropdown-message">--}}
{{--            <a href="" class="dropdown-link new-indicator" data-toggle="dropdown">--}}
{{--                <i data-feather="message-square"></i>--}}
{{--                <span>5</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                <div class="dropdown-header">New Messages</div>--}}
{{--                <a href="" class="dropdown-item">--}}
{{--                    <div class="media">--}}
{{--                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/350" class="rounded-circle" alt=""></div>--}}
{{--                        <div class="media-body mg-l-15">--}}
{{--                            <strong>Socrates Itumay</strong>--}}
{{--                            <p>nam libero tempore cum so...</p>--}}
{{--                            <span>Mar 15 12:32pm</span>--}}
{{--                        </div><!-- media-body -->--}}
{{--                    </div><!-- media -->--}}
{{--                </a>--}}
{{--                <a href="" class="dropdown-item">--}}
{{--                    <div class="media">--}}
{{--                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>--}}
{{--                        <div class="media-body mg-l-15">--}}
{{--                            <strong>Joyce Chua</strong>--}}
{{--                            <p>on the other hand we denounce...</p>--}}
{{--                            <span>Mar 13 04:16am</span>--}}
{{--                        </div><!-- media-body -->--}}
{{--                    </div><!-- media -->--}}
{{--                </a>--}}
{{--                <a href="" class="dropdown-item">--}}
{{--                    <div class="media">--}}
{{--                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/600" class="rounded-circle" alt=""></div>--}}
{{--                        <div class="media-body mg-l-15">--}}
{{--                            <strong>Althea Cabardo</strong>--}}
{{--                            <p>is there anyone who loves...</p>--}}
{{--                            <span>Mar 13 02:56am</span>--}}
{{--                        </div><!-- media-body -->--}}
{{--                    </div><!-- media -->--}}
{{--                </a>--}}
{{--                <a href="" class="dropdown-item">--}}
{{--                    <div class="media">--}}
{{--                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>--}}
{{--                        <div class="media-body mg-l-15">--}}
{{--                            <strong>Adrian Monino</strong>--}}
{{--                            <p>duis aute irure dolor in repre...</p>--}}
{{--                            <span>Mar 12 10:40pm</span>--}}
{{--                        </div><!-- media-body -->--}}
{{--                    </div><!-- media -->--}}
{{--                </a>--}}
{{--                <div class="dropdown-footer"><a href="">View all Messages</a></div>--}}
{{--            </div><!-- dropdown-menu -->--}}
{{--        </div><!-- dropdown -->--}}
{{--        <div class="dropdown dropdown-notification">--}}
{{--            <a href="" class="dropdown-link new-indicator" data-toggle="dropdown">--}}
{{--                <i data-feather="bell"></i>--}}
{{--                <span>2</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                <div class="dropdown-header">Notifications</div>--}}
{{--                <a href="" class="dropdown-item">--}}
{{--                    <div class="media">--}}
{{--                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/350" class="rounded-circle" alt=""></div>--}}
{{--                        <div class="media-body mg-l-15">--}}
{{--                            <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>--}}
{{--                            <span>Mar 15 12:32pm</span>--}}
{{--                        </div><!-- media-body -->--}}
{{--                    </div><!-- media -->--}}
{{--                </a>--}}
{{--                <a href="" class="dropdown-item">--}}
{{--                    <div class="media">--}}
{{--                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>--}}
{{--                        <div class="media-body mg-l-15">--}}
{{--                            <p><strong>Joyce Chua</strong> just created a new blog post</p>--}}
{{--                            <span>Mar 13 04:16am</span>--}}
{{--                        </div><!-- media-body -->--}}
{{--                    </div><!-- media -->--}}
{{--                </a>--}}
{{--                <a href="" class="dropdown-item">--}}
{{--                    <div class="media">--}}
{{--                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/600" class="rounded-circle" alt=""></div>--}}
{{--                        <div class="media-body mg-l-15">--}}
{{--                            <p><strong>Althea Cabardo</strong> just created a new blog post</p>--}}
{{--                            <span>Mar 13 02:56am</span>--}}
{{--                        </div><!-- media-body -->--}}
{{--                    </div><!-- media -->--}}
{{--                </a>--}}
{{--                <a href="" class="dropdown-item">--}}
{{--                    <div class="media">--}}
{{--                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>--}}
{{--                        <div class="media-body mg-l-15">--}}
{{--                            <p><strong>Adrian Monino</strong> added new comment on your photo</p>--}}
{{--                            <span>Mar 12 10:40pm</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                <div class="dropdown-footer"><a href="">View all Notifications</a></div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="dropdown dropdown-profile">
            <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                <div class="avatar avatar-sm"><img src="{{ asset(Auth::user()->getAvatar()) }}" class="rounded-circle" alt=""></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right tx-13">
                <div class="avatar avatar-lg mg-b-15"><img src="{{ asset(Auth::user()->getAvatar()) }}" class="rounded-circle" alt=""></div>
                <h6 class="tx-semibold mg-b-5">{{ Auth::user()->fullName() }}</h6>
                <p class="mg-b-25 tx-12 tx-color-03">{{ Auth::user()->role->name }}</p>

                <a href="{{ route('cabinet.profile') }}" class="dropdown-item"><i data-feather="edit-3"></i> Редактировать профиль</a>
                <a href="" class="dropdown-item"><i data-feather="dollar-sign"></i> Бонусы</a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('cabinet.help.list') }}" class="dropdown-item"><i data-feather="help-circle"></i> Help Center</a>
{{--                <a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>--}}
                <a href="{{ route('cabinet.profile.logout') }}" class="dropdown-item"><i data-feather="log-out"></i>Выйти</a>
            </div>
        </div>
    </div>
</header>

@yield('subHeader')
