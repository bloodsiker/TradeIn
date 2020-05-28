@extends('layouts.app')

@section('title', 'Калькулятор оценки стоимости устройства')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Калькулятор оценки стоимости устройства</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

<section class="cost_page">

    <div class="select_cost">
        <div class="left_block">
            <div class="select">
                <div class="brand">
                    <div class="brand-search-one">
                        <p class="brand-search-text"></p>
                        <input class="brand-search" type="text" placeholder="Выберите производителя">
                    </div>
                    <ul class="brand-list" id="brand-list"></ul>
                </div>
                <div class="model">
                    <div class="model-search-one">
                        <p class="model-search-text"></p>
                        <input class="model-search" type="text" placeholder="Выберите модель">
                    </div>
                    <ul class="model-list"></ul>
                </div>
            </div>
            <div class="power">
                <div class="disabled-off disabled"></div>
                <p class="power_question">Ваш телефон включается?</p>
                <div class="power_option">
                    <button class="power_option1">Да</button>
                    <button class="power_option2">Нет</button>
                </div>
            </div>
            <div class="screen">
                <div class="disabled-off disabled"></div>
                <div class="screen-block">
                    <p class="screen_question">Экран устройства полностью рабочий?</p>
                    <ul class="screen_title">
                        <li>На экране нет трещин, сколов</li>
                        <li>На экране нет полос, пятен, битых пикселей, остаточного изображения</li>
                        <li>Подсветка равномерная по всему экрану</li>
                        <li>Сенсор полностью рабочий</li>
                    </ul>
                </div>
                <div class="screen_option">
                    <button class="screen_option1">Да</button>
                    <button class="screen_option2">Нет</button>
                </div>
            </div>
            <div class="function_phone">
                <div class="disabled-off disabled"></div>
                <div class="function_phone-block">
                    <p class="function_phone-question">Все функции устройства работают?</p>
                    <ul class="function_phone-title">
                        <li>Динамик и микрофон</li>
                        <li>Кнопки включения, громкости</li>
                        <li>Сканер отпечатка пальца, лицо, сетчатки глаза</li>
                        <li>Камеры основная, фронтальная и вспышки</li>
                        <li>Мобильная связь, Wi-Fi, Bluetooth, GPS</li>
                        <li>Разъемы зарядки и наушников</li>
                        <li>Датчик приближения, гироскоп, компас</li>
                    </ul>
                </div>
                <div class="function_phone-option">
                    <button class="function_phone-option1">Да</button>
                    <button class="function_phone-option2">Нет</button>
                </div>
            </div>
            <div class="screen_state">
                <div class="disabled-off disabled"></div>
                <p class="screen_state-question">Выберите состояние экрана наиболее похож на ваш.</p>
                <div class="screen_state-option">
                    <button class="screen_state-option1"><img src="{{ asset('assets/img/calculator/display_grade_A.jpg') }}" alt="">
                        <p>* Нет царапин</p></button>
                    <button class="screen_state-option2"><img src="{{ asset('assets/img/calculator/display_grade_B.jpg') }}" alt="">
                        <p>* Едва заметные</p></button>
                    <button class="screen_state-option3"><img src="{{ asset('assets/img/calculator/display_grade_C.jpg') }}" alt="">
                        <p>* Достаточно заметные</p></button>
                    <button class="screen_state-option4"><img src="{{ asset('assets/img/calculator/display_grade_D.jpg') }}" alt="">
                        <p>* Сильные царапины</p></button>
                </div>
            </div>
            <div class="cover_state">
                <div class="disabled-off disabled"></div>
                <p class="cover_state-question">Выберите состояние корпуса наиболее похож на ваш.</p>
                <div class="cover_state-option">
                    <button class="cover_state-option1"><img src="{{ asset('assets/img/calculator/cover_A.jpg') }}" alt=""><p>* Нет царапин</p></button>
                    <button class="cover_state-option2"><img src="{{ asset('assets/img/calculator/cover_B.jpg') }}" alt=""><p>* Едва заметные царапины</p></button>
                    <button class="cover_state-option3"><img src="{{ asset('assets/img/calculator/cover_C.jpg') }}" alt=""><p>* Достаточно заметные царапины</p></button>
                    <button class="cover_state-option4"><img src="{{ asset('assets/img/calculator/cover_D.jpg') }}" alt=""><p>* Сильные царапины</p></button>
                </div>
            </div>
        </div>
        <div class="right_block">
            <p class="sentence">Наше предложение</p>
            <div class="phone_cost">
                <!-- <p class="phone_cost-text">Вартість</p> -->
                <p class="phone_cost-change_cost">0</p>
            </div>
            <div class="get_offers">
                <div class="disabled-off-one disabled"></div>
                <button class="get_offers-button" id="btn-offer">Зарегистрировать заявку</button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('modals')
    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14" id="modal-request">
                <form action="{{ route('cabinet.buyback_request.add') }}" method="POST" id="form" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Оставить заявку</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-block">
                            @csrf
                            <input type="hidden" name="model_id" id="model_id">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Имя</label>
                                    <input type="text" class="form-control" name="name" value="" id="name" placeholder="Имя" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" value="" id="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Телефон</label>
                                    <input type="text" class="form-control phone-mask" name="phone" value="" id="phone" placeholder="Телефон">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="imei">IMEI</label>
                                    <input type="text" class="form-control" name="imei" value="" id="imei" placeholder="IMEI">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="packet">№ Сейф-пакета</label>
                                    <input type="text" class="form-control" name="packet" value="" id="packet" placeholder="№ Сейф-пакета">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="brand">Бренд</label>
                                    <input type="text" class="form-control" name="brand" value="" id="brand" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="model">Модель</label>
                                    <input type="text" class="form-control" name="model" value="" id="model" placeholder="" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cost">Стоимость (Грн)</label>
                                    <input type="text" class="form-control" name="cost" value="" id="cost" placeholder="" readonly>
                                </div>
                                @guest
                                    <div class="need-auth col-md-12 text-right" id="swap-to-login"><a href="">Что бы продолжить, Вам нужно авторизоваться</a></div>
                                @endguest
                            </div>
                        </div>
                        <div class="success-block text-center hide">
                            <h2></h2>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-sm btn-dark float-right" @guest disabled @endguest id="feed_send">Отправить</button>
                    </div>
                </form>
            </div>

            <div class="modal-content tx-14 hide" id="modal-auth">
                <form action="{{ route('auth') }}" id="authForm" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Авторизация</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger error-message hide" role="alert"></div>
                        <div class="form-block">
                            @csrf
                            <div class="form-group">
                                <label for="auth-email">Email</label>
                                <input type="email" class="form-control" name="email" value="" id="auth-email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="name">Пароль</label>
                                <input type="password" class="form-control" name="password" value="" id="password" placeholder="Пароль">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-sm btn-dark float-right" id="send_login">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/calculator.js') }}"></script>
    <script>
        $(function(){
            'use strict'

            $(document).on('click', '#btn-offer', function (e) {
                e.preventDefault();

                $('#modal-data').modal('toggle');
            })

            $('#modal-data').on('click', '#swap-to-login', function (e) {
                e.preventDefault();
                $('#modal-request').hide();
                $('#modal-auth').show();
            })


            $('#authForm').on('click', '#send_login', function (e) {
                e.preventDefault();

                let _form = $('#authForm');

                $.ajax({
                    type: _form.attr('method'),
                    url: _form.attr('action'),
                    data: _form.serializeArray(),
                }).done(function(response) {
                    if (response.status == 1) {
                        $('#modal-auth').hide();
                        $('#swap-to-login').hide();
                        $('#feed_send').removeAttr('disabled');
                        $('#modal-request').show();
                    } else if (response.status == 0) {
                        $('.error-message').removeClass('hide').text(response.message)
                    }
                });
            });
        });
    </script>
@endpush
