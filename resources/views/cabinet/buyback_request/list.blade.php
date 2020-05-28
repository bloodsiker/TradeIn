@extends('cabinet.layouts.main')

@section('title', 'Заявки на выкуп')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Заявки на выкуп</h4>
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
                <table class="table table-sm table-dark table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" width="40px">ID</th>
                        <th scope="col">Пользователь</th>
                        <th scope="col">Продавец</th>
                        <th scope="col">Производитель</th>
                        <th scope="col">Модель</th>
                        <th scope="col">IMEI</th>
                        <th scope="col">Номер сейф-пакета</th>
                        <th scope="col">Стоимость (грн)</th>
                        <th scope="col">Статус</th>
                        <th scope="col" width="80px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($buyRequests as $buyRequest)
                        <tr data-id="{{ $buyRequest->id }}">
                            <td data-id="{{ $buyRequest->id }}">{{ $buyRequest->id }}</td>
                            <td>{{ $buyRequest->user->fullName()  }}</td>
                            <td>{{ $buyRequest->name  }}</td>
                            <td data-brand="">{{ $buyRequest->model->brand->name }}</td>
                            <td data-model="{{ $buyRequest->model->name }}">{{ $buyRequest->model->name }}</td>
                            <td data-emei="{{ $buyRequest->emei }}">{{ $buyRequest->emei }}</td>
                            <td data-packet="{{ $buyRequest->packet }}">{{ $buyRequest->packet }}</td>
                            <td data-status="{{ $buyRequest->cost }}">{{ $buyRequest->cost }}</td>
                            <td data-status="{{ $buyRequest->status->id }}">{{ $buyRequest->status->name }}</td>
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

    <div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.buyback_request.edit') }}" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Редактировать бонус</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="name">Имя продавца</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Имя продавца" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Телефон" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="E-mail" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="imei">IMEI-номер</label>
                            <input type="text" class="form-control" name="imei" id="imei" placeholder="IMEI-номер" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="packet">Номер сейф-пакета</label>
                            <input type="text" class="form-control" name="packet" id="packet" placeholder="Номер сейф-пакета" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Статус</label>
                            <select class="custom-select" id="status" name="status_id">
                                <option selected></option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
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

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.buyback_request.delete') }}");

            $('.editModal').click(function (e) {
                e.preventDefault();

                let modalNetwork = $('#edit-data'),
                    _parent = $(this).parent().parent('tr'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.ajax_date') }}",
                    type: "POST",
                    data: { action: 'get_buyback_request', id: id },
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            modalNetwork.modal('toggle');
                            modalNetwork.find('input[name=id]').val(response.data.id);
                            modalNetwork.find('input[name=name]').val(response.data.user.name+ ' ' +response.data.user.surname+' '+response.data.user.patronymic);
                            modalNetwork.find('input[name=email]').val(response.data.email);
                            modalNetwork.find('input[name=phone]').val(response.data.phone);
                            modalNetwork.find('input[name=imei]').val(response.data.imei);
                            modalNetwork.find('input[name=packet]').val(response.data.packet);
                            modalNetwork.find('select option').attr('selected', false);
                            modalNetwork.find('select option[value='+response.data.status_id+']').attr('selected', 'selected');
                        } else {
                            $.notify('Error get network object', 'error');
                        }
                    }
                });
            });

        });
    </script>
@endpush

