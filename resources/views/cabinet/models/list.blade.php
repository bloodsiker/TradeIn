@extends('cabinet.layouts.main')

@section('title', 'Модели')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Модели</h4>
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
                        <th scope="col">Бренд</th>
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
                            <td data-id="{{ $model->id }}">{{ $model->id }}</td>
                            <td data-name="{{ $model->name }}">{{ $model->name }}</td>
                            <td data-brand-id="{{ $model->brand->name }}"><span class="badge badge-success">{{ $model->brand->name }}</span></td>
                            <td data-price1="{{ $model->price_1 }}">{{ $model->price_1 }}</td>
                            <td data-price2="{{ $model->price_2 }}">{{ $model->price_2 }}</td>
                            <td data-price3="{{ $model->price_3 }}">{{ $model->price_3 }}</td>
                            <td data-price4="{{ $model->price_4 }}">{{ $model->price_4 }}</td>
                            <td data-price5="{{ $model->price_5 }}">{{ $model->price_5 }}</td>
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
                                <label for="price_1">Цена 1</label>
                                <input type="text" class="form-control" name="price_1" id="price_1" placeholder="Цена 1" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_2">Цена 2</label>
                                <input type="text" class="form-control" name="price_2" id="price_2" placeholder="Цена 2" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="price_3">Цена 3</label>
                                <input type="text" class="form-control" name="price_3" id="price_3" placeholder="Цена 3" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_4">Цена 4</label>
                                <input type="text" class="form-control" name="price_4" id="price_4" placeholder="Цена 4" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
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

    <div class="modal fade" id="edit-network" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.model.edit') }}" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Редактировать модель</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="">
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
                                <label for="price_1">Цена 1</label>
                                <input type="text" class="form-control" name="price_1" id="price_1" placeholder="Цена 1" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_2">Цена 2</label>
                                <input type="text" class="form-control" name="price_2" id="price_2" placeholder="Цена 2" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="price_3">Цена 3</label>
                                <input type="text" class="form-control" name="price_3" id="price_3" placeholder="Цена 3" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_4">Цена 4</label>
                                <input type="text" class="form-control" name="price_4" id="price_4" placeholder="Цена 4" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-row">
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

                let modalNetwork = $('#edit-network'),
                    _parent = $(this).parent().parent('tr'),
                    name = _parent.find('td[data-name]').data('name'),
                    brand_id = _parent.find('td[data-brand-id]').data('brand-id'),
                    price1 = _parent.find('td[data-price1]').data('price1'),
                    price2 = _parent.find('td[data-price2]').data('price2'),
                    price3 = _parent.find('td[data-price3]').data('price3'),
                    price4 = _parent.find('td[data-price4]').data('price4'),
                    price5 = _parent.find('td[data-price5]').data('price5'),
                    id = _parent.find('td[data-id]').data('id');

                modalNetwork.modal('toggle');
                modalNetwork.find('input[name=name]').val(name)
                modalNetwork.find('input[name=id]').val(id)
                modalNetwork.find('input[name=price_1]').val(price1)
                modalNetwork.find('input[name=price_2]').val(price2)
                modalNetwork.find('input[name=price_3]').val(price3)
                modalNetwork.find('input[name=price_4]').val(price4)
                modalNetwork.find('input[name=price_5]').val(price5)
                modalNetwork.find('select option').attr('selected', false)
                modalNetwork.find('select option[value='+brand_id+']').attr('selected', 'selected')
            });

        });
    </script>
@endpush
