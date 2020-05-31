@extends('cabinet.layouts.main')

@section('title', 'Список пользователи')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Пользователи</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ route('cabinet.user.add') }}" class="btn btn-sm btn-dark btn-block">Создать</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row mg-b-15">
            <div class="col-lg-12 col-xl-12">
                <form action="{{ route('cabinet.user.list') }}" method="GET" novalidate>
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

                        <div class="form-group col-md-2">
                            <select class="custom-select shop-filter" name="shop_id">
                                <option value=""></option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}" @if(request('shop_id') == $shop->id) selected @endif>{{ $shop->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <select class="custom-select role-filter" name="role_id">
                                <option value=""></option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @if(request('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-block btn-dark">Применить</button>
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
                    <table class="table table-sm table-dark table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Торговая сеть</th>
                            <th scope="col">Магазин</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Роль</th>
                            <th scope="col">Статус</th>
                            <th scope="col" width="80px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->fullName() }}</td>
                                <td>{{ $user->getNetwork() }}</td>
                                <td>{{ $user->getShop() }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td><span class="badge badge-pill badge-{{ $user->attributeStatus('color') }}">{{ $user->attributeStatus('text') }}</span></td>
                                <td>
                                    <a href="{{ route('cabinet.user.edit', ['id' => $user->id]) }}" data-toggle="tooltip" title="Редактировать" class="btn btn-xxs btn-success btn-icon">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" title="Удалить" class="btn btnDelete btn-xxs btn-danger btn-icon">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
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

            $('.role-filter').select2({
                minimumResultsForSearch: -1,
                placeholder: 'Роль',
                allowClear: true,
            });

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.user.delete') }}");
        });
    </script>
@endpush
