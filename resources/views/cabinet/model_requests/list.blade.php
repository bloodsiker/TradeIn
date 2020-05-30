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
                    @if(Auth::user()->isShop())
                        <a href="#modal-data" class="btn btn-sm btn-dark btn-block" data-toggle="modal">Создать</a>
                    @endif
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
                        <th scope="col">Пользователь</th>
                        <th scope="col">Торговая сеть</th>
                        <th scope="col">Магазин</th>
                        <th scope="col">Бренд</th>
                        <th scope="col">Модель</th>
                        <th scope="col">Статус</th>
                        @if(Auth::user()->isAdmin())
                            <th scope="col" width="80px"></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $request)
                        <tr data-id="{{ $request->id }}">
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->user->fullName() }}</td>
                            <td>{{ $request->user->network ? $request->user->network->name : null }}</td>
                            <td>{{ $request->user->shop ? $request->user->shop->name : null }}</td>
                            <td class="td-brand">{{ $request->brand }}</td>
                            <td class="td-model">{{ $request->model }}</td>
                            <td class="td-is-done">
                                <span class="badge badge-{{ $request->attributeStatus('color') }}">{{ $request->attributeStatus('text') }}</span>
                            </td>
                            @if(Auth::user()->isAdmin())
                                <td>
                                    <a href="#" data-toggle="tooltip" title="Редактировать" class="btn btn-xxs btn-success btn-icon editModal">
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
@endsection

@push('modals')
    @if(Auth::user()->isShop())
        <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModalAdd" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content tx-14">
                    <form action="{{ route('cabinet.model_request.add') }}" method="POST" novalidate>
                        <div class="modal-header">
                            <h6 class="modal-title" id="titleModalAdd">Создать заявку на добавление смартфона</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="brand">Производитель<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="brand" id="brand" placeholder="Название" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="model">Модель<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="model" id="model" placeholder="Название" autocomplete="off" required>
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
    @endif

    @if(Auth::user()->isAdmin())
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="titleModalEdit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content tx-14">
                    <form action="{{ route('cabinet.model_request.edit') }}" id="formEdit" method="POST" novalidate>
                        <div class="modal-header">
                            <h6 class="modal-title" id="titleModalEdit">Редактировать заявку</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="id" value="">
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
                                    <option value="0">Не выполнена</option>
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
    @endif
@endpush

@push('scripts')
    @if(Auth::user()->isAdmin())
        <script>
            $(function(){
                'use strict'

                deleteObject('.table', '.btnDelete', "{{ route('cabinet.model_request.delete') }}");

                $('.editModal').click(function (e) {
                    e.preventDefault();

                    let modalNetwork = $('#modal-edit'),
                        _parent = $(this).parent().parent('tr'),
                        id = _parent.data('id');

                    $.ajax({
                        url: "{{ route('cabinet.ajax_date') }}",
                        type: "POST",
                        data: { action: 'get_model_request', id: id },
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                modalNetwork.modal('toggle');
                                modalNetwork.find('input[name=id]').val(response.data.id);
                                modalNetwork.find('input[name=brand]').val(response.data.brand);
                                modalNetwork.find('input[name=model]').val(response.data.model);
                                modalNetwork.find('select option').attr('selected', false);
                                modalNetwork.find('select option[value='+response.data.is_done+']').attr('selected', 'selected');
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
                                tr.find('td.td-brand').text(response.data.brand);
                                tr.find('td.td-model').text(response.data.model);
                                tr.find('td.td-is-done > .badge').removeClass('badge-success badge-danger').addClass('badge-'+response.data.status_color).text(response.data.status_text);

                                $.notify(response.message, response.type);
                                $('#modal-edit').modal('toggle');
                            }
                        }
                    });
                })
            });
        </script>
    @endif
@endpush
