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
                                <img src="{{ asset('assets/homepage/images/Logo_GS.png') }}" alt="Logo">
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
                            Обміняй старий смартфон вигідно та надійно
                        </p>
                        <div class="actions">
                            <a href="{{ route('calculator') }}" class="button button_orange button_medium">Оцінити онлайн</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="steps ptb-100 bg_gray">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2 class="title tc">
                        Як це працює?
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tc">
                    <div class="steps_item">1</div>
                    <h5 class="text_name tc">
                        Оцініть пристрій
                    </h5>
                    <p class="description tc">
                        Здійсніть оцінку вартості клієнтського пристрою за 15 секунд з допомогою онлайн- калькулятора
                    </p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tc">
                    <div class="steps_item">2</div>
                    <h5 class="text_name tc">
                        Зробість тест
                    </h5>
                    <p class="description tc">
                        Протестуйте основні функції пристрою, керуючись простим алгоритмом діагностики
                    </p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tc">
                    <div class="steps_item">3</div>
                    <h5 class="text_name tc">
                        Заповність заявку
                    </h5>
                    <p class="description tc">
                        Авторизуйтеся в системі оцінки та оформіть заявку на обмін. Підтвердження відбувається автоматично
                    </p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tc">
                    <div class="steps_item">4</div>
                    <h5 class="text_name tc">
                        Підпишіть акт
                    </h5>
                    <p class="description tc">
                        Роздрукуйте та підпишіть з клієнтом Акт прийома-передачі, який генерується системою автоматично
                    </p>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tc block_description">
                    КОМПАНІЯ GENERAL SERVICES САМОСТІЙНЕ ОРГАНІЗУЄ ЗАБІР ТА ДОСТАВКУ ЗАМІНЕНИХ ПРИСТРОЇВ.
                    <span class="text_orange">ПІСЛЯ ОТРИМАННЯ ТЕХНІКИ МИ НАРАХУЄМО БОНУС ПРОДАВЦЕВІ ЗА КОЖНУ КОРЕКТНО ОФОРМЛЕНУ ЗАЯВКУ НА ОБМІН.</span>
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
                            <a class="link" href="{{ asset('share/about.pdf') }}" target="_blank">Пам’ятка продавця</a>
                        </li>
                        <li class="item">
                            <a class="link" href="{{ asset('share/instruction.pdf') }}" target="_blank">Інструкція по діагностиці</a>
                        </li>
                        <li class="item">
                            <a class="link" href="https://youtu.be/tEywdiT48ZE">Відео-інструкція</a>
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
