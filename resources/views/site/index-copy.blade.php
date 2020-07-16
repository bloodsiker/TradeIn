@extends('layouts.homepage')

@section('title', 'Калькулятор оценки стоимости устройства')

@section('content')

    <!-- page header start  -->
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
                        <ul class="socials">
                            <li class="social__item">
                                <a class="social__link" href="#"><i aria-hidden="true"
                                                                              class="fa fa-facebook"></i></a>
                            </li>
                            <li class="social__item">
                                <a class="social__link" href="#"><i aria-hidden="true"
                                                                              class="fa fa-linkedin"></i></a>
                            </li>
                            <li class="social__item">
                                <a class="social__link" href="#"><i aria-hidden="true"
                                                                              class="fa fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="welcome">
                        <h2 class="header_title white">
                            Trade-In
                        </h2>
                        <p class="tagline">
                            Обміняй старий смартфон вигідно та надійно
                        </p>
                        <p class="subdescription">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                        <div class="actions">
                            <a href="{{ route('calculator') }}" class="button button_white button_medium">Оцінити онлайн</a>
                            <a href="#contacts" class="button button_brdr button_medium">Зворотній зв’язок</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="" style="margin-top: 130px; padding-left: 50px">
                        <img src="{{ asset('assets/homepage/images/phone.png') }}" alt="">
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

    <div class="steps ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <span class="welcome tc">
                    Як це працює?
                  </span>
                    <h2 class="title tc">
                        Всього 4 простих кроки і ви залишитеся задоволеними
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tc">
                    <div class="steps_item">1</div>
                    <h5 class="text_name tc">
                        Оцінка пристрою
                    </h5>
                    <p class="description tc">

                    </p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tc">
                    <div class="steps_item">2</div>
                    <h5 class="text_name tc">
                        Діагностика пристрою
                    </h5>
                    <p class="description tc">

                    </p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tc">
                    <div class="steps_item">3</div>
                    <h5 class="text_name tc">
                        Заповнення акта прийому-передачі
                    </h5>
                    <p class="description tc">

                    </p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 tc">
                    <div class="steps_item">4</div>
                    <h5 class="text_name tc">
                        Реєстрація, зберігання, відправка
                    </h5>
                    <p class="description tc">

                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="callback bg_grey ptb-36">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <h3 class="title_2">
                        Залиште свій номер телефону
                    </h3>
                    <h4 class="title_3">
                        і ми вам передзвонимо.
                    </h4>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <a href="#contacts" class="button button_brdr button_large">Зворотній зв’язок</a>
                </div>
            </div>
        </div>
    </div>

    <div class="steps step-block">
        <div class="container">
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2 class="title tc">Діагностика пристрою</h2>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                    <div class="step-block-number d-flex">
                        <div class="step-number align-self-center">1</div>
                        <div class="step-text align-self-center">Включити і вимкнути пристрій з приєднаним зарядним пристроєм. <b>Тест: АКБ, ЗУ</b></div>
                    </div>
                    <div class="step-block-number d-flex align-items-stretch">
                        <div class="step-number align-self-center">2</div>
                        <div class="step-text align-self-center">Авторизуватися в Store. <b>Тест: оригінальність пристрою</b></div>
                    </div>
                    <div class="step-block-number d-flex align-items-stretch">
                        <div class="step-number align-self-center">3</div>
                        <div class="step-text align-self-center">Зробити скріншот на білому і чорному тлі. <b>Тест: дисплей</b></div>
                    </div>
                    <div class="step-block-number d-flex align-items-stretch">
                        <div class="step-number align-self-center">4</div>
                        <div class="step-text align-self-center">Перевірити кнопки навігації, здійснити переміщення ярликів по екрану. <b>Тест: сенсорний висновок</b></div>
                    </div>
                    <div class="step-block-number d-flex align-items-stretch">
                        <div class="step-number align-self-center">5</div>
                        <div class="step-text align-self-center">Здійснити тестовий дзвінок з регулюванням гучності. <b>Тест: мережа, динамік, мікрофон</b></div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="step-block-number d-flex">
                        <div class="step-number align-self-center">6</div>
                        <div class="step-text align-self-center">Зняти відео і відтворити його зі звуком, відключити ЗУ і змінюючи положення. <b>Тест: камера, CPU, RAM</b></div>
                    </div>
                    <div class="step-block-number d-flex">
                        <div class="step-number align-self-center">7</div>
                        <div class="step-text align-self-center">Зробити селф-фото. <b>Тест: фронтальна камера</b></div>
                    </div>
                    <div class="step-block-number d-flex">
                        <div class="step-number align-self-center">8</div>
                        <div class="step-text align-self-center">Перевірити біометричні датчики. <b>Тест: відбиток пальця, сканер, розпізнавання особи</b></div>
                    </div>
                    <div class="step-block-number d-flex">
                        <div class="step-number align-self-center">9</div>
                        <div class="step-text align-self-center">Підключити WiFi і вийти з акаунтів (Mi, Google, Icloud). <b>Тест: WiFi, блокування</b></div>
                    </div>
                    <div class="step-block-number d-flex">
                        <div class="step-number align-self-center">10</div>
                        <div class="step-text align-self-center">Скинути настройки до заводських з очищенням інформації клієнта. <b>Тест: Видалення пользователькіх даних</b></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonials area start -->
    <div class="testimonials ptb-100" id="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2 class="title tc">
                        Оцінка пристрою
                    </h2>
                </div>
            </div>
            <div class="row align-items-start">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <span class="text_name">1. Визначити потребу</span>
                    <div class="testimonial_block mb-space">
                        <p class="description">Дізнатися у клієнта про його перевагах і побажання при виборі нового пристрою</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <span class="text_name">2. Розповісти про програму</span>
                    <div class="testimonial_block mb-space">
                        <p class="description">Повідомити про трейд-ін послузі. Виділити переваги програми і підкреслити вигоду для клієнта</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <span class="text_name">3. Оглянути пристрій</span>
                    <div class="testimonial_block mb-space">
                        <p class="description">Провести зовнішній огляд, зафіксувати механічні пошкодження і наявність всіх елементів корпусу</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-md-center align-items-start mt-md-5">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <span class="text_name">4. Оцінити пристрій</span>
                    <div class="testimonial_block mb-space">
                        <p class="description">Провести оцінку вартості в <a href="{{ route('calculator') }}">онлайн калькуляторі</a> Показати клієнту результати оцінки</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <span class="text_name">5. Повідомити про очікування</span>
                    <div class="testimonial_block mb-space">
                        <p class="description">Озвучити клієнту порядок і тривалість оформлення документів (5-8 хв)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="contacts ptb-100" id="contacts">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2 class="title tc">
                        Зворотній зв’язок
                    </h2>
                    <p class="contacts_description tc">Якщо у вас є які-небудь питання, будь ласка, заповніть форму нижче.</p>
                </div>
            </div>
            <div class="row justify-content-center feedback-form">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
                    <div class="form">
                        <form action="{{ route('support') }}" method="POST" id="feedback_form" class="form form--contacts">
                            @csrf
                            <input type="text" class="form_field" name="name" placeholder="Ім’я" required>
                            <input type="text" class="form_field" name="email" placeholder="Email" required>
                            <input type="text" class="form_field" name="phone" placeholder="Номер телефону" required>
                            <textarea class="form_textarea" name="message" placeholder="Сообщение"></textarea>
                            <button class="button button_orange button_medium" id="send_mail" type="submit">Відправити</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center feedback-success d-none">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
                    <div class="form-success text-center">
                        <h4>Спасибо за обращение. Наши специалисты свяжутся с Вами в ближайшее время</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer bg_blue">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="footer_logo">
                        <a href="{{ route('main') }}">
                            <img src="{{ asset('assets/homepage/images/Logo_GS_orange.png') }}" alt="Logo">
                        </a>
                    </div>
                    <p class="description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <ul class="socials">
                        <li class="social__item">
                            <a class="social__link" href="#"><i aria-hidden="true" class="fa fa-facebook"></i></a>
                        </li>
                        <li class="social__item">
                            <a class="social__link" href="#"><i aria-hidden="true" class="fa fa-linkedin"></i></a>
                        </li>
                        <li class="social__item">
                            <a class="social__link" href="#"><i aria-hidden="true" class="fa fa-twitter"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <h2>Довідка</h2>
                    <ul class="links">
                        <li class="item">
                            <a class="link" href="{{ asset('share/about.pdf') }}" target="_blank">Пам’ятка продавця</a>
                        </li>
                        <li class="item">
                            <a class="link" href="{{ asset('share/instruction.pdf') }}" target="_blank">Інструкція</a>
                        </li>
                        <li class="item">
                            <a class="link" href="https://youtu.be/tEywdiT48ZE">Відео</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <h2>Служба підтримки</h2>
                    <p class="details">
                        <span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                        09.00 - 20.00 пн-нд
                    </p>
                    <p class="details">
                        <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                        <a href="mailto:support@generalse.com" class="phone_link">support@generalse.com</a>
                    </p>
                    <p class="details">
                        <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                        <a href="callto:+380930000000" class="phone_link">+38(093)000-00-00</a>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <img src="{{ asset('assets/homepage/images/iso_icon.png') }}" class="img-icon-footer" alt="Iso icon">
                    <img src="{{ asset('assets/homepage/images/RRR_icon.png') }}" class="img-icon-footer" alt="RRR icon">
                </div>
            </div>
        </div>
        <!-- footer area end -->
    </div>
    <!-- privacy area start -->
    <div class="privacy bg_orange">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <p class="description">ТОВ «ДЖЕНЕРАЛ СЕРВІСЕЗ» 2016-{{ \Carbon\Carbon::now()->format('Y') }}. ВСІ ПРАВА ЗАХИЩЕНІ</p>
                </div>
            </div>
        </div>
        <!-- privacy area end -->
    </div>
    <a class="to-top" id="buttonToTop" style="display: none;"></a>
    <!-- main wrapper end -->

@endsection

@push('scripts')
    <script>
        $(function(){
            'use strict'

            $('#feedback_form').on('click', '#send_mail', function (e) {
                e.preventDefault();

                let _form = $('#feedback_form');

                $.ajax({
                    type: _form.attr('method'),
                    url: _form.attr('action'),
                    data: _form.serializeArray(),
                }).done(function(response) {
                    if (response.status == 200) {
                        $('.feedback-form').addClass('d-none');
                        $('.feedback-success').removeClass('d-none');
                    }
                });
            });
        });
    </script>
@endpush
