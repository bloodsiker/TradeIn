@extends('cabinet.layouts.main')

@section('title', 'Логи пользователей')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Логи пользователей</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ route('cabinet.user.list') }}" class="btn btn-sm btn-dark btn-block">
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
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-sm table-white table-hover table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col">Действие</th>
                            <th scope="col">IP адрес</th>
                            <th scope="col">Юзер-агент</th>
                            <th scope="col">Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <th>{{ $log->id }}</th>
                                <td>{{ $log->user->fullName() }}</td>
                                <td>{{ $log->action }}</td>
                                <td><small>{{ $log->ip_address }}</small></td>
                                <td><small>{{ $log->user_agent }}</small></td>
                                <td><small>{{ $log->created_at->format('d.m.Y H:i') }}</small></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="container-paginate">
                    {{ $logs->links('cabinet.blocks._pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
