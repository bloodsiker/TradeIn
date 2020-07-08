@extends('cabinet.layouts.main')

@section('title', 'Список магазинов')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Магазины</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="#modal-import" class="btn btn-sm btn-dark" data-toggle="modal">Импорт</a>
                    <a href="#modal-data" class="btn btn-sm btn-dark" data-toggle="modal">Создать</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row mg-b-15">
            <div class="col-lg-12 col-xl-12">
                <form action="{{ route('cabinet.shop.list') }}" method="GET" novalidate>
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
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-dark">Применить</button>
                                <a href="{{ route('cabinet.shop.list') }}" class="btn btn-danger">Сбросить</a>
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
                            <th scope="col" width="40px">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col">Торговая сеть</th>
                            <th scope="col">Город</th>
                            <th scope="col">Адрес</th>
                            <th scope="col" width="110px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shops as $shop)
                            <tr data-id="{{ $shop->id }}">
                                <td>{{ $shop->id }}</td>
                                <td class="td-name">{{ $shop->name }}</td>
                                <td class="td-network"><span class="badge badge-success">{{ $shop->network->name }}</span></td>
                                <td class="td-city">{{ $shop->city }}</td>
                                <td class="td-address">{{ $shop->address }}</td>
                                <td>
                                    <a href="{{ route('cabinet.shop.users', ['id' => $shop->id]) }}" data-toggle="tooltip" title="Сотрудники магазина" class="btn btn-xxs btn-info btn-icon">
                                        <i class="fas fa-users"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" title="Редактировать" class="btn btn-xxs btn-success btn-icon editModal">
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

@push('modals')
    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModalAdd" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.shop.add') }}" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModalAdd">Создать магазин</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Название<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Название" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="network">Торговая сеть<span class="text-danger">*</span></label>
                            <select class="custom-select" id="network" name="network_id" required>
                                @foreach($networks as $network)
                                    <option value="{{ $network->id }}">{{ $network->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-city">Город</label>
                            <input type="text" class="form-control" name="city" id="edit-city" placeholder="Название" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="edit-address">Адрес</label>
                            <input type="text" class="form-control" name="address" id="edit-address" placeholder="Название" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-sm btn-dark float-right"><i class="far fa-save"></i> Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="titleModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.shop.edit') }}" id="formEdit" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModalEdit">Редактировать магазин</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Название<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Название" autocomplete="off" required>
                            <input type="hidden" name="id" value="">
                        </div>
                        <div class="form-group">
                            <label for="select-network">Торговая сеть<span class="text-danger">*</span></label>
                            <select class="custom-select" id="select-network" name="network_id" required>
                                @foreach($networks as $network)
                                    <option value="{{ $network->id }}">{{ $network->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">Город</label>
                            <input type="text" class="form-control" name="city" id="city" placeholder="Название" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Название" autocomplete="off">
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

    <div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.shop.import') }}" method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Иморт магазинов</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <a href="{{ asset('upload/shops.xlsx') }}" class="link-color-gray" target="_blank">Шаблон для импорта</a>
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="file" onchange="processSelectedFiles(this)"
                                           aria-describedby="file" required>
                                    <label class="custom-file-label" id="file-name" for="avatar">Выберете файт</label>
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
@endpush

@push('scripts')
    <script>
        $(function(){
            'use strict'

            $('.network-filter').select2({
                placeholder: 'Торговая сеть',
                searchInputPlaceholder: 'Поиск торговой сети',
                allowClear: true,
            });

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.shop.delete') }}");

            $('.editModal').click(function (e) {
                e.preventDefault();

                let modalNetwork = $('#edit-data'),
                    _parent = $(this).parent().parent('tr'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.ajax_date') }}",
                    type: "POST",
                    data: { action: 'get_shop', id: id },
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            modalNetwork.modal('toggle');
                            modalNetwork.find('input[name=name]').val(response.data.name);
                            modalNetwork.find('input[name=id]').val(response.data.id);
                            modalNetwork.find('select option').attr('selected', false);
                            modalNetwork.find('select option[value='+response.data.network_id+']').attr('selected', 'selected');
                            modalNetwork.find('input[name=city]').val(response.data.city);
                            modalNetwork.find('input[name=address]').val(response.data.address);
                        } else {
                            $.notify('Error get shop object', 'error');
                        }
                    }
                });
            });

            $('form#formEdit').on('submit', function (e) {
                e.preventDefault();

                const _this = $(this),
                    id = _this.find('input[name=id]').val();

                $.ajax({
                    url: _this.attr('action'),
                    type: "POST",
                    data: _this.serializeArray(),
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            const tr = $('.table').find('tr[data-id='+id+']');
                                tr.find('td.td-name').text(response.data.name);
                                tr.find('td.td-network > .badge').text(response.data.network.name);
                                tr.find('td.td-city').text(response.data.city);
                                tr.find('td.td-address').text(response.data.address);

                            $.notify(response.message, response.type);
                            $('#edit-data').modal('toggle');
                        }
                    }
                });
            })
        });

        function processSelectedFiles(fileInput) {
            var files = fileInput.files[0];
            document.getElementById('file-name').innerText = files.name;
        }
    </script>
@endpush
