@extends('cabinet.layouts.main')

@section('title', 'Список ТТН накладных')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Список создных пакетов</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0 justify-content-end">
                    <a href="{{ route('cabinet.buyback_request.list') }}" class="btn btn-sm btn-dark">
                        <i class="fa fa-undo"></i>
                        Назад
                    </a>
                    <a href="{{ route('cabinet.nova_poshta.list') }}" class="btn btn-sm btn-dark">Список ТТН</a>
                    <a href="#modal-data" class="btn btn-sm btn-dark" data-toggle="modal">Создать</a>
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
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if(count($buyPackets))
                    <div class="table-responsive">
                        <table class="table table-sm table-white table-hover table-bordered tableTtnRequest">
                            <thead>
                            <tr>
                                <th scope="col" width="40px">ID</th>
                                <th scope="col">Пользователь</th>
                                <th scope="col">Номер пакет</th>
                                <th scope="col">Кол-во устройств</th>
                                <th scope="col">Дата</th>
                                <th scope="col" width="40px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($buyPackets as $buyPacket)
                                <tr data-id="{{ $buyPacket->id }}">
                                    <td>{{ $buyPacket->id }}</td>
                                    <td>{{ $buyPacket->user->fullName() }}</td>
                                    <td>{{ $buyPacket->name }}</td>
                                    <td>{{ $buyPacket->requests->count() }}</td>
                                    <td><small>{{ $buyPacket->created_at->format('d.m.Y H:i') }}</small></td>
                                    <td>
                                        <a href="{{ route('cabinet.buyback_request.packet', ['id' => $buyPacket->id]) }}" data-toggle="tooltip" title="Редактировать" class="btn btn-xxs btn-success btn-icon editModal">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> Нет пакетов
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('modals')

    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.buyback_request.packet.add') }}" method="POST" data-parsley-validate novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="titleModal">Создать пакет</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Номер пакета<span class="text-danger">*</span></label>
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
@endpush
