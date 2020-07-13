@extends('cabinet.layouts.main')

@section('title', 'Создать номер накладной Новой почты')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Создать ТТН</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0 justify-content-end">
                    <a href="{{ route('cabinet.nova_poshta.list') }}" class="btn btn-sm btn-secondary">
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

                <form action="{{ route('cabinet.nova_poshta.add_ttn') }}" id="nova-poshta" method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                    @csrf
                    <fieldset class="form-fieldset">

                        <div class="divider-text mb-4">Посылка</div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="PayerType">Плательщик <span class="text-danger">*</span></label>
                                <select class="custom-select" id="PayerType" name="PayerType" required>
                                    <option value=""></option>
                                    @foreach($typeOfPayers['data'] as $typeOfPayer)
                                        <option value="{{ $typeOfPayer['Ref'] }}">{{ $typeOfPayer['Description'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="PaymentMethod">Форма оплаты <span class="text-danger">*</span></label>
                                <select class="custom-select" id="PaymentMethod" name="PaymentMethod" required>
                                    <option value=""></option>
                                    @foreach($paymentForms['data'] as $paymentForm)
                                        <option value="{{ $paymentForm['Ref'] }}">{{ $paymentForm['Description'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="CargoType">Тип услуги <span class="text-danger">*</span></label>
                                <select class="custom-select" id="CargoType" name="CargoType" required>
                                    <option value=""></option>
                                    @foreach($cargoTypes['data'] as $cargoType)
                                        <option value="{{ $cargoType['Ref'] }}">{{ $cargoType['Description'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="VolumeGeneral">Объем общий, м.куб (минимум - 0.0004) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('VolumeGeneral') is-invalid @enderror" name="VolumeGeneral" value="{{ old('name') }}" id="VolumeGeneral" placeholder="0.0004" required>
                                @error('VolumeGeneral')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="Weight">Вес фактический (кг) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('Weight') is-invalid @enderror" name="Weight" value="{{ old('Weight') }}" id="Weight" placeholder="0.1" required>
                                @error('Weight')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="Cost">Объявленная стоимость <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('Cost') is-invalid @enderror" name="Cost" value="{{ old('Cost') }}" id="Weight" placeholder="300" required>
                                @error('Cost')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="Description">Дополнительное описание <span class="text-danger">*</span></label>
                                <textarea name="Description" class="form-control @error('Description') is-invalid @enderror" id="Description" rows="2" required>{{ old('Description') }}</textarea>
                                @error('Description')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="divider-text mt-4 mb-4">Отправитель</div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="ContactSender">Отправитель <span class="text-danger">*</span></label>
                                <select class="custom-select" id="ContactSender" name="ContactSender" required>
                                    <option selected></option>
                                    @foreach($counterparties as $person)
                                        <option value="{{ $person->ref }}">{{ $person->fullName() }}</option>
                                    @endforeach
                                </select>
                            </div>

{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="name">Имя <span class="text-danger">*</span></label>--}}
{{--                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" placeholder="Имя" required>--}}
{{--                                @error('name')--}}
{{--                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="surname">Фамилия <span class="text-danger">*</span></label>--}}
{{--                                <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" id="surname" placeholder="Фамилия" required>--}}
{{--                                @error('surname')--}}
{{--                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="patronymic">Отчество</label>--}}
{{--                                <input type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ old('patronymic') }}" id="patronymic" placeholder="Отчество">--}}
{{--                                @error('patronymic')--}}
{{--                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                        </div>

                        <div class="divider-text mt-4 mb-4">Получатель</div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="city">Город <span class="text-danger">*</span></label>
                                <select class="custom-select" id="city" name="CityRecipient">
                                    <option selected></option>
                                    @foreach($cities['data'] as $city)
                                        <option value="{{ $city['Ref'] }}" data-ref="{{ $city['Ref'] }}">{{ $city['DescriptionRu'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="warehouse">Отделение <span class="text-danger">*</span></label>
                                <select class="custom-select" id="warehouse" name="RecipientAddress" required>
                                    <option disabled></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="FirstName">Имя <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('FirstName') is-invalid @enderror" name="FirstName" value="{{ old('FirstName') }}" id="FirstName" placeholder="Имя" required>
                                @error('FirstName')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="MiddleName">Фамилия <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('MiddleName') is-invalid @enderror" name="MiddleName" value="{{ old('MiddleName') }}" id="MiddleName" placeholder="Фамилия" required>
                                @error('MiddleName')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="LastName">Отчество</label>
                                <input type="text" class="form-control @error('LastName') is-invalid @enderror" name="LastName" value="{{ old('LastName') }}" id="LastName" placeholder="Отчество">
                                @error('LastName')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="RecipientsPhone">Телефон <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('RecipientsPhone') is-invalid @enderror" name="RecipientsPhone" value="{{ old('RecipientsPhone') }}" id="RecipientsPhone" autocomplete="off" required>
                                @error('RecipientsPhone')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

{{--                        <div class="form-row">--}}
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="RecipientCityName">Город получателя <span class="text-danger">*</span></label>--}}
{{--                                <input type="text" class="form-control @error('RecipientCityName') is-invalid @enderror" name="RecipientCityName" value="{{ old('RecipientCityName') }}" id="RecipientCityName" autocomplete="off" required>--}}
{{--                                @error('RecipientCityName')--}}
{{--                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="RecipientArea">Область</label>--}}
{{--                                <input type="text" class="form-control @error('RecipientArea') is-invalid @enderror" name="RecipientArea" value="{{ old('RecipientArea') }}" id="RecipientArea" autocomplete="off">--}}
{{--                                @error('RecipientArea')--}}
{{--                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="RecipientAddressName">Номер отделения <span class="text-danger">*</span></label>--}}
{{--                                <input type="text" class="form-control @error('RecipientAddressName') is-invalid @enderror" name="RecipientAddressName" value="{{ old('RecipientAddressName') }}" id="RecipientAddressName" autocomplete="off" required>--}}
{{--                                @error('RecipientAddressName')--}}
{{--                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}


                        <div class="form-row d-flex justify-content-end mg-t-20">
                            <button type="submit" class="btn btn-sm btn-dark"><i class="far fa-save"></i> Создать</button>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function(){
            'use strict'

            $('#city').select2({
                placeholder: 'Город',
                searchInputPlaceholder: 'Поиск города',
                allowClear: true,
            });

            $('#city').on('select2:select', function (e) {
                let _form = $('form#nova-poshta'),
                    url = '{{ route('cabinet.nova_poshta.add_ttn') }}',
                    // city = e.params.data.id,
                    city = $(e.params.data.element).data('ref'),
                    filter = {city: city, action: 'getWarehouse'};

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: filter,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success === true) {
                            var shop = "";

                            for (var i = 0; i < response.data.length; i++) {
                                var id = response.data[i].Ref,
                                    name = response.data[i].DescriptionRu;

                                shop += "<option value='" + id + "'>" + name + "</option>";
                            }
                            _form.find('select#warehouse').html(shop);
                        }
                    }
                });
            });
        });
    </script>
@endpush

