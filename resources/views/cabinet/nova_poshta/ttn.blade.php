@extends('cabinet.layouts.main')

@section('title', 'Создать номер накладной Новой почты')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">ТТН {{ $ttnObject->ttn }}</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0 justify-content-end">
                    <a href="{{ route('cabinet.nova_poshta.list') }}" class="btn btn-sm btn-dark">
                        <i class="fa fa-undo"></i>
                        Назад
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                @if(Auth::user()->nova_poshta_key)
                    <div class="table-responsive">
                        <table class="table table-sm table-white table-hover table-bordered">
                            <tbody>

                                <tr>
                                    <td width="30%">Пользователь</td>
                                    <td>
                                        {{ $ttnObject->user->fullName() }}
                                        <br>
                                        <small><b>Тогровая сеть:</b> {{ $ttnObject->user->network ? $ttnObject->user->network->name : null }}</small>
                                        <br>
                                        <small><b>Магазин:</b> {{ $ttnObject->user->shop ? $ttnObject->user->shop->name : null }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Номер экспресс-накладной</td>
                                    <td>{{ $ttnObject->ttn }}</td>
                                </tr>
                                <tr>
                                    <td>Стоимость доставки</td>
                                    <td>{{ $ttnObject->cost }} грн</td>
                                </tr>
                                <tr>
                                    <td>Прогноз даты доставки</td>
                                    <td>{{ \Carbon\Carbon::parse($ttnObject->date_delivery)->format('d.m.Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Устройства в поставке</td>
                                    <td>
                                        <ul id="list_device">
                                            <li class="d-none"></li>
                                            @foreach($ttnObject->requests as $singleRequest)
                                                <li>{{ $singleRequest->model->technic->name }} / {{ $singleRequest->model->brand->name }} / {{ $singleRequest->model->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <div class="text-center">
                            <h4>Список заявок на выкуп</h4>
                        </div>
                        <table class="table table-sm table-white table-hover table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" width="40px">ID</th>
                                <th scope="col">Пользователь</th>
                                <th scope="col">Устройство</th>
                                <th scope="col">IMEI</th>
                                <th scope="col">Номер сейф-пакета</th>
                                <th scope="col">Стоимость (грн)</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Дата</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($buyRequests as $buyRequest)
                                <tr data-id="{{ $buyRequest->id }}" data-ttn="{{ $ttnObject->id }}">
                                    <td>{{ $buyRequest->id }}</td>
                                    <td>{{ $buyRequest->user->fullName() }}</td>
                                    <td>
                                        @if( $buyRequest->model)
                                            <small><b>Тип:</b> {{ $buyRequest->model->technic ? $buyRequest->model->technic->name : null }}</small>
                                            <br>
                                            <small><b>Производитель:</b> {{ $buyRequest->model->brand->name }}</small>
                                            <br>
                                            <small><b>Модель:</b> {{ $buyRequest->model->name }}</small>
                                        @endif
                                    </td>
                                    <td class="td-imei">{{ $buyRequest->imei }}</td>
                                    <td class="td-packet">{{ $buyRequest->packet }}</td>
                                    <td class="td-cost">{{ $buyRequest->cost }}</td>
                                    <td class="td-status">{{ $buyRequest->status->name }}</td>
                                    <td><small>{{ \Carbon\Carbon::parse($buyRequest->created_at)->format('d.m.Y H:i') }}</small></td>
                                    <td>
                                        <a href="#" class="btn btn-xxs btn-dark btn-icon addToTtn">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> Что бы создавать онлайн экспресс-накладные, добавьте в&nbsp;<a href="{{ route('cabinet.profile') }}">профиле пользователя</a> &nbsp;API ключ Новой почты
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script>
        $(function(){
            'use strict'

            $('.addToTtn').click(function (e) {
                e.preventDefault();

                let _parent = $(this).parent().parent('tr'),
                    ttn = _parent.data('ttn'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.nova_poshta.add_to_ttn') }}",
                    type: "POST",
                    data: {ttn: ttn, id: id},
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            _parent.remove();
                            $('#list_device li').last().after('<li>'+ response.data +'</li>');
                            $.notify(response.message, response.type);
                        } else {
                            $.notify(response.message, response.type);
                        }
                    }
                });
            });
        });
    </script>
@endpush

