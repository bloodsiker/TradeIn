@extends('layouts.homepage')

@section('title', 'Trade-In Програма для роздрібних мереж')

@section('content')

    <div class="header fixed_bg">
        <div class="container">
            <div class="navigation">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="logo mb-center mb-space">
                            <a href="{{ route('main') }}">
                                <img src="{{ asset('assets/img/logo/Logo_GS_orange.png')}}" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 d-flex align-items-center justify-content-center">

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-self-center mb-center">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="welcome">
                        <h2 class="header_title white">
                            TRADE-IN
                        </h2>
                        <p class="tagline">
                            Програма для
                            роздрібних мереж
                        </p>
                        <div class="actions">
                            <a href="{{ route('calculator') }}" class="button button_orange button_medium">Оцінити онлайн</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer bg_blue">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                    <h3 class="footer_logo">TRADE-IN RETAIL</h3>

                    <p class="description">
                        ТОВ «Дженерал Сервісез» <br>
                        м.Київ, пер.Я.Хомова,3 <br>
                        Бізнец-Центр «Інкрістар», офіс 15
                    </p>
                    <div>
                        <img src="{{ asset('assets/homepage/images/iso_icon.png') }}" class="img-icon-footer" alt="Iso icon">
                        <img src="{{ asset('assets/homepage/images/RRR_icon.png') }}" class="img-icon-footer" alt="RRR icon">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <h2>Довідка</h2>
                    <ul class="links">
                        <li class="item">
                            <a class="link" href="{{ asset('share/about.png') }}" target="_blank">Пам’ятка продавця</a>
                        </li>
                        <li class="item">
                            <a class="link" href="{{ asset('share/instruction.pdf') }}" target="_blank">Інструкція по діагностиці</a>
                        </li>
                        <li class="item">
                            <a class="link" href="https://youtu.be/tEywdiT48ZE" target="_blank">Відео-інструкція</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <h2>Служба підтримки</h2>
                    <p class="details">
                        <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                        <a href="callto:+380633279597" class="phone_link">063-327-95-97</a>
                    </p>
                    <p class="details">
                        <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                        <a href="mailto:support@generalse.com" class="phone_link">support@generalse.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <a class="to-top" id="buttonToTop" style="display: none;"></a>

@endsection
