@extends('cabinet.layouts.main')

@section('title', 'Торговые сети')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Торговые сети</h4>
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
                <div class="table-responsive">
                    <table class="table table-sm table-white table-hover table-bordered ">
                        <thead>
                        <tr>
                            <th scope="col" width="40px">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col" width="125px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($networks as $network)
                            <tr data-id="{{ $network->id }}">
                                <td>{{ $network->id }}</td>
                                <td class="td-name">{{ $network->name }}</td>
                                <td>
                                    <a href="{{ route('cabinet.network.users', ['id' => $network->id]) }}" data-toggle="tooltip" title="Сотрудники сети" class="btn btn-xxs btn-info btn-icon">
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

    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.network.add') }}" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Создать торговую сеть</h6>
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
                <form action="{{ route('cabinet.network.edit') }}" id="formEdit" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Редактировать торговую сеть</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit-name">Название<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="edit-name" placeholder="Название" autocomplete="off" required>
                            <input type="hidden" name="id" value="">
                        </div>

{{--                        <div class="divider-text mt-4 mb-4">Данные для акта приема-передачи</div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="paragraph_1">Доверитель</label>--}}
{{--                            <textarea name="paragraph_1" class="form-control" id="paragraph_1" cols="30" rows="3"></textarea>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="paragraph_2">Поверенный</label>--}}
{{--                            <textarea name="paragraph_2" class="form-control" id="paragraph_2" cols="30" rows="3"></textarea>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="tov">ТОВ</label>--}}
{{--                            <input type="text" class="form-control" name="tov" id="tov" placeholder="ТОВ" autocomplete="off">--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="shop">Сеть магазинов</label>--}}
{{--                            <input type="text" class="form-control" name="shop" id="shop" placeholder="Сеть магазинов" autocomplete="off">--}}
{{--                        </div>--}}
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

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.network.delete') }}");

            $('.table').on('click', '.editModal',function (e) {
                e.preventDefault();

                let modalNetwork = $('#edit-data'),
                    _parent = $(this).parent().parent('tr'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.ajax_date') }}",
                    type: "POST",
                    data: { action: 'get_network', id: id },
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            modalNetwork.modal('toggle');
                            modalNetwork.find('input[name=name]').val(response.data.name);
                            modalNetwork.find('input[name=id]').val(response.data.id);
                            // modalNetwork.find('textarea[name=paragraph_1]').val(response.data.paragraph_1);
                            // modalNetwork.find('textarea[name=paragraph_2]').val(response.data.paragraph_2);
                            // modalNetwork.find('input[name=tov]').val(response.data.tov);
                            // modalNetwork.find('input[name=shop]').val(response.data.shop);
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
                            $('.table').find('tr[data-id='+id+']').find('td.td-name').text(response.data.name);

                            $.notify(response.message, response.type);
                            $('#edit-data').modal('toggle');
                        }
                    }
                });
            })
        });
    </script>
@endpush
