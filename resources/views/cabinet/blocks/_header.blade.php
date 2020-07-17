<header class="navbar navbar-header navbar-header-fixed">
    <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
    <div class="navbar-brand">
        <a href="{{ route('cabinet.main') }}"><img width="200px" src="{{ asset('assets/img/logo/Logo_GS_orange.png') }}" alt=""></a>
    </div>
    <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
            <a href="{{ route('cabinet.main') }}"><img width="200px" src="{{ asset('assets/img/logo/Logo_GS_orange.png') }}" alt=""></a>
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
                        <li class="nav-sub-item"><a href="{{ route('cabinet.technic.list') }}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Тип техники</a></li>
                        <li class="nav-sub-item"><a href="{{ route('cabinet.brand.list') }}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Производители</a></li>
                        <li class="nav-sub-item"><a href="{{route('cabinet.model.list')}}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Базы данных смартфонов</a></li>
                        <li class="nav-sub-item"><a href="{{route('cabinet.buyback_bonus.list')}}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Таблица бонусов</a></li>
                    </ul>
                </li>
            @endif

            <li class="nav-item {{ request()->is('cabinet/help*') ? 'active' : null }}"><a href="{{ route('cabinet.help.list') }}" class="nav-link"><i data-feather="file-text"></i> Инструкции</a></li>

            @if(Auth::user()->isAdmin() || Auth::user()->isNetwork())
                <li class="nav-item {{ request()->is('cabinet/user*') ? 'active' : null }}"><a href="{{ route('cabinet.user.list') }}" class="nav-link"><i data-feather="box"></i> Пользователи</a></li>
            @endif

{{--            <li class="nav-item {{ request()->is('cabinet/chat*') ? 'active' : null }}"><a href="{{ route('cabinet.chat.index') }}" class="nav-link"><i data-feather="message-square"></i> Чат</a></li>--}}
        </ul>
    </div>
    <div class="navbar-right">
{{--        <div class="dropdown dropdown-message">--}}
{{--            <a href="" class="dropdown-link new-indicator" data-toggle="dropdown">--}}
{{--                <i data-feather="message-square"></i>--}}
{{--                <span>{{ $count_message }}</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                <div class="dropdown-header">Новые сообщения</div>--}}
{{--                @if($new_messages->count())--}}
{{--                    @foreach($new_messages as $new_message)--}}
{{--                        <a href="{{ route('cabinet.chat.view', ['uniq_id' => $new_message->chat->uniq_id]) }}" class="dropdown-item">--}}
{{--                            <div class="media">--}}
{{--                                @php--}}
{{--                                    $onlineStatus = $new_message->user->statusOnline() ? 'avatar-online' : 'avatar-offline';--}}
{{--                                    $user = $new_message->message->user;--}}
{{--                                @endphp--}}

{{--                                @if ($user->avatar)--}}
{{--                                    <div class="avatar avatar-sm {{ $onlineStatus }}"><img src="{{ asset($user->avatar) }}" class="rounded-circle" alt=""></div>--}}
{{--                                @else--}}
{{--                                    <div class="avatar avatar-sm {{ $onlineStatus }}"><span class="avatar-initial rounded-circle">{{ substr($user->name, 0, 1) }}</span></div>--}}
{{--                                @endif--}}
{{--                                <div class="media-body mg-l-15">--}}
{{--                                    <strong>{{ $user->fullName() }}</strong>--}}
{{--                                    <p>{{ substr($new_message->message->message, 0, 50) }}</p>--}}
{{--                                    <span>{{ Date::parse($new_message->created_at)->format('j F Y г. H:i') }}</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    @endforeach--}}
{{--                @else--}}
{{--                    <div class="media">--}}
{{--                        <div class="media-body m-3 mg-l-15">--}}
{{--                            <p>Нет новых сообщений</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <div class="dropdown-footer"><a href="{{ route('cabinet.chat.index') }}">Все сообщения</a></div>--}}
{{--            </div>--}}
{{--        </div>--}}

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
            <div class="dropdown-menu dropdown-menu-right tx-12">
                <div class="avatar avatar-lg mg-b-15"><img src="{{ asset(Auth::user()->getAvatar()) }}" class="rounded-circle" alt=""></div>
                <h6 class="tx-semibold mg-b-5">{{ Auth::user()->fullName() }}</h6>
                <p class="mg-b-25 tx-12 tx-color-03">{{ Auth::user()->role->name }}</p>

                <a href="{{ route('cabinet.profile') }}" class="dropdown-item"><i data-feather="edit-3"></i> Редактировать профиль</a>
                <a href="{{ route('cabinet.profile.bonus') }}" class="dropdown-item"><i data-feather="dollar-sign"></i> Бонусы</a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('cabinet.help.list') }}" class="dropdown-item"><i data-feather="help-circle"></i> Инструкции</a>
{{--                <a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>--}}
                <a href="{{ route('cabinet.profile.logout') }}" class="dropdown-item"><i data-feather="log-out"></i>Выйти</a>
            </div>
        </div>
    </div>
</header>

@yield('subHeader')
