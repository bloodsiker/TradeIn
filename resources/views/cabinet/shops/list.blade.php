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
                    <a href="#modal-data" class="btn btn-sm btn-dark btn-block" data-toggle="modal">Создать</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif
                <table class="table table-sm table-dark table-striped table-bordered">
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
                            <td data-id="{{ $shop->id }}">{{ $shop->id }}</td>
                            <td data-name="{{ $shop->name }}">{{ $shop->name }}</td>
                            <td data-network-id="{{ $shop->network->id }}"><span class="badge badge-success">{{ $shop->network->name }}</span></td>
                            <td data-city="{{ $shop->city }}">{{ $shop->city }}</td>
                            <td data-address="{{ $shop->address }}">{{ $shop->address }}</td>
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
@endsection

@push('modals')

    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModalAdd" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.shop.add') }}" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModalAdd">Создать магазин</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Название" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="network">Торговая сеть</label>
                            <select class="custom-select" id="network" name="network_id">
                                @foreach($networks as $network)
                                    <option value="{{ $network->id }}">{{ $network->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-city">Город</label>
                            <input type="text" class="form-control" name="city" id="edit-city" placeholder="Название" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-address">Адрес</label>
                            <input type="text" class="form-control" name="address" id="edit-address" placeholder="Название" autocomplete="off" required>
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

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="titleModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.shop.edit') }}" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModalEdit">Редактировать магазин</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Название" autocomplete="off" required>
                            <input type="hidden" name="id" value="">
                        </div>
                        <div class="form-group">
                            <label for="select-network">Торговая сеть</label>
                            <select class="custom-select" id="select-network" name="network_id">
                                @foreach($networks as $network)
                                    <option value="{{ $network->id }}">{{ $network->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">Город</label>
                            <input type="text" class="form-control" name="city" id="city" placeholder="Название" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Название" autocomplete="off" required>
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
@endpush

@push('scripts')
    <script>
        $(function(){
            'use strict'

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.shop.delete') }}");

            $('.editModal').click(function (e) {
                e.preventDefault();

                let modalNetwork = $('#modal-edit'),
                    _parent = $(this).parent().parent('tr'),
                    name = _parent.find('td[data-name]').data('name'),
                    network_id = _parent.find('td[data-network-id]').data('network-id'),
                    city = _parent.find('td[data-city]').data('city'),
                    address = _parent.find('td[data-address]').data('address'),
                    id = _parent.find('td[data-id]').data('id');

                modalNetwork.modal('toggle');
                modalNetwork.find('input[name=name]').val(name);
                modalNetwork.find('input[name=id]').val(id);
                modalNetwork.find('select option').attr('selected', false);
                modalNetwork.find('select option[value='+network_id+']').attr('selected', 'selected');
                modalNetwork.find('input[name=city]').val(city);
                modalNetwork.find('input[name=address]').val(address);
            });

        });
    </script>
@endpush
