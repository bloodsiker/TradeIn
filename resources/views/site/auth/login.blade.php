@extends('layouts.app')

@push('class')
    content-fixed
@endpush

@section('content')
    <div class="container">
        <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
            <div class="media-body align-items-center d-none d-lg-flex">
                <div class="mx-wd-600">
                    <img src="{{ asset('assets/img/img-login.png') }}" class="img-fluid" alt="">
                </div>
                <div class="pos-absolute b-0 l-0 tx-12 tx-center">

                </div>
            </div>
            <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                <div class="wd-100p">
                    <h3 class="tx-color-01 mg-b-5">Войти в систему</h3>
                    <p class="tx-color-03 tx-16 mg-b-40">Пожалуйста, войдите, чтобы продолжить.</p>
                    @if (session('danger'))
                        <div class="alert alert-danger">{{ session('danger') }}</div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="yourname@yourmail.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between mg-b-5">
                                <label class="mg-b-0-f" for="password">Пароль</label>
                                <a href="{{ route('password.reset') }}" class="tx-13">Забыли пароль?</a>
                            </div>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Введите ваш пароль">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button class="btn btn-brand-02 btn-block">Войти</button>
                    </form>

                    <div class="divider-text">или</div>
                    <a href="" class="btn btn-outline-facebook btn-block">Войти через Facebook</a>
                    <a href="" class="btn btn-outline-twitter btn-block">Войти через Twitter</a>
                    <a href="" class="btn btn-outline-google btn-block">Войти через Google</a>
                </div>
            </div>
        </div>
    </div>
@endsection
