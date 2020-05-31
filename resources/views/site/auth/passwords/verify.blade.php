@extends('layouts.app')

@push('class')
    content-fixed
@endpush

@section('content')
    <div class="container ht-100p">
        <div class="ht-100p d-flex flex-column align-items-center justify-content-center">
            <div class="wd-150 wd-sm-250 mg-b-30"><img src="{{ asset('assets/img/verify.png') }}" class="img-fluid" alt=""></div>
            <h4 class="tx-20 tx-sm-24">Проверьте свой адрес электронной почты</h4>
            <p class="tx-color-03 mg-b-40">Пожалуйста, проверьте свою электронную почту и нажмите кнопку что бы сбросить пароль</p>
            <div class="tx-13 tx-lg-14 mg-b-40">
                <a href="{{ route('password.reset') }}" class="btn btn-brand-02 d-inline-flex align-items-center">Отправить повторно подтверждение</a>
            </div>
        </div>
    </div>
@endsection
