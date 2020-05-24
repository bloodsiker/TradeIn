@extends('cabinet.layouts.main')

@section('title', 'Профиль')

@push('styles')
    <link href="{{ asset('assets/css/dashforge.profile.css') }}" rel="stylesheet">
@endpush

@push('class')
    content-fixed content-profile
@endpush

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="media d-block d-lg-flex">
            <div class="profile-sidebar pd-lg-r-25">
                <div class="row">
                    <div class="col-sm-3 col-md-2 col-lg">
                        <div class="avatar avatar-xxl avatar-online"><img src="https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                    </div><!-- col -->
                    <div class="col-sm-8 col-md-7 col-lg mg-t-20 mg-sm-t-0 mg-lg-t-25">
                        <h5 class="mg-b-2 tx-spacing--1">{{ Auth::user()->fullName() }}</h5>
                        <p class="tx-color-03 mg-b-25">{{ Auth::user()->role->name }}</p>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg mg-t-40">
                        <label class="tx-sans tx-10 tx-semibold tx-uppercase tx-color-01 tx-spacing-1 mg-b-15">Контакты</label>
                        <ul class="list-unstyled profile-info-list">
                            @if ( Auth::user()->network)
                                <li><i data-feather="home"></i> <span class="tx-color-03">{{ Auth::user()->network->name }}</span></li>
                            @endif
                            @if (Auth::user()->shop)
                                    <li><i data-feather="home"></i> <span class="tx-color-03">{{ Auth::user()->shop->name }}</span></li>
                            @endif
                            <li><i data-feather="smartphone"></i> {{ Auth::user()->phone ?: '(___)__-__-__' }}</li>
                            <li><i data-feather="mail"></i> <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg mg-t-40">
                        <label class="tx-sans tx-10 tx-semibold tx-uppercase tx-color-01 tx-spacing-1 mg-b-15">Социальные сеты</label>
                        <ul class="list-unstyled profile-info-list">
                            <li><i data-feather="globe"></i> <a href="">http://fenchiumao.me/</a></li>
                            <li><i data-feather="github"></i> <a href="">@fenchiumao</a></li>
                            <li><i data-feather="twitter"></i> <a href="">@fenmao</a></li>
                            <li><i data-feather="instagram"></i> <a href="">@fenchiumao</a></li>
                            <li><i data-feather="facebook"></i> <a href="">@fenchiumao</a></li>
                        </ul>
                    </div>

                    <div class="col-sm-6 col-md-5 col-lg mg-t-40">
                        <label class="tx-sans tx-10 tx-semibold tx-uppercase tx-color-01 tx-spacing-1 mg-b-15">Explore</label>
                        <nav class="nav nav-classic tx-13">
                            <a href="" class="nav-link"><i data-feather="users"></i> <span>Groups</span></a>
                            <a href="" class="nav-link"><i data-feather="calendar"></i> <span>Events</span></a>
                            <a href="" class="nav-link"><i data-feather="briefcase"></i> <span>Jobs</span></a>
                            <a href="" class="nav-link"><i data-feather="globe"></i> <span>Discover People</span></a>
                            <a href="" class="nav-link"><i data-feather="shopping-bag"></i> <span>Buy &amp; Sell</span></a>
                        </nav>
                    </div><!-- col -->
                </div><!-- row -->

            </div><!-- profile-sidebar -->
            <div class="media-body mg-t-40 mg-lg-t-0 pd-lg-x-10">

                <div class="card mg-b-20 mg-lg-b-25">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Latest Activity</h6>
                        <nav class="nav nav-icon-only">
                            <a href="" class="nav-link"><i data-feather="more-horizontal"></i></a>
                        </nav>
                    </div><!-- card-header -->
                    <div class="card-body pd-20 pd-lg-25">
                        <div class="media align-items-center mg-b-20">
                            <div class="avatar avatar-online"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
                            <div class="media-body pd-l-15">
                                <h6 class="mg-b-3">Dyanne Aceron</h6>
                                <span class="d-block tx-13 tx-color-03">Cigarette Butt Collector</span>
                            </div>
                            <span class="d-none d-sm-block tx-12 tx-color-03 align-self-start">5 hours ago</span>
                        </div><!-- media -->
                        <p class="mg-b-20">Our team is expanding again. We are looking for a Product Manager and Software Engineer to drive our new aspects of our capital projects. If you're interested, please drop a comment here or simply message me. <a href="">#softwareengineer</a> <a href="">#engineering</a></p>

                        <div class="bd bg-gray-50 pd-y-15 pd-x-15 pd-sm-x-20">
                            <h6 class="tx-15 mg-b-3">We're hiring of Product Manager</h6>
                            <p class="mg-b-0 tx-14">Full-time, $60,000 - $80,000 annual</p>
                            <span class="tx-13 tx-color-03">Bay Area, San Francisco, CA</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent pd-y-10 pd-sm-y-15 pd-x-10 pd-sm-x-20">
                        <nav class="nav nav-with-icon tx-13">
                            <a href="" class="nav-link"><i data-feather="thumbs-up"></i> Like</a>
                            <a href="" class="nav-link"><i data-feather="message-square"></i> Comment</a>
                            <a href="" class="nav-link"><i data-feather="share"></i> Share</a>
                        </nav>
                    </div><!-- card-footer -->
                </div><!-- card -->

                <div class="card mg-b-20 mg-lg-b-25">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Work Experience</h6>
                        <nav class="nav nav-with-icon tx-13">
                            <a href="" class="nav-link"><i data-feather="plus"></i> Add New</a>
                        </nav>
                    </div><!-- card-header -->
                    <div class="card-body pd-25">
                        <div class="media d-block d-sm-flex">
                            <div class="wd-80 ht-80 bg-ui-04 rounded d-flex align-items-center justify-content-center">
                                <i data-feather="briefcase" class="tx-white-7 wd-40 ht-40"></i>
                            </div>
                            <div class="media-body pd-t-25 pd-sm-t-0 pd-sm-l-25">
                                <h5 class="mg-b-5">Area Sales Manager</h5>
                                <p class="mg-b-3 tx-color-02"><span class="tx-medium tx-color-01">ThemePixels, Inc.</span>, Bay Area, San Francisco, CA</p>
                                <span class="d-block tx-13 tx-color-03">December 2016 - Present</span>

                                <ul class="pd-l-10 mg-0 mg-t-20 tx-13">
                                    <li>Reaching the targets and goals set for my area.</li>
                                    <li>Servicing the needs of my existing customers.</li>
                                    <li>Maintaining the relationships with existing customers for repeat business.</li>
                                    <li>Reporting to top managers.</li>
                                    <li>Keeping up to date with the products.</li>
                                </ul>
                            </div>
                        </div><!-- media -->
                    </div>
                    <div class="card-footer bg-transparent pd-y-15 pd-x-20">
                        <nav class="nav nav-with-icon tx-13">
                            <a href="" class="nav-link">
                                Show More Experiences (4)
                                <i data-feather="chevron-down" class="mg-l-2 mg-r-0 mg-t-2"></i>
                            </a>
                        </nav>
                    </div><!-- card-footer -->
                </div><!-- card -->

                <div class="card mg-b-20 mg-lg-b-25">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Education</h6>
                        <nav class="nav nav-with-icon tx-13">
                            <a href="" class="nav-link"><i data-feather="plus"></i> Add New</a>
                        </nav>
                    </div><!-- card-header -->
                    <div class="card-body pd-25">
                        <div class="media">
                            <div class="wd-80 ht-80 bg-ui-04 rounded d-flex align-items-center justify-content-center">
                                <i data-feather="book-open" class="tx-white-7 wd-40 ht-40"></i>
                            </div>
                            <div class="media-body pd-l-25">
                                <h5 class="mg-b-5">BS in Computer Science</h5>
                                <p class="mg-b-3"><span class="tx-medium tx-color-02">Holy Name University</span>,  Tagbilaran City, Bohol</p>
                                <span class="d-block tx-13 tx-color-03">2002-2006</span>
                            </div>
                        </div><!-- media -->
                    </div>
                    <div class="card-footer bg-transparent pd-y-15 pd-x-20">
                        <nav class="nav nav-with-icon tx-13">
                            <a href="" class="nav-link">
                                Show More Education (2)
                                <i data-feather="chevron-down" class="mg-l-2 mg-r-0 mg-t-2"></i>
                            </a>
                        </nav>
                    </div><!-- card-footer -->
                </div><!-- card -->

                <div class="card card-profile-interest">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Interests</h6>
                        <nav class="nav nav-with-icon tx-13">
                            <a href="" class="nav-link">Browse Interests <i data-feather="arrow-right" class="mg-l-5 mg-r-0"></i></a>
                        </nav>
                    </div><!-- card-header -->
                    <div class="card-body pd-25">
                        <div class="row">
                            <div class="col-sm col-lg-12 col-xl">
                                <div class="media">
                                    <div class="wd-45 ht-45 bg-gray-900 rounded d-flex align-items-center justify-content-center">
                                        <i data-feather="github" class="tx-white-7 wd-20 ht-20"></i>
                                    </div>
                                    <div class="media-body pd-l-25">
                                        <h6 class="tx-color-01 mg-b-5">Github, Inc.</h6>
                                        <p class="tx-12 mg-b-10">Web-based hosting service for version control using Git... <a href="">Learn more</a></p>
                                        <span class="tx-12 tx-color-03">6,182,220 Followers</span>
                                    </div>
                                </div><!-- media -->

                                <div class="media">
                                    <div class="wd-45 ht-45 bg-warning rounded d-flex align-items-center justify-content-center">
                                        <i data-feather="truck" class="tx-white-7 wd-20 ht-20"></i>
                                    </div>
                                    <div class="media-body pd-l-25">
                                        <h6 class="tx-color-01 mg-b-5">DHL Express</h6>
                                        <p class="tx-12 mg-b-10">Logistics company providing international courier service... <a href="">Learn more</a></p>
                                        <span class="tx-12 tx-color-03">3,005,192 Followers</span>
                                    </div>
                                </div><!-- media -->
                            </div><!-- col -->
                            <div class="col-sm col-lg-12 col-xl mg-t-25 mg-sm-t-0 mg-lg-t-25 mg-xl-t-0">
                                <div class="media">
                                    <div class="wd-45 ht-45 bg-primary rounded d-flex align-items-center justify-content-center">
                                        <i data-feather="facebook" class="tx-white-7 wd-20 ht-20"></i>
                                    </div>
                                    <div class="media-body pd-l-25">
                                        <h6 class="tx-color-01 mg-b-5">Facebook, Inc.</h6>
                                        <p class="tx-12 mg-b-10">Online social media and social networking service company... <a href="">Learn more</a></p>
                                        <span class="tx-12 tx-color-03">12,182,220 Followers</span>
                                    </div>
                                </div><!-- media -->

                                <div class="media">
                                    <div class="wd-45 ht-45 bg-pink rounded d-flex align-items-center justify-content-center">
                                        <i data-feather="instagram" class="tx-white-7 wd-20 ht-20"></i>
                                    </div>
                                    <div class="media-body pd-l-25">
                                        <h6 class="tx-color-01 mg-b-5">Instagram</h6>
                                        <p class="tx-12 mg-b-10">Photo and video-sharing social networking service by Facebook... <a href="">Learn more</a></p>
                                        <span class="tx-12 tx-color-03">3,005,192 Followers</span>
                                    </div>
                                </div><!-- media -->
                            </div><!-- col -->
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card -->

            </div><!-- media-body -->

        </div><!-- media -->
    </div><!-- container -->
@endsection

