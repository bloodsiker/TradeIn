@extends('layouts.app')

@section('title', 'Калькулятор оценки стоимости устройства')

@section('content')

    @include('cabinet.blocks.calculator')

@endsection

@push('modals')
    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14" id="modal-request">
                <form action="{{ route('cabinet.buyback_request.add') }}" method="POST" id="form" novalidate>
                    <div id="form-step-1">
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
                                <div class="form-group">
                                    <label for="imei">IMEI</label>
                                    <input type="text" class="form-control" name="imei" value="" id="imei" placeholder="IMEI">
                                </div>

                                <div class="form-group">
                                    <label for="packet">№ Сейф-пакета</label>
                                    <input type="text" class="form-control" name="packet" value="" id="packet" placeholder="№ Сейф-пакета">
                                </div>
                                <div class="form-group">
                                    <label for="brand">Бренд</label>
                                    <input type="text" class="form-control" name="brand" value="" id="brand" placeholder="" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="model">Модель</label>
                                    <input type="text" class="form-control" name="model" value="" id="model" placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="cost">Стоимость (Грн)</label>
                                    <input type="text" class="form-control" name="cost" value="" id="cost" placeholder="" readonly>
                                </div>
                                @guest
                                    <div class="need-auth col-md-12 text-right" id="swap-to-login"><a href="">Что бы продолжить, Вам нужно авторизоваться</a></div>
                                @endguest
                            </div>
                            <div class="success-block text-center hide">
                                <h2></h2>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-sm btn-dark float-right" @guest disabled @endguest id="next_step">Дальше</button>
                        </div>
                    </div>

                    <div id="form-step-2" class="hide">
                        <div class="modal-header">
                            <h6 class="modal-title">Клиент</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-block">
                                <div class="form-group">
                                    <label for="fio">ФИО</label>
                                    <input type="text" class="form-control" name="fio" value="" id="fio" placeholder="ФИО">
                                </div>

                                <div class="form-group">
                                    <label for="address">Адрес</label>
                                    <input type="text" class="form-control" name="address" value="" id="address" placeholder="Адрес">
                                </div>
                                <div class="form-group">
                                    <label for="type_document">Тип документа</label>
                                    <select class="custom-select" id="type_document" name="type_document">
                                        <option value="Паспорт">Паспорт</option>
                                        <option value="Водительское удостоверение">Водительское удостоверение</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="serial_number">Серия номер документа</label>
                                    <input type="text" class="form-control" name="serial_number" value="" id="serial_number" placeholder="Серия номер документа">
                                </div>
                                <div class="form-group">
                                    <label for="issued_by">Кем и когда выдан</label>
                                    <input type="text" class="form-control" name="issued_by" value="" id="issued_by" placeholder="Кем и когда выдан">
                                </div>
                            </div>
                            <div class="success-block text-center hide">
                                <h2></h2>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary tx-13" id="back_step">Назад</button>
                            <button type="submit" class="btn btn-sm btn-dark float-right" @guest disabled @endguest id="feed_send">Отправить</button>
                        </div>
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
                        $('#next_step').removeAttr('disabled');
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
