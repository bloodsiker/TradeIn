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
                        <div class="avatar avatar-xxl avatar-online"><img src="{{ asset(Auth::user()->getAvatar()) }}" class="rounded-circle" alt=""></div>
                    </div><!-- col -->
                    <div class="col-sm-8 col-md-7 col-lg mg-t-20 mg-sm-t-0 mg-lg-t-25">
                        <h5 class="mg-b-2 tx-spacing--1">{{ Auth::user()->fullName() }}</h5>
                        <p class="tx-color-03 mg-b-25">{{ Auth::user()->role->name }}</p>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg mg-t-40">
                        <label class="tx-sans tx-10 tx-semibold tx-uppercase tx-color-01 tx-spacing-1 mg-b-15">Контакты</label>
                        <ul class="list-unstyled profile-info-list">
                            @if ( Auth::user()->network)
                                <li><i data-feather="home"></i> <span class="tx-color-03">Сеть: {{ Auth::user()->network->name }}</span></li>
                            @endif
                            @if (Auth::user()->shop)
                                    <li><i data-feather="home"></i> <span class="tx-color-03">Магазин: {{ Auth::user()->shop->name }}</span></li>
                            @endif
                            <li><i data-feather="smartphone"></i> {{ Auth::user()->phone ?: '(___)__-__-__' }}</li>
                            <li><i data-feather="mail"></i> <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></li>
                        </ul>
                    </div>
                </div>

            </div><!-- profile-sidebar -->
            <div class="media-body mg-t-40 mg-lg-t-0 pd-lg-x-10">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif

                <div class="card mg-b-20 mg-lg-b-25">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Персональная информация</h6>
                        <nav class="nav nav-with-icon tx-13">
                        </nav>
                    </div><!-- card-header -->
                    <div class="card-body pd-25">
                        <form action="{{ route('cabinet.profile') }}" id="infoUser" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Имя</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" id="name" placeholder="Имя" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="surname">Фамилия</label>
                                    <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ Auth::user()->surname }}" id="surname" placeholder="Фамилия" required>
                                    @error('surname')
                                        <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="patronymic">Отчество</label>
                                    <input type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ Auth::user()->patronymic }}" id="patronymic" placeholder="Отчество" required>
                                    @error('patronymic')
                                        <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" id="email" placeholder="Email" disabled>
                                    @error('email')
                                        <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">Пароль</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="" id="password" placeholder="Пароль">
                                    @error('password')
                                        <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Телефон</label>
                                    <input type="text" class="form-control phone-mask @error('phone') is-invalid @enderror" name="phone" value="{{  Auth::user()->phone }}" id="phone" autocomplete="off">
                                    @error('phone')
                                        <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="birthday">Дата рождения</label>
                                    <input type="text" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{  Auth::user()->birthday ? \Carbon\Carbon::parse(Auth::user()->birthday)->format('d.m.Y') : null }}" id="birthday" placeholder="">
                                    @error('birthday')
                                        <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="avatar" class="custom-file-input" id="avatar" onchange="processSelectedFiles(this)"
                                               aria-describedby="avatar">
                                        <label class="custom-file-label" id="file-name" for="avatar">Выберите файл</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-dark float-right"><i class="far fa-save"></i> Сохранить</button>
                        </form>
                    </div>
                </div>

                <div class="card card-profile-interest">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Авторизация через социальные сети</h6>
                    </div>
                    <div class="card-body pd-25">
                        <div class="row">
                            <div class="col-sm col-lg-12 col-xl">
                                <div class="media">
                                    <div class="wd-45 ht-45 rounded d-flex align-items-center justify-content-center" style="background: #e64a41">
{{--                                        <i data-feather="github" class="tx-white-7 wd-20 ht-20"></i>--}}
                                        <i class="fab fa-google tx-white-7 fz-20"></i>
                                    </div>
                                    <div class="media-body pd-l-25">
                                        <h6 class="tx-color-01 mg-b-5">Google</h6>
                                        <p class="tx-12 mg-b-10">
                                            @if ($account['google'])
                                                <a href="{{ route('cabinet.profile.social_unlink', ['provider' => 'google']) }}" class="btn btn-danger btn-xxs">Отвязать акканут</a>
                                            @else
                                                <a href="{{ route('cabinet.profile.social_link', ['provider' => 'google', 'social_google' => 1]) }}" class="btn btn-success btn-xxs">Привязать акканут</a>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="media">
                                    <div class="wd-45 ht-45 rounded d-flex align-items-center justify-content-center" style="background: #00a7e6">
                                        <i data-feather="linkedin" class="tx-white-7 wd-20 ht-20"></i>
                                    </div>
                                    <div class="media-body pd-l-25">
                                        <h6 class="tx-color-01 mg-b-5">Linkedin</h6>
                                        <p class="tx-12 mg-b-10">
                                            @if ($account['linkedin'])
                                                <a href="{{ route('cabinet.profile.social_unlink', ['provider' => 'linkedin']) }}" class="btn btn-danger btn-xxs">Отвязать акканут</a>
                                            @else
                                                <a href="{{ route('cabinet.profile.social_link', ['provider' => 'linkedin', 'social_linkedin' => 1]) }}" class="btn btn-success btn-xxs">Привязать акканут</a>
                                            @endif
                                        </p>
                                    </div>
                                </div><!-- media -->
                            </div><!-- col -->
                            <div class="col-sm col-lg-12 col-xl mg-t-25 mg-sm-t-0 mg-lg-t-25 mg-xl-t-0">
                                <div class="media">
                                    <div class="wd-45 ht-45 bg-primary rounded d-flex align-items-center justify-content-center">
                                        <i data-feather="facebook" class="tx-white-7 wd-20 ht-20"></i>
                                    </div>
                                    <div class="media-body pd-l-25">
                                        <h6 class="tx-color-01 mg-b-5">Facebook</h6>
                                        <p class="tx-12 mg-b-10">
                                            @if ($account['facebook'])
                                                <a href="{{ route('cabinet.profile.social_unlink', ['provider' => 'facebook']) }}" class="btn btn-danger btn-xxs">Отвязать акканут</a>
                                            @else
                                                <a href="{{ route('cabinet.profile.social_link', ['provider' => 'facebook', 'social_facebook' => 1]) }}" class="btn btn-success btn-xxs">Привязать акканут</a>
                                            @endif
                                        </p>
                                    </div>
                                </div>

{{--                                <div class="media">--}}
{{--                                    <div class="wd-45 ht-45 bg-pink rounded d-flex align-items-center justify-content-center">--}}
{{--                                        <i data-feather="instagram" class="tx-white-7 wd-20 ht-20"></i>--}}
{{--                                    </div>--}}
{{--                                    <div class="media-body pd-l-25">--}}
{{--                                        <h6 class="tx-color-01 mg-b-5">Instagram</h6>--}}
{{--                                        <p class="tx-12 mg-b-10"><a href="" class="btn btn-success btn-xxs">Привязать акканут</a></p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('lib/jquery.inputmask/jquery.inputmask.js') }}"></script>
    <script>
        $('#birthday').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            language: "{{app()->getLocale()}}",
            isRTL: false,
            autoClose: true,
            format: "dd.mm.yyyy",
        });

        $(".phone-mask").inputmask("mask", {
            "mask": "+38 (999) 999-99-99"
        });

        function processSelectedFiles(fileInput) {
            var files = fileInput.files[0];
            document.getElementById('file-name').innerText = files.name;
        }
    </script>
@endpush


