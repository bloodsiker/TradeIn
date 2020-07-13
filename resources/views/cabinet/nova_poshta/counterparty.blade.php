@extends('cabinet.layouts.main')

@section('title', 'Список ТТН накладных')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Список конгтрагентов</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0 justify-content-end">
                    <a href="{{ route('cabinet.nova_poshta.list') }}" class="btn btn-sm btn-dark">Список ТТН</a>
                    <a href="{{ route('cabinet.nova_poshta.add_counterparty') }}" class="btn btn-sm btn-dark">Добавить контрагента</a>
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

                @if(count($listCounterparty))
                    <div class="table-responsive">
                        <table class="table table-sm table-white table-hover table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" width="40px">ID</th>
                                <th scope="col">Пользователь</th>
                                <th scope="col">Ref</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listCounterparty as $counterparty)
                                <tr>
                                    <td>{{ $counterparty->id }}</td>
                                    <td>{{ $counterparty->fullName() }}</td>
                                    <td>{{ $counterparty->ref }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> Нет контрагентов
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('modals')

    <div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.buyback_request.edit') }}" id="formEdit" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Редактировать заявку на выкуп</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="name">Имя продавца</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Имя продавца" autocomplete="off" readonly>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="phone">Телефон</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Телефон" autocomplete="off" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">E-mail</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="E-mail" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="imei">IMEI-номер</label>
                                <input type="text" class="form-control" name="imei" id="imei" placeholder="IMEI-номер" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="packet">Номер сейф-пакета</label>
                                <input type="text" class="form-control" name="packet" id="packet" placeholder="Номер сейф-пакета" autocomplete="off">
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

            $('.status-filter').select2({
                minimumResultsForSearch: -1,
                placeholder: 'Статус',
                allowClear: true,
            });

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
                            modalNetwork.find('input[name=email]').val(response.data.user.email);
                            modalNetwork.find('input[name=phone]').val(response.data.user.phone);
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

