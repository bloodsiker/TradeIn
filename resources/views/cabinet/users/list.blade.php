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
                    @if(Auth::user()->isAdmin())
                        <a href="#modal-import" class="btn btn-sm btn-dark" data-toggle="modal">Импорт</a>
                        <a href="{{ route('cabinet.user.logs') }}" class="btn btn-sm btn-dark">Логи</a>
                        <a href="{{ route('cabinet.user.add') }}" class="btn btn-sm btn-dark">Создать</a>
                    @endif
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
                            <div class="form-group col-md-3">
                                <select class="custom-select network-filter" name="network_id">
                                    <option value=""></option>
                                    @foreach($networks as $network)
                                        <option value="{{ $network->id }}" @if(request('network_id') == $network->id) selected @endif>{{ $network->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group col-md-3">
                            <select class="custom-select shop-filter" name="shop_id">
                                <option value=""></option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}" @if(request('shop_id') == $shop->id) selected @endif>{{ $shop->fullName() }}</option>
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

                        <div class="form-group col-md-3">
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-dark">Применить</button>
                                <a href="{{ route('cabinet.user.list') }}" class="btn btn-danger">Сбросить</a>
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
                            <th scope="col">Имя</th>
                            <th scope="col">Торговая сеть</th>
                            <th scope="col">Магазин</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Роль</th>
                            <th scope="col">Статус</th>
                            @if(Auth::user()->isAdmin())
                                <th scope="col" width="90px"></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->fullName() }}</td>
                                <td><span class="badge badge-primary">{{ $user->getNetwork() }}</span></td>
                                <td>{{ $user->getShop() }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td><small>{{ $user->role->name }}</small></td>
                                <td><span class="badge badge-pill badge-{{ $user->attributeStatus('color') }}">{{ $user->attributeStatus('text') }}</span></td>
                                @if(Auth::user()->isAdmin())
                                    <td>
                                        <a href="{{ route('cabinet.user.edit', ['id' => $user->id]) }}" data-toggle="tooltip" title="Редактировать" class="btn btn-xxs btn-success btn-icon">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="#" data-toggle="tooltip" title="Удалить" class="btn btnDelete btn-xxs btn-danger btn-icon">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.user.import') }}" method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Иморт пользователей</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <a href="{{ asset('upload/users.xlsx') }}" class="link-color-gray" target="_blank">Шаблон для импорта</a>
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="file" onchange="processSelectedFiles(this)"
                                           aria-describedby="file" required>
                                    <label class="custom-file-label" id="file-name" for="avatar">Выберите файл</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-sm btn-dark float-right"><i class="far fa-file-excel"></i> Импортировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(function() {
            'use strict'

            @if(Auth::user()->isAdmin())
                $('.network-filter').select2({
                    placeholder: 'Торговая сеть',
                    searchInputPlaceholder: 'Поиск торговой сети',
                    allowClear: true,
                });
            @endif

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

        function processSelectedFiles(fileInput) {
            var files = fileInput.files[0];
            document.getElementById('file-name').innerText = files.name;
        }
    </script>
@endpush
