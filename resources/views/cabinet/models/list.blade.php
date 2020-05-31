@extends('cabinet.layouts.main')

@section('title', 'Модели')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">База данных смартфонов @if($network) торговой сети {{ $network->name }} @endif</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="#modal-network" class="btn btn-sm btn-dark btn-block" data-toggle="modal">Создать</a>
                </div>
            </div>
        </div><!-- container -->
    </div><!-- content -->
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
            <div class="col-lg-10 col-xl-10">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif
                @if(count($models))
                    <div class="table-responsive">
                        <table class="table table-sm table-dark table-striped table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Название</th>
                                <th scope="col">Бренд</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Цена 1</th>
                                <th scope="col">Цена 2</th>
                                <th scope="col">Цена 3</th>
                                <th scope="col">Цена 4</th>
                                <th scope="col">Цена 5</th>
                                <th scope="col" width="80px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $model)
                                <tr data-id="{{ $model->id }}">
                                    <td class="td-name">{{ $model->name }}</td>
                                    <td class="td-brand"><span class="badge badge-success">{{ $model->brand->name }}</span></td>
                                    <td class="td-price">{{ $model->price }}</td>
                                    <td class="td-price1">{{ $model->price_1 }}</td>
                                    <td class="td-price2">{{ $model->price_2 }}</td>
                                    <td class="td-price3">{{ $model->price_3 }}</td>
                                    <td class="td-price4">{{ $model->price_4 }}</td>
                                    <td class="td-price5">{{ $model->price_5 }}</td>
                                    <td>
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
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> В торговой сети нет базы данных смартфонов
                    </div>
                @endif
            </div>

            <div class="col-sm-7 col-md-5 col-lg-2 col-xl-2 mg-t-40 mg-lg-t-0">
                <h6 class="tx-uppercase tx-semibold mg-b-10">Торговые сети</h6>

                <nav class="nav nav-classic tx-13">
                    @foreach($networks as $singlNetwork)
                        <a href="{{ route('cabinet.model.list', ['network_id' => $singlNetwork->id]) }}" class="nav-link vertical-border-list @if(Request::get('network_id') == $singlNetwork->id) active @endif">{{ $singlNetwork->name }}</a>
                    @endforeach
                </nav>
            </div><!-- col -->
        </div>
    </div>
@endsection

@push('modals')

    <div class="modal fade" id="modal-network" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.model.add') }}" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Добавить модель</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="network_id" value="{{ $network ? $network->id : null }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="brand">Бренд</label>
                                <select class="custom-select" id="brand" name="brand_id">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Модель</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Модель" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="price">Цена</label>
                                <input type="text" class="form-control" name="price" id="price" placeholder="Цена 1" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_1">Цена 1</label>
                                <input type="text" class="form-control" name="price_1" id="price_1" placeholder="Цена 1" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="price_2">Цена 2</label>
                                <input type="text" class="form-control" name="price_2" id="price_2" placeholder="Цена 2" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_3">Цена 3</label>
                                <input type="text" class="form-control" name="price_3" id="price_3" placeholder="Цена 3" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="price_4">Цена 4</label>
                                <input type="text" class="form-control" name="price_4" id="price_4" placeholder="Цена 4" autocomplete="off" required>
                            </div>
                            <div class="form-grou col-md-6">
                                <label for="price_5">Цена 5</label>
                                <input type="text" class="form-control" name="price_5" id="price_5" placeholder="Цена 5" autocomplete="off" required>
                            </div>
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

    <div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.model.edit') }}" id="formEdit" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Редактировать модель</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="network_id" value="">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="brand">Бренд</label>
                                <select class="custom-select" id="brand" name="brand_id">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Модель</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Модель" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="price">Цена</label>
                                <input type="text" class="form-control" name="price" id="price" placeholder="Цена 1" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_1">Цена 1</label>
                                <input type="text" class="form-control" name="price_1" id="price_1" placeholder="Цена 1" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="price_2">Цена 2</label>
                                <input type="text" class="form-control" name="price_2" id="price_2" placeholder="Цена 2" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_3">Цена 3</label>
                                <input type="text" class="form-control" name="price_3" id="price_3" placeholder="Цена 3" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="price_4">Цена 4</label>
                                <input type="text" class="form-control" name="price_4" id="price_4" placeholder="Цена 4" autocomplete="off" required>
                            </div>
                            <div class="form-grou col-md-6">
                                <label for="price_5">Цена 5</label>
                                <input type="text" class="form-control" name="price_5" id="price_5" placeholder="Цена 5" autocomplete="off" required>
                            </div>
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

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.model.delete') }}");

            $('.editModal').click(function (e) {
                e.preventDefault();

                let modalNetwork = $('#edit-data'),
                    _parent = $(this).parent().parent('tr'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.ajax_date') }}",
                    type: "POST",
                    data: { action: 'get_model', id: id },
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            modalNetwork.modal('toggle');
                            modalNetwork.find('input[name=name]').val(response.data.name);
                            modalNetwork.find('input[name=id]').val(response.data.id);
                            modalNetwork.find('input[name=network_id]').val(response.data.network_id);
                            modalNetwork.find('select option').attr('selected', false);
                            modalNetwork.find('select option[value='+response.data.brand_id+']').attr('selected', 'selected');
                            modalNetwork.find('input[name=price]').val(response.data.price);
                            modalNetwork.find('input[name=price_1]').val(response.data.price_1);
                            modalNetwork.find('input[name=price_2]').val(response.data.price_2);
                            modalNetwork.find('input[name=price_3]').val(response.data.price_3);
                            modalNetwork.find('input[name=price_4]').val(response.data.price_4);
                            modalNetwork.find('input[name=price_5]').val(response.data.price_5);
                        } else {
                            $.notify('Error get device model object', 'error');
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
                            tr.find('td.td-brand > .badge').text(response.data.brand.name);
                            tr.find('td.td-price').text(response.data.price);
                            tr.find('td.td-price1').text(response.data.price_1);
                            tr.find('td.td-price2').text(response.data.price_2);
                            tr.find('td.td-price3').text(response.data.price_3);
                            tr.find('td.td-price4').text(response.data.price_4);
                            tr.find('td.td-price5').text(response.data.price_5);

                            $.notify(response.message, response.type);
                            $('#edit-data').modal('toggle');
                        }
                    }
                });
            })
        });
    </script>
@endpush
