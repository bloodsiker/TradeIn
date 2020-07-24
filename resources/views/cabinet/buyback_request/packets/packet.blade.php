@extends('cabinet.layouts.main')

@section('title', 'Создать номер накладной Новой почты')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Пакет {{ $buyPacket->name }}</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0 justify-content-end">
                    <a href="{{ route('cabinet.buyback_request.packets') }}" class="btn btn-sm btn-dark">
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
                <div class="table-responsive">
                    <table class="table table-sm table-white table-hover table-bordered">
                        <tbody>
                            <tr>
                                <td>Содержимое пакета</td>
                                <td>
                                    <ul id="list_device">
                                        <li class="d-none"></li>
                                        @foreach($buyPacket->requests as $buyRequest)
                                            @include('cabinet.buyback_request.packets.packet_request_inline')
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    <h4>Список заявок на выкуп</h4>
                </div>

                <div class="row" id="filters">
                    <div class="col-lg-12 col-xl-12">
                        <form action="{{ route('cabinet.buyback_request.packet', ['id' => $buyPacket->id]) }}" method="GET" novalidate>
                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <select class="custom-select network-filter" name="network_id">
                                        <option value=""></option>
                                        @foreach($networks as $network)
                                            <option value="{{ $network->id }}" @if(request('network_id') == $network->id) selected @endif>{{ $network->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <select class="custom-select shop-filter" name="shop_id">
                                        <option value=""></option>
                                        @foreach($shops as $shop)
                                            <option value="{{ $shop->id }}" @if(request('shop_id') == $shop->id) selected @endif>{{ $shop->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control filter_date" name="date_from" value="{{ request('date_from') ?: null }}" placeholder="Дата с" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control filter_date" name="date_to" value="{{ request('date_to') ?: null }}" placeholder="Дата по" autocomplete="off">
                                </div>

                                <div class="form-group col-md-2">
                                    <div class="btn-group" role="group">
                                        <button type="submit" class="btn btn-dark">Применить</button>
                                        <a href="{{ route('cabinet.buyback_request.packet', ['id' => $buyPacket->id])  }}" class="btn btn-danger">Сбросить</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-white table-hover table-bordered tableTtnRequest">
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
                            @if(!$buyPacket->ttn)
                                <th scope="col"></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($buyRequests as $buyRequest)
                            @include('cabinet.buyback_request.packets.packet_request_row')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script>
        $(function(){
            'use strict'

            $('.filter_date').datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                language: "{{app()->getLocale()}}",
                isRTL: false,
                autoClose: true,
                format: "dd.mm.yyyy",
            });

            $('.network-filter').select2({
                placeholder: 'Торговая сеть',
                searchInputPlaceholder: 'Поиск торговой сети',
                allowClear: true,
            });

            $('.shop-filter').select2({
                placeholder: 'Магазин',
                searchInputPlaceholder: 'Поиск магазина',
                allowClear: true,
            });

            $('.tableTtnRequest').on('click', '.addToTtn', function (e) {
                e.preventDefault();

                let _parent = $(this).parent().parent('tr'),
                    packet = _parent.data('packet'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.buyback_request.packet.add_to_packet') }}",
                    type: "POST",
                    data: {action: 'addToPacket', packet: packet, id: id},
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        _parent.remove();
                        $('#list_device li').last().after(response);
                    }
                });
            });

            $('#list_device').on('click', '.remove-from-ttn', function (e) {
                let _parent = $(this).parent(),
                    packet = _parent.data('packet'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.buyback_request.packet.add_to_packet') }}",
                    type: "POST",
                    data: {action: 'removeFromTtn', packet: packet, id: id},
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

                        let tbody = $('.tableTtnRequest').find('tbody'),
                            tr = tbody.find('tr');

                        if (tr.length) {
                            tr.last().before(response);
                        } else {
                            tbody.html(response);
                        }
                        _parent.remove();
                    }
                });
            });
        });
    </script>
@endpush

