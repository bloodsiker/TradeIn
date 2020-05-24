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
                        <th scope="col">Название</th>
                        <th scope="col" width="110px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($networks as $network)
                        <tr data-id="{{ $network->id }}">
                            <td data-id="{{ $network->id }}">{{ $network->id }}</td>
                            <td data-name="{{ $network->name }}">{{ $network->name }}</td>
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
@endsection

@push('modals')

    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.network.add') }}" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Создать торговую сеть</h6>
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
                <form action="{{ route('cabinet.network.edit') }}" id="formEdit" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Редактировать торговую сеть</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit-name">Название</label>
                            <input type="text" class="form-control" name="name" id="edit-name" placeholder="Название" autocomplete="off" required>
                            <input type="hidden" name="id" value="">
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

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.network.delete') }}");

            $('.table').on('click', '.editModal',function (e) {
                e.preventDefault();

                let modalNetwork = $('#edit-data'),
                    _parent = $(this).parent().parent('tr'),
                    name = _parent.find('td[data-name]').attr('data-name'),
                    id = _parent.find('td[data-id]').attr('data-id');

                modalNetwork.modal('toggle');
                modalNetwork.find('input[name=name]').val(name);
                modalNetwork.find('input[name=id]').val(id);
            });

            $('form#formEdit').on('submit', function (e) {
                e.preventDefault();

                const _this = $(this),
                    url = _this.attr('action'),
                    id = _this.find('input[name=id]').val(),
                    data = $(this).serializeArray();

                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            const tr = $('.table').find('tr[data-id='+id+']');

                            $.each(data, function(key, value) {
                                const td = tr.find('td[data-'+value.name+']');
                                if (td) {
                                    td.text(value.value).attr('data-'+value.name, value.value);
                                }
                            });

                            $.notify(response.message, response.type);
                            $('#edit-data').modal('toggle');
                        }
                    }
                });
            })

        });
    </script>
@endpush
