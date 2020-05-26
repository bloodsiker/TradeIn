<header class="navbar navbar-header navbar-header-fixed">
    <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
    <div class="navbar-brand">
        <a href="{{ route('cabinet.main') }}"><img width="200px" src="{{ asset('assets/img/logo/Logo_GS.png') }}" alt=""></a>
    </div>
    <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
            <a href="../../index.html" class="df-logo">dash<span>forge</span></a>
            <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
        </div><!-- navbar-menu-header -->
        <ul class="nav navbar-menu">
            <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
            <li class="nav-item with-sub">
                <a href="" class="nav-link"><i data-feather="pie-chart"></i> Dashboard</a>
                <ul class="navbar-menu-sub">
                    <li class="nav-sub-item"><a href="dashboard-one.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Sales Monitoring</a></li>
                    <li class="nav-sub-item"><a href="dashboard-two.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Website Analytics</a></li>
                    <li class="nav-sub-item"><a href="dashboard-three.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Cryptocurrency</a></li>
                    <li class="nav-sub-item"><a href="dashboard-four.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Helpdesk Management</a></li>
                </ul>
            </li>
            <li class="nav-item with-sub">
                <a href="" class="nav-link"><i data-feather="package"></i> Apps</a>
                <ul class="navbar-menu-sub">
                    <li class="nav-sub-item"><a href="app-calendar.html" class="nav-sub-link"><i data-feather="calendar"></i>Calendar</a></li>
                    <li class="nav-sub-item"><a href="app-chat.html" class="nav-sub-link"><i data-feather="message-square"></i>Chat</a></li>
                    <li class="nav-sub-item"><a href="app-contacts.html" class="nav-sub-link"><i data-feather="users"></i>Contacts</a></li>
                    <li class="nav-sub-item"><a href="app-file-manager.html" class="nav-sub-link"><i data-feather="file-text"></i>File Manager</a></li>
                    <li class="nav-sub-item"><a href="app-mail.html" class="nav-sub-link"><i data-feather="mail"></i>Mail</a></li>
                </ul>
            </li>
            <li class="nav-item with-sub active">
                <a href="" class="nav-link"><i data-feather="layers"></i> Pages</a>
                <div class="navbar-menu-sub">
                    <div class="d-lg-flex">
                        <ul>
                            <li class="nav-label">Authentication</li>
                            <li class="nav-sub-item"><a href="page-signin.html" class="nav-sub-link"><i data-feather="log-in"></i> Sign In</a></li>
                            <li class="nav-sub-item"><a href="page-signup.html" class="nav-sub-link"><i data-feather="user-plus"></i> Sign Up</a></li>
                            <li class="nav-sub-item"><a href="page-verify.html" class="nav-sub-link"><i data-feather="user-check"></i> Verify Account</a></li>
                            <li class="nav-sub-item"><a href="page-forgot.html" class="nav-sub-link"><i data-feather="shield-off"></i> Forgot Password</a></li>
                            <li class="nav-label mg-t-20">User Pages</li>
                            <li class="nav-sub-item"><a href="page-profile-view.html" class="nav-sub-link"><i data-feather="user"></i> View Profile</a></li>
                            <li class="nav-sub-item"><a href="page-connections.html" class="nav-sub-link"><i data-feather="users"></i> Connections</a></li>
                            <li class="nav-sub-item"><a href="page-groups.html" class="nav-sub-link"><i data-feather="users"></i> Groups</a></li>
                            <li class="nav-sub-item"><a href="page-events.html" class="nav-sub-link"><i data-feather="calendar"></i> Events</a></li>
                        </ul>
                        <ul>
                            <li class="nav-label">Error Pages</li>
                            <li class="nav-sub-item"><a href="page-404.html" class="nav-sub-link"><i data-feather="file"></i> 404 Page Not Found</a></li>
                            <li class="nav-sub-item"><a href="page-500.html" class="nav-sub-link"><i data-feather="file"></i> 500 Internal Server</a></li>
                            <li class="nav-sub-item"><a href="page-503.html" class="nav-sub-link"><i data-feather="file"></i> 503 Service Unavailable</a></li>
                            <li class="nav-sub-item"><a href="page-505.html" class="nav-sub-link"><i data-feather="file"></i> 505 Forbidden</a></li>
                            <li class="nav-label mg-t-20">Other Pages</li>
                            <li class="nav-sub-item"><a href="page-timeline.html" class="nav-sub-link"><i data-feather="file-text"></i> Timeline</a></li>
                            <li class="nav-sub-item"><a href="page-pricing.html" class="nav-sub-link"><i data-feather="file-text"></i> Pricing</a></li>
                            <li class="nav-sub-item"><a href="page-help-center.html" class="nav-sub-link"><i data-feather="file-text"></i> Help Center</a></li>
                            <li class="nav-sub-item"><a href="page-invoice.html" class="nav-sub-link"><i data-feather="file-text"></i> Invoice</a></li>
                        </ul>
                    </div>
                </div><!-- nav-sub -->
            </li>
            <li class="nav-item with-sub">
                <a href="" class="nav-link"><i data-feather="pie-chart"></i> Заявки</a>
                <ul class="navbar-menu-sub">
                    <li class="nav-sub-item"><a href="{{ route('cabinet.buyback_request.list') }}" class="nav-sub-link"><i data-feather="mail"></i>Заявки на выкуп</a></li>
                    <li class="nav-sub-item"><a href="{{ route('cabinet.model_request.list') }}" class="nav-sub-link"><i data-feather="mail"></i>Заявки на добавление в калькулятор</a></li>
                </ul>
            </li>
            <li class="nav-item with-sub">
                <a href="" class="nav-link"><i data-feather="pie-chart"></i> Справочник</a>
                <ul class="navbar-menu-sub">
                    <li class="nav-sub-item"><a href="{{ route('cabinet.network.list') }}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Торговые сети</a></li>
                    <li class="nav-sub-item"><a href="{{ route('cabinet.shop.list') }}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Магазины</a></li>
                    <li class="nav-sub-item"><a href="{{ route('cabinet.brand.list') }}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Производители</a></li>
                    <li class="nav-sub-item"><a href="{{route('cabinet.model.list')}}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Модели девайсов</a></li>
                    <li class="nav-sub-item"><a href="{{route('cabinet.buyback_bonus.list')}}" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Таблица бонусов</a></li>
                </ul>
            </li>
            <li class="nav-item"><a href="{{ route('cabinet.user.list') }}" class="nav-link"><i data-feather="box"></i> Пользователи</a></li>
        </ul>
    </div>
    <div class="navbar-right">
        <div class="dropdown dropdown-message">
            <a href="" class="dropdown-link new-indicator" data-toggle="dropdown">
                <i data-feather="message-square"></i>
                <span>5</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">New Messages</div>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/350" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <strong>Socrates Itumay</strong>
                            <p>nam libero tempore cum so...</p>
                            <span>Mar 15 12:32pm</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <strong>Joyce Chua</strong>
                            <p>on the other hand we denounce...</p>
                            <span>Mar 13 04:16am</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/600" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <strong>Althea Cabardo</strong>
                            <p>is there anyone who loves...</p>
                            <span>Mar 13 02:56am</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <strong>Adrian Monino</strong>
                            <p>duis aute irure dolor in repre...</p>
                            <span>Mar 12 10:40pm</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
                <div class="dropdown-footer"><a href="">View all Messages</a></div>
            </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
        <div class="dropdown dropdown-notification">
            <a href="" class="dropdown-link new-indicator" data-toggle="dropdown">
                <i data-feather="bell"></i>
                <span>2</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">Notifications</div>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/350" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                            <span>Mar 15 12:32pm</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <p><strong>Joyce Chua</strong> just created a new blog post</p>
                            <span>Mar 13 04:16am</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/600" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                            <span>Mar 13 02:56am</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <p><strong>Adrian Monino</strong> added new comment on your photo</p>
                            <span>Mar 12 10:40pm</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-footer"><a href="">View all Notifications</a></div>
            </div>
        </div>
        <div class="dropdown dropdown-profile">
            <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                <div class="avatar avatar-sm"><img src="{{ asset(Auth::user()->getAvatar()) }}" class="rounded-circle" alt=""></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right tx-13">
                <div class="avatar avatar-lg mg-b-15"><img src="{{ asset(Auth::user()->getAvatar()) }}" class="rounded-circle" alt=""></div>
                <h6 class="tx-semibold mg-b-5">{{ Auth::user()->fullName() }}</h6>
                <p class="mg-b-25 tx-12 tx-color-03">{{ Auth::user()->role->name }}</p>

                <a href="{{ route('cabinet.profile') }}" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
                <a href="page-profile-view.html" class="dropdown-item"><i data-feather="user"></i> View Profile</a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item"><i data-feather="help-circle"></i> Help Center</a>
                <a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>
                <a href="{{ route('cabinet.profile.logout') }}" class="dropdown-item"><i data-feather="log-out"></i>Выйти</a>
            </div>
        </div>
    </div>
</header>

@yield('subHeader')
