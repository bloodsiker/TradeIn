@extends('cabinet.layouts.main')

@section('title', 'Калькулятор оценки стоимости устройства')

@push('styles')
    <link href="{{ asset('assets/css/calculator.css') }}" rel="stylesheet">
@endpush

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

    @include('cabinet.blocks.calculator')

@endsection

@push('modals')
    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
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
                        </div>
                        <div class="success-block text-center hide">
                            <h2></h2>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-sm btn-dark float-right" id="feed_send">Отправить</button>
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

            // $('form#formEdit').on('submit', function (e) {
            //     e.preventDefault();
            //
            //     const _this = $(this),
            //         url = _this.attr('action'),
            //         id = _this.find('input[name=id]').val(),
            //         data = $(this).serializeArray();
            //
            //     $.ajax({
            //         url: url,
            //         type: "POST",
            //         data: data,
            //         cache: false,
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function (response) {
            //
            //         }
            //     });
            // })

        });
    </script>
@endpush
