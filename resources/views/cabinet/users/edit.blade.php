@extends('cabinet.layouts.main')

@section('title', 'Редактировать пользователя')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Редактировать пользователя {{ $user->fullName() }}</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-sm btn-dark btn-block">
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

                <form action="{{ route('cabinet.user.edit', ['id' => $user->id]) }}" id="infoUser" novalidate method="POST">
                    @csrf
                    <fieldset class="form-fieldset">
                        <legend>Персональная информация</legend>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="name">Имя<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" id="name" placeholder="Имя" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="surname">Фамилия<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ $user->surname }}" id="surname" placeholder="Фамилия" required>
                                @error('surname')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="patronymic">Отчество</label>
                                <input type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ $user->patronymic }}" id="patronymic" placeholder="Отчество">
                                @error('patronymic')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

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
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" id="email" placeholder="Email" required>
                                @error('email')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
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
                                <input type="text" class="form-control phone-mask @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" id="phone" placeholder="">
                                @error('phone')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birthday">Дата рождения</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="birthday" value="{{ $user->birthday }}" id="birthday" autocomplete="off">
                                @error('birthday')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                @enderror
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
                                    <option value=""></option>
                                    @foreach($shops as $shop)
                                        <option value="{{ $shop->id }}" @if($shop->id === $user->shop_id) selected @endif>{{ $shop->fullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="divider-text mt-4 mb-4">Данные для акта приема-передачи</div>

                        <div class="form-group">
                            <label for="act_paragraph_1">Доверитель</label>
                            <textarea name="act_paragraph_1" class="form-control" id="act_paragraph_1" cols="30" rows="3">{{ $user->act_paragraph_1 }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="act_paragraph_2">Поверенный</label>
                            <textarea name="act_paragraph_2" class="form-control" id="act_paragraph_2" cols="30" rows="3">{{ $user->act_paragraph_2 }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="act_tov">ТОВ</label>
                            <input type="text" class="form-control" name="act_tov" id="act_tov" value="{{ $user->act_tov }}" placeholder="ТОВ" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="act_shop">Сеть магазинов</label>
                            <input type="text" class="form-control" name="act_shop" id="act_shop" value="{{ $user->act_shop }}" placeholder="Сеть магазинов" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-sm btn-dark float-right"><i class="far fa-save"></i> Сохранить</button>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{--    <script src="{{ asset('lib/jquery.inputmask/jquery.inputmask.js') }}"></script>--}}
    <script>
        $('#birthday').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            language: "{{app()->getLocale()}}",
            isRTL: false,
            autoClose: true,
            format: "dd.mm.yyyy",
        });

        // $(".phone-mask").inputmask("mask", {
        //     "mask": "+38 (999) 999-99-99"
        // });

        $('form#infoUser').on('change', '#network', function (e) {

            let _form = $('form#infoUser');
            let network_id = e.target.value;

            $.ajax({
                url: "{{ route('cabinet.ajax_date') }}",
                type: "POST",
                data: {network_id: network_id, action: 'shop_list'},
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 1) {
                        var shop = "<option value=''></option>";

                        for (var i = 0; i < response.data.length; i++) {
                            var id = response.data[i].id,
                                city = response.data[i].city,
                                address = response.data[i].address,
                                name = response.data[i].name;

                            shop += "<option value='"+id+"'>"+name+ ' / ' +city+', '+address+"</option>";
                        }
                        _form.find('select#shop').html(shop);
                    }
                }
            });
        })
    </script>
@endpush
