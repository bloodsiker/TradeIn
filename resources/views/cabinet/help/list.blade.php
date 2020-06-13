@extends('cabinet.layouts.main')

@section('title', 'Инструкции')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Инструкции</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ route('cabinet.help.add') }}" class="btn btn-sm btn-dark btn-block">Добавить</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('danger'))
            <div class="alert alert-danger">{{ session('danger') }}</div>
        @endif
        <div class="row">
            @foreach($helps as $help)
                <div class="col-sm-12 col-lg-12 mg-t-10 order-md-1 order-lg-0">
                    <div class="card">
                        <div class="card-body pd-0">
                            <div class="d-sm-flex pd-20">
                                @if($help->image)
                                    <a href="{{ route('cabinet.help.view', ['id' => $help->id]) }}" class="wd-200 wd-md-150 wd-lg-200">
                                        <img src="{{ $help->image }}" class="img-fit-cover" alt="">
                                    </a>
                                @endif
                                <div class="media-body mg-t-20 mg-sm-t-0 mg-sm-l-20">
                                    <h6><a href="{{ route('cabinet.help.view', ['id' => $help->id]) }}" class="link-01">{{ $help->title }}</a></h6>
                                    <p class="tx-color-03 tx-13 mg-b-10">{!! Str::limit($help->description, 200, '...') !!}</p>
                                    @if (Auth::user()->isAdmin())
                                        <a href="{{ route('cabinet.help.edit', ['id' => $help->id]) }}" class="btn btn-success btn-xxs tx-11 tx-medium mg-b-5">Редактировать</a>
                                        <a href="{{ route('cabinet.help.delete', ['id' => $help->id]) }}" class="btn btn-danger btn-xxs tx-11 tx-medium mg-b-5">Удалить</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@push('modals')

    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.buyback_bonus.add') }}" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Добавить бонус</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cost_from">Стоимость от<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="cost_from" id="cost_from" placeholder="Стоимость от" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cost_to">Стоимость до<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="cost_to" id="cost_to" placeholder="Стоимость до" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus">Бонус<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="bonus" id="bonus" placeholder="Бонус" autocomplete="off" required>
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
                <form action="{{ route('cabinet.buyback_bonus.edit') }}" id="formEdit" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Редактировать бонус</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cost_from">Стоимость от<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="cost_from" id="cost_from" placeholder="Стоимость от" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cost_to">Стоимость до<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="cost_to" id="cost_to" placeholder="Стоимость до" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bonus">Бонус<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="bonus" id="bonus" placeholder="Бонус" autocomplete="off" required>
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

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.buyback_bonus.delete') }}");

            $('.editModal').click(function (e) {
                e.preventDefault();

                let modalNetwork = $('#edit-data'),
                    _parent = $(this).parent().parent('tr'),
                    id = _parent.data('id');

                $.ajax({
                    url: "{{ route('cabinet.ajax_date') }}",
                    type: "POST",
                    data: { action: 'get_request_bonus', id: id },
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            modalNetwork.modal('toggle');
                            modalNetwork.modal('toggle');
                            modalNetwork.find('input[name=cost_from]').val(response.data.cost_from)
                            modalNetwork.find('input[name=cost_to]').val(response.data.cost_to)
                            modalNetwork.find('input[name=bonus]').val(response.data.bonus)
                            modalNetwork.find('input[name=id]').val(response.data.id)
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
                            tr.find('td.td-cost-from').text(response.data.cost_from);
                            tr.find('td.td-cost-from').text(response.data.cost_to);
                            tr.find('td.td-bonus').text(response.data.bonus);

                            $.notify(response.message, response.type);
                            $('#edit-data').modal('toggle');
                        }
                    }
                });
            })

        });
    </script>
@endpush

