@extends('cabinet.layouts.main')

@section('title', "Сотрудники магазина $shop->name")

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Сотрудники магазина "{{ $shop->name }}" </h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ redirect()->back()->getTargetUrl() }}" type="button" class="btn btn-sm btn-secondary">
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
                @if(count($users))
                    <table class="table table-dark table-striped">
                        <thead>
                        <tr>
                            <th scope="col" width="40px">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col" width="110px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td data-id="{{ $user->id }}">{{ $user->id }}</td>
                                <td data-name="{{ $user->name }}">{{ $user->name }}</td>
                                <td>
                                    <a href="{{ route('cabinet.network.users', ['id' => $network->id]) }}" data-toggle="tooltip" title="Пользователи сети" class="btn btn-xxs btn-info btn-icon">
                                        <i class="fas fa-users"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" title="Редактировать" class="btn btn-xxs btn-success btn-icon editModal">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{ route('cabinet.network.delete', ['id' => $network->id]) }}" data-toggle="tooltip" title="Удалить" class="btn btn-xxs btn-danger btn-icon">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> В магазине нет сотрудников
                    </div>
               @endif

            </div>
        </div>
    </div>
@endsection
