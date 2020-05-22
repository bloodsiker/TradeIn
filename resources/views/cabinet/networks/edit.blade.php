@extends('cabinet.layouts.main')

@section('title', 'Список користувачів')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Редактировать пользователя</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ redirect()->back()->getTargetUrl() }} }}" type="button" class="btn btn-sm btn-secondary">
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

                <form action="{{ route('cabinet.user.edit', ['id' => $user->id]) }}" class="@if ($errors->any()) needs-validation was-validated @endif" novalidate method="POST">
                    @csrf
                    <fieldset class="form-fieldset">
                        <legend>Персональная информация</legend>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="role">Роль</label>
                                <select class="custom-select" id="role" name="role_id">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if($role->id === $user->role_id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Статус</label>
                                <select class="custom-select" id="status" name="is_active">
                                    <option value="1" @if(1 === $user->is_active) selected @endif>Активный</option>
                                    <option value="0" @if(0 === $user->is_active) selected @endif>Не активный</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" id="name" placeholder="Имя" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="surname">Фамилия</label>
                                <input type="text" class="form-control" name="surname" value="{{ $user->surname }}" id="surname" placeholder="Фамилия" required>
                                @error('surname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" id="email" placeholder="Email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Пароль</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Пароль">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="phone">Телефон</label>
                                <input type="text" class="form-control phone-mask" name="phone" value="{{ $user->phone }}" id="phone" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birthday">Дата рождения</label>
                                <input type="text" class="form-control" name="birthday" value="{{ $user->birthday }}" id="birthday" placeholder="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="network">Торговая сеть</label>
                                <select class="custom-select" id="network" name="network_id">
                                    <option selected></option>
                                    @foreach($networks as $network)
                                        <option value="{{ $network->id }}" @if($network->id === $user->network_id) selected @endif>{{ $network->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="shop">Магазин</label>
                                <select class="custom-select" id="shop" name="shop_id">
                                    <option disabled></option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-dark float-right"><i class="far fa-save"></i> Сохранить</button>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#birthday').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            language: "{{app()->getLocale()}}",
            isRTL: false,
            autoclose: true,
            format: "dd.mm.yyyy",
        });
    </script>
@endpush
