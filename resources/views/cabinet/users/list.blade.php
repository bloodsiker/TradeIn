@extends('cabinet.layouts.main')

@section('title', 'Список пользователи')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Пользователи</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ route('cabinet.user.add') }}" type="button" class="btn btn-sm btn-secondary">Создать</a>
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
                        <th scope="col">ID</th>
                        <th scope="col">Имя</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Роль</th>
                        <th scope="col">Статус</th>
                        <th scope="col" width="80px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr data-id="{{ $user->id }}">
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->fullName() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td><span class="badge badge-pill badge-{{ $user->attributeStatus('color') }}">{{ $user->attributeStatus('text') }}</span></td>
                            <td>
                                <a href="{{ route('cabinet.user.edit', ['id' => $user->id]) }}" data-toggle="tooltip" title="Редактировать" class="btn btn-xxs btn-success btn-icon">
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


@push('scripts')
    <script>
        $(function() {
            'use strict'

            deleteObject('.table', '.btnDelete', "{{ route('cabinet.user.delete') }}");
        });
    </script>
@endpush
