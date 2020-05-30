@extends('cabinet.layouts.main')

@section('title', "Сотрудники торговой сети $network->name")

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Сотрудники торговой сети "{{ $network->name }}" </h4>
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
                    <table class="table table-sm table-dark table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col" width="40px">ID</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Фамилия</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Магазин</th>
                            <th scope="col">Роль</th>
                            <th scope="col">Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->surname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td><span class="badge badge-success">{{ $user->shop ? $user->shop->name : null }}</span></td>
                                <td>{{ $user->role->name }}</td>
                                <td><span class="badge badge-pill badge-{{ $user->attributeStatus('color') }}">{{ $user->attributeStatus('text') }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> В торговой сети нет сотрудников
                    </div>
               @endif

            </div>
        </div>
    </div>
@endsection
