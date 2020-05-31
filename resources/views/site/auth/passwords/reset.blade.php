@extends('layouts.app')

@push('class')
    content-fixed
@endpush

@section('content')
    <div class="container d-flex justify-content-center ht-100p">
        <div class="mx-wd-300 wd-sm-450 ht-100p d-flex flex-column align-items-center justify-content-center">
            <div class="wd-80p wd-sm-300 mg-b-15"><img src="{{ asset('assets/img/img-reset-password.png') }}" class="img-fluid" alt=""></div>
            <h4 class="tx-20 tx-sm-24">Сбросить пароль</h4>
            <p class="tx-color-03 mg-b-30 tx-center">Введите адрес электронной почты, и мы вышлем вам ссылку для сброса пароля.</p>
            @if (session('danger'))
                <div class="alert alert-danger">{{ session('danger') }}</div>
            @endif
            <form action="{{ route('password.reset') }}" method="POST">
                @csrf
                <div class="wd-100p d-flex flex-column flex-sm-row mg-b-40">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control wd-sm-250 flex-fill" placeholder="Введите адрес электронной почты">
                    <button class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0">Сбросить пароль</button>
                </div>
            </form>
        </div>
    </div>
@endsection
