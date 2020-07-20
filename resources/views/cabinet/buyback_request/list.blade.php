@extends('cabinet.layouts.main')

@section('title', 'Заявки на выкуп')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Заявки на выкуп</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0 justify-content-end">
                    <a href="" class="btn btn-sm btn-dark" id="load-stock" data-toggle="modal">Долг склада</a>
                    <a href="{{ route('cabinet.nova_poshta.list') }}" class="btn btn-sm btn-dark">Список ТТН</a>
                    <a href="{{ route('cabinet.buyback_request.export', [request()->getQueryString()]) }}" class="btn btn-sm btn-dark" id="show-filter">Экспорт в Excel</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row mg-b-15" id="filters">
            <div class="col-lg-12 col-xl-12">
                <form action="{{ route('cabinet.buyback_request.list') }}" method="GET" novalidate>
                    <div class="form-row">
                        @if(Auth::user()->isAdmin())
                            <div class="form-group col-md-2">
                                <select class="custom-select network-filter" name="network_id">
                                    <option value=""></option>
                                    @foreach($networks as $network)
                                        <option value="{{ $network->id }}" @if(request('network_id') == $network->id) selected @endif>{{ $network->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if(Auth::user()->isAdmin() || Auth::user()->isNetwork())
                            <div class="form-group col-md-2">
                                <select class="custom-select shop-filter" name="shop_id">
                                    <option value=""></option>
                                    @foreach($shops as $shop)
                                        <option value="{{ $shop->id }}" @if(request('shop_id') == $shop->id) selected @endif>{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if(Auth::user()->isShop())
                            <div class="form-group col-md-3">
                                <select class="custom-select user-filter" name="user_id">
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->fullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group col-md-2">
                            <input type="text" class="form-control filter_date" name="date_from" value="{{ request('date_from') ?: null }}" placeholder="Дата с" autocomplete="off">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control filter_date" name="date_to" value="{{ request('date_to') ?: null }}" placeholder="Дата по" autocomplete="off">
                        </div>

                        <div class="form-group col-md-2">
                            <select class="custom-select status-filter" name="status_id">
                                <option value=""></option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @if(request('status_id') == $status->id) selected @endif>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-dark">Применить</button>
                                <a href="{{ route('cabinet.buyback_request.list') }}" class="btn btn-danger">Сбросить</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif

                @if(count($buyRequests))
                    <div class="table-responsive">
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
                                <th scope="col">Бонус</th>
                                <th scope="col">Дата</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($buyRequests as $buyRequest)
                                <tr data-id="{{ $buyRequest->id }}" class="@if($buyRequest->is_debt) debt @endif">
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
                                    <td class="td-bonus">{{ $buyRequest->bonus }} <span>@if($buyRequest->is_paid)<i class="far fa-check-square bg-success"></i>@endif</span></td>
                                    <td><small>{{ \Carbon\Carbon::parse($buyRequest->created_at)->format('d.m.Y H:i') }}</small></td>
                                    <td>
                                        @if(Auth::user()->isAdmin() || (Auth::user()->isShop() && Auth::id() === $buyRequest->user_id))

                                            <a href="#" data-toggle="tooltip" title="Редактировать" class="btn btn-xxs btn-success btn-icon editModal">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            @if($buyRequest->user->network && $buyRequest->actForm)
                                                <a href="{{ route('cabinet.buyback_request.pdf', ['id' => $buyRequest->id]) }}" data-toggle="tooltip" title="Акт PDF" class="btn btn-xxs btn-warning btn-icon">
                                                    <i class="far fa-file-pdf"></i>
                                                </a>
                                            @endif
                                        @endif

                                        @if(Auth::user()->isAdmin())
                                            @if (\App\Models\Status::STATUS_TAKE === $buyRequest->status_id && !$buyRequest->is_paid && $buyRequest->is_accrued)
                                                @php
                                                    $display = ''
                                                @endphp
                                            @else
                                                @php
                                                    $display = 'd-none'
                                                @endphp
                                            @endif
                                            <a href="#" data-toggle="tooltip" title="Выплатить бонус" class="btn btn-xxs btn-primary btn-icon btnPaid {{ $display ?? '' }}">
                                                <i class="fas fa-hryvnia"></i>
                                            </a>

                                            @if(!$buyRequest->is_debt)
                                                <a href="#" data-toggle="tooltip" title="Списать долг склада" class="btn btnDebt btn-xxs btn-info btn-icon">
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                </a>
                                            @endif

                                            @if($buyRequest->status_id === \App\Models\Status::STATUS_NEW)
                                                <a href="#" data-toggle="tooltip" title="Удалить" class="btn btnDelete btn-xxs btn-danger btn-icon">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> Нет заявок
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('modals')

    <div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.buyback_request.edit') }}" id="formEdit" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Редактировать заявку на выкуп</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="name">Имя продавца</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Имя продавца" autocomplete="off" readonly>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="phone">Телефон</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Телефон" autocomplete="off" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">E-mail</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="E-mail" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="imei">IMEI-номер</label>
                                <input type="text" class="form-control" name="imei" id="imei" placeholder="IMEI-номер" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="packet">Номер сейф-пакета</label>
                                <input type="text" class="form-control" name="packet" id="packet" placeholder="Номер сейф-пакета" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Статус</label>
                            <select class="custom-select" id="status" name="status_id">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @if(!in_array($status->id, $allowStatuses)) disabled @endif>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-sm btn-dark float-right"><i class="far fa-save"></i> Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-stock" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">

    </div>
@endpush

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

            $('.user-filter').select2({
                placeholder: 'Пользователь',
                searchInputPlaceholder: 'Поиск пользователя',
                allowClear: true,
            });

            $('.status-filter').select2({
                minimumResultsForSearch: -1,
                placeholder: 'Статус',
                allowClear: true,
            });

            @if(Auth::user()->isAdmin())
                deleteObject('.table', '.btnDelete', "{{ route('cabinet.buyback_request.delete') }}");

                $('table').on('click', '.btnDebt', function (e) {
                    e.preventDefault();

                    let _this = $(this),
                        id = _this.parent().parent('tr').data('id');

                    $.ajax({
                        url: "{{ route('cabinet.buyback_request.debt') }}",
                        type: "POST",
                        data: { id: id },
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                _this.parent().parent('tr').addClass('debt')
                                _this.addClass('d-none');
                                _this.css('pointer-events', 'none');
                                $.notify(response.message, response.type);
                            } else {
                                $.notify(response.message, response.type);
                            }
                        }
                    });
                });

                $('table').on('click', '.btnPaid', function (e) {
                    e.preventDefault();

                    let _this = $(this),
                        id = _this.parent().parent('tr').data('id');

                    $.ajax({
                        url: "{{ route('cabinet.buyback_request.paid') }}",
                        type: "POST",
                        data: { id: id },
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                _this.parent().parent('tr').find('td.td-bonus > span').html('<i class="far fa-check-square bg-success"></i>');
                                _this.addClass('d-none');
                                _this.css('pointer-events', 'none');
                                $.notify(response.message, response.type);
                            } else {
                                $.notify(response.message, response.type);
                            }
                        }
                    });
                });
            @endif

            $('.editModal').click(function (e) {
                e.preventDefault();

                let modalNetwork = $('#edit-data'),
                    _parent = $(this).parent().parent('tr'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.ajax_date') }}",
                    type: "POST",
                    data: { action: 'get_buyback_request', id: id },
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            modalNetwork.modal('toggle');
                            modalNetwork.find('input[name=id]').val(response.data.id);
                            modalNetwork.find('input[name=name]').val(response.data.user.name+ ' ' +response.data.user.surname+' '+response.data.user.patronymic);
                            modalNetwork.find('input[name=email]').val(response.data.user.email);
                            modalNetwork.find('input[name=phone]').val(response.data.user.phone);
                            modalNetwork.find('input[name=imei]').val(response.data.imei);
                            modalNetwork.find('input[name=packet]').val(response.data.packet);
                            modalNetwork.find('select option').attr('selected', false);
                            modalNetwork.find('select option[value='+response.data.status_id+']').attr('selected', 'selected');
                        } else {
                            $.notify('Error get network object', 'error');
                        }
                    }
                });
            });

            $('form#formEdit').on('submit', function (e) {
                e.preventDefault();

                const _this = $(this),
                    id = _this.find('input[name=id]').val(),
                    data = $(this).serializeArray();

                $.ajax({
                    url: _this.attr('action'),
                    type: "POST",
                    data: data,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            const tr = $('.table').find('tr[data-id='+id+']');
                            tr.find('td.td-name').text(response.data.name);
                            tr.find('td.td-imei').text(response.data.imei);
                            tr.find('td.td-packet').text(response.data.packet);
                            tr.find('td.td-cost').text(response.data.cost);
                            tr.find('td.td-status').text(response.data.status.name);

                            if (response.btn_pay === 1) {
                                tr.find('.btnPaid').removeClass('d-none');
                            }

                            $.notify(response.message, response.type);
                            $('#edit-data').modal('toggle');
                        }
                    }
                });
            })

            $('#load-stock').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('cabinet.buyback_request.load_stock') }}',
                    type: "POST",
                    data: {},
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#modal-stock').html(response)
                        $('#modal-stock').modal('show');
                    }
                });
            })

        });
    </script>
@endpush

