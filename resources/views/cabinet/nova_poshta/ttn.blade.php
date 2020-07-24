@extends('cabinet.layouts.main')

@section('title', 'Создать номер накладной Новой почты')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">ТТН {{ $ttnObject->ttn }}</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0 justify-content-end">
                    <a href="{{ route('cabinet.nova_poshta.list') }}" class="btn btn-sm btn-dark">
                        <i class="fa fa-undo"></i>
                        Назад
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                @if(Auth::user()->nova_poshta_key)
                    <div class="table-responsive">
                        <table class="table table-sm table-white table-hover table-bordered">
                            <tbody>

                                <tr>
                                    <td width="30%">Пользователь</td>
                                    <td>
                                        {{ $ttnObject->user->fullName() }}
                                        <br>
                                        <small><b>Тогровая сеть:</b> {{ $ttnObject->user->network ? $ttnObject->user->network->name : null }}</small>
                                        <br>
                                        <small><b>Магазин:</b> {{ $ttnObject->user->shop ? $ttnObject->user->shop->name : null }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Отправитель</td>
                                    <td>
                                        {{ $ttnObject->sender }}
                                        <br>
                                        <small><b>Телефон:</b> {{ $ttnObject->sender_phone }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Получатель</td>
                                    <td>
                                        {{ $ttnObject->recipient }}
                                        <br>
                                        <small><b>Телефон:</b> {{ $ttnObject->recipient_phone }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Номер экспресс-накладной</td>
                                    <td>{{ $ttnObject->ttn }}</td>
                                </tr>
                                <tr>
                                    <td>Стоимость доставки</td>
                                    <td>{{ $ttnObject->cost }} грн</td>
                                </tr>
                                <tr>
                                    <td>Прогноз даты доставки</td>
                                    <td>{{ \Carbon\Carbon::parse($ttnObject->date_delivery)->format('d.m.Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Содержимое посылки</td>
                                    <td>
                                        <span><b>Пакет:</b> {{ $ttnObject->packet->name }}</span>
                                        <ul>
                                            @foreach($ttnObject->packet->requests as $buyRequest)
                                                <li>
                                                    {{ $buyRequest->model->technic->name }} / {{ $buyRequest->model->brand->name }} / {{ $buyRequest->model->name }} / {{ $buyRequest->cost }} грн
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right"><a href="{{ route('cabinet.nova_poshta.delete_ttn', ['ttn' => $ttnObject->ttn]) }}" class="btn btn-danger btn-xxs">Удалить экспресс-накладную</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> Что бы создавать онлайн экспресс-накладные, добавьте в&nbsp;<a href="{{ route('cabinet.profile') }}">профиле пользователя</a> &nbsp;API ключ Новой почты
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
