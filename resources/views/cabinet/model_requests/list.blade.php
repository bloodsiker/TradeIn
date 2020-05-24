@extends('cabinet.layouts.main')

@section('title', 'Заявки на добавление смартфона')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Заявки на добавление смартфона</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">

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
                <table class="table table-dark table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" width="40px">ID</th>
                        <th scope="col">Пользователь</th>
                        <th scope="col">Торговая сеть</th>
                        <th scope="col">Магазин</th>
                        <th scope="col">Бренд</th>
                        <th scope="col">Модель</th>
                        <th scope="col">Статус</th>
                        <th scope="col" width="80px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $request)
                        <tr data-id="{{ $request->id }}">
                            <td data-id="{{ $request->id }}">{{ $request->id }}</td>
                            <td data-name="{{ $request->user->fullName() }}">{{ $request->user->fullName() }}</td>
                            <td>{{ $request->user->network ? $request->user->network->name : null }}</td>
                            <td>{{ $request->user->shop ? $request->user->shop->name : null }}</td>
                            <td data-brand="{{ $request->brand }}">{{ $request->brand }}</td>
                            <td data-model="{{ $request->model }}">{{ $request->model }}</td>
                            <td data-is-done="{{ $request->is_done }}">
                                <span class="badge badge-{{ $request->attributeStatus('color') }}">{{ $request->attributeStatus('text') }}</span>
                            </td>
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

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="titleModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.model_request.edit') }}" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModalEdit">Редактировать заявку</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Имя" autocomplete="off" disabled>
                            <input type="hidden" name="id" value="">
                        </div>
                        <div class="form-group">
                            <label for="edit-brand">Производитель</label>
                            <input type="text" class="form-control" name="brand" id="edit-brand" placeholder="Название" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-model">Модель</label>
                            <input type="text" class="form-control" name="model" id="edit-model" placeholder="Название" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Статус</label>
                            <select class="custom-select" id="status" name="is_done">
                                <option value="0">Не ныполнена</option>
                                <option value="1">Выполнена</option>
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
@endpush

@push('scripts')
    <script>
        $(function(){
            'use strict'

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.model_request.delete') }}");

            $('.editModal').click(function (e) {
                e.preventDefault();

                let modalNetwork = $('#modal-edit'),
                    _parent = $(this).parent().parent('tr'),
                    name = _parent.find('td[data-name]').data('name'),
                    brand = _parent.find('td[data-brand]').data('brand'),
                    model = _parent.find('td[data-model]').data('model'),
                    is_done = _parent.find('td[data-is-done]').data('is-done'),
                    id = _parent.find('td[data-id]').data('id');

                modalNetwork.modal('toggle');
                modalNetwork.find('input[name=name]').val(name);
                modalNetwork.find('input[name=id]').val(id);
                modalNetwork.find('input[name=brand]').val(brand);
                modalNetwork.find('input[name=model]').val(model);
                modalNetwork.find('select option').attr('selected', false);
                modalNetwork.find('select option[value='+is_done+']').attr('selected', 'selected');
            });

        });
    </script>
@endpush
