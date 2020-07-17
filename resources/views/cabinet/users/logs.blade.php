@extends('cabinet.layouts.main')

@section('title', 'Логи пользователей')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Логи пользователей</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ route('cabinet.user.list') }}" class="btn btn-sm btn-dark btn-block">
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

        <div class="row mg-b-15">
            <div class="col-lg-12 col-xl-12">
                <form action="{{ route('cabinet.user.logs') }}" method="GET" novalidate>
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
                                    <option value="{{ $shop->id }}" @if(request('shop_id') == $shop->id) selected @endif>{{ $shop->fullName() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <select class="custom-select user-filter" name="user_id">
                                <option value=""></option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->fullName() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-dark">Применить</button>
                                <a href="{{ route('cabinet.user.logs') }}" class="btn btn-danger">Сбросить</a>
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
                <div class="table-responsive">
                    <table class="table table-sm table-white table-hover table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col">Сеть/Магазин</th>
                            <th scope="col">Действие</th>
                            <th scope="col">IP адрес</th>
                            <th scope="col">Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <th>{{ $log->id }}</th>
                                <td>{{ $log->user->fullName() }}</td>
                                <td>
                                    <small><b>Сеть:</b> {{ $log->user->network ? $log->user->network->name : null }}</small><br>
                                    <small><b>Магазин:</b> {{ $log->user->shop ? $log->user->shop->name : null }}</small>
                                </td>
                                <td>{{ $log->action }}</td>
                                <td><small>{{ $log->ip_address }}</small></td>
                                <td><small>{{ $log->created_at->format('d.m.Y H:i') }}</small></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="container-paginate">
                    {{ $logs->appends(request()->all())->links('cabinet.blocks._pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            'use strict'

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

        });
    </script>
@endpush

