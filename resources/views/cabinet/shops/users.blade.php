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
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-sm btn-secondary">
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
                    <div class="table-responsive">
                        <table class="table table-sm table-white table-hover table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" width="40px">ID</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Фамилия</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Торговая сеть</th>
                                <th scope="col">Статус</th>
                                @if(Auth::user()->isAdmin())
                                    <th scope="col"></th>
                                @endif
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
                                    <td><span class="badge badge-success">{{ $user->network ? $user->network->name : null }}</span></td>
                                    <td><span class="badge badge-pill badge-{{ $user->attributeStatus('color') }}">{{ $user->attributeStatus('text') }}</span></td>
                                    @if(Auth::user()->isAdmin())
                                        <td>
                                            <a href="{{ route('cabinet.user.edit', ['id' => $user->id]) }}" class="btn btn-xxs btn-success btn-icon">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> В магазине нет сотрудников
                    </div>
               @endif

            </div>
        </div>
    </div>
@endsection
