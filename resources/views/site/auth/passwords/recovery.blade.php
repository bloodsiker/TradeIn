@extends('layouts.app')

@push('class')
    content-fixed
@endpush

@section('content')
    <div class="container d-flex justify-content-center ht-100p">
        <div class="mx-wd-300 wd-sm-450 ht-100p d-flex flex-column align-items-center justify-content-center">
            <div class="wd-80p wd-sm-300 mg-b-15"><img src="{{ asset('assets/img/img-reset-password.png') }}" class="img-fluid" alt=""></div>
            <h4 class="tx-20 tx-sm-24">Востановление пароля</h4>
            @if ($errorToken)
                <div class="alert alert-danger">Время для востановления пароля - вышло</div>
            @elseif ($emptyToken)
                <div class="alert alert-danger">Не верный токен</div>
            @else

                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif

                <form action="{{ route('password.recovery') }}" method="POST">
                    @csrf
                    <input type="hidden" name="remember_token" value="{{ request('remember_token') }}">
                    <div class="wd-150p d-flex flex-column flex-sm-row mg-b-40">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control wd-sm-250 flex-fill" placeholder="Введите новый пароль">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirm" class="form-control wd-sm-250 flex-fill" placeholder="Повторите пароль">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0">Изменить пароль</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
