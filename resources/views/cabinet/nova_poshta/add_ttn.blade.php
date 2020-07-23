@extends('cabinet.layouts.main')

@section('title', 'Создать экспресс-накладную')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Создать экспресс-накладную</h4>
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

                @if(Auth::user()->nova_poshta_key)
                    <form action="{{ route('cabinet.nova_poshta.add_ttn') }}" id="nova-poshta" method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                        @csrf
                        <fieldset class="form-fieldset">

                            <div class="divider-text mb-4">Посылка</div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="CargoType">Тип услуги <span class="text-danger">*</span></label>
                                    <select class="custom-select" id="CargoType" name="CargoType" required>
                                        <option value="Parcel">Посилка</option>
                                        <option value="Cargo">Вантаж</option>
{{--                                    @foreach($cargoTypes['data'] as $cargoType)--}}
{{--                                        <option value="{{ $cargoType['Ref'] }}">{{ $cargoType['Description'] }}</option>--}}
{{--                                    @endforeach--}}
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="PayerType">Плательщик <span class="text-danger">*</span></label>
                                    <select class="custom-select" id="PayerType" name="PayerType" required>
                                        <option value="Sender">Відправник</option>
                                        <option value="Recipient">Одержувач</option>
{{--                                        @foreach($typeOfPayers['data'] as $typeOfPayer)--}}
{{--                                            <option value="{{ $typeOfPayer['Ref'] }}">{{ $typeOfPayer['Description'] }}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="PaymentMethod">Форма оплаты <span class="text-danger">*</span></label>
                                    <select class="custom-select" id="PaymentMethod" name="PaymentMethod" required>
                                        <option value="Cash">Готівка</option>
{{--                                    @foreach($paymentForms['data'] as $paymentForm)--}}
{{--                                        <option value="{{ $paymentForm['Ref'] }}">{{ $paymentForm['Description'] }}</option>--}}
{{--                                    @endforeach--}}
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
                                    <input type="text" class="form-control @error('Cost') is-invalid @enderror" name="Cost" value="{{ old('Cost') }}" id="Cost" placeholder="300" required>
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
                                <div class="form-group col-md-12">
                                    <label for="ContactSender">Отправитель <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('ContactSender') is-invalid @enderror" name="ContactSender" value="{{ $senderContact['data'][0]['Description'] }} {{ $senderContact['data'][0]['Phones'] }}" id="ContactSender" readonly required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="CitySender">Город <span class="text-danger">*</span></label>
                                    <select class="custom-select" id="CitySender" name="CitySender">
                                        <option selected></option>
                                        @foreach($cities['data'] as $city)
                                            <option value="{{ $city['Ref'] }}" data-ref="{{ $city['Ref'] }}">{{ $city['DescriptionRu'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="SenderAddress">Отделение <span class="text-danger">*</span></label>
                                    <select class="custom-select" id="SenderAddress" name="SenderAddress" required>
                                        <option disabled></option>
                                    </select>
                                </div>
                            </div>

                            <div class="divider-text mt-4 mb-4">Получатель</div>

                            <div class="form-group">
                                <label for="RecipientContact">Список контрагентов получателей <span class="text-danger">*</span></label>
                                <select class="custom-select" id="RecipientContact" name="RecipientContact">
                                    <option value="">Новый получатель</option>
                                    @foreach($recipientContact['data'] as $contact)
                                        <option value="{{ $contact['Ref'] }}"
                                                data-first="{{ $contact['FirstName'] }}"
                                                data-last="{{ $contact['LastName'] }}"
                                                data-middle="{{ $contact['MiddleName'] }}"
                                                data-phone="{{ $contact['Phones'] }}">
                                            {{ $contact['Description'] }} {{ $contact['Phones'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="LastName">Фамилия <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('LastName') is-invalid @enderror" name="LastName" value="{{ old('LastName') }}" id="LastName" placeholder="Фамилия" required>
                                    @error('LastName')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="FirstName">Имя <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('FirstName') is-invalid @enderror" name="FirstName" value="{{ old('FirstName') }}" id="FirstName" placeholder="Имя" required>
                                    @error('FirstName')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="MiddleName">Отчество</label>
                                    <input type="text" class="form-control @error('MiddleName') is-invalid @enderror" name="MiddleName" value="{{ old('MiddleName') }}" id="MiddleName" placeholder="Отчество">
                                    @error('MiddleName')
                                    <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="RecipientsPhone">Телефон <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('RecipientsPhone') is-invalid @enderror" name="RecipientsPhone" value="{{ old('RecipientsPhone') }}" id="RecipientsPhone" autocomplete="off" required>
                                    @error('RecipientsPhone')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="check_warehouse" name="ServiceType" value="WarehouseWarehouse" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="check_warehouse">Склад</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="check_address" name="ServiceType" value="WarehouseDoors" class="custom-control-input">
                                        <label class="custom-control-label" for="check_address">Адрес</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="CityRecipient">Город <span class="text-danger">*</span></label>
                                    <select class="custom-select" id="CityRecipient" name="CityRecipient">
                                        <option selected></option>
                                        @foreach($cities['data'] as $city)
                                            <option value="{{ $city['DescriptionRu'] }}" data-ref="{{ $city['Ref'] }}">{{ $city['DescriptionRu'] }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group col-md-8 warehouse_warehouse">
                                    <label for="RecipientAddressName">Отделение <span class="text-danger">*</span></label>
                                    <select class="custom-select" id="RecipientAddressName" name="RecipientAddressName" required>
                                        <option disabled></option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6 warehouse_doors d-none">
                                    <label for="RecipientStreetName">Улица <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="RecipientStreetName" value="" id="RecipientStreetName">
                                </div>
                                <div class="form-group col-md-1 warehouse_doors d-none">
                                    <label for="RecipientHouse">Дом <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="RecipientHouse" value="" id="RecipientHouse">
                                </div>
                                <div class="form-group col-md-1 warehouse_doors d-none">
                                    <label for="RecipientFlat">Квартира <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="RecipientFlat" value="" id="RecipientFlat">
                                </div>
                            </div>

                            <div class="form-row d-flex justify-content-end mg-t-20">
                                <button type="submit" class="btn btn-sm btn-dark"><i class="far fa-save"></i> Создать</button>
                            </div>
                        </fieldset>
                    </form>
                @else
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i data-feather="alert-circle" class="mg-r-10"></i> Что бы создавать онлайн экспресс-накладные, добавьте в&nbsp;<a href="{{ route('cabinet.profile') }}">профиле пользователя</a> &nbsp;API ключ Новой почты
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function(){
            'use strict'

            $('#CityRecipient').select2({
                placeholder: 'Город',
                searchInputPlaceholder: 'Поиск города',
                allowClear: true,
            });

            $('input[type=radio][name=ServiceType]').change(function() {
                if (this.value == 'WarehouseWarehouse') {
                    $('.warehouse_warehouse').removeClass('d-none');
                    $('.warehouse_doors').addClass('d-none');
                    $('select[name=RecipientAddressName]').attr('required', true)

                    $('input[name=RecipientStreetName]').removeAttr('required')
                    $('input[name=RecipientHouse]').removeAttr('required')
                    $('input[name=RecipientFlat]').removeAttr('required')
                }
                else if (this.value == 'WarehouseDoors') {
                    $('.warehouse_warehouse').addClass('d-none');
                    $('.warehouse_doors').removeClass('d-none');
                    $('input[name=RecipientStreetName]').attr('required', true)
                    $('input[name=RecipientHouse]').attr('required', true)
                    $('input[name=RecipientFlat]').attr('required', true)

                    $('select[name=RecipientAddressName]').removeAttr('required')
                }
            });

            $('#CityRecipient').on('select2:select', function (e) {
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
                                var id = response.data[i].Number,
                                    name = response.data[i].DescriptionRu;

                                shop += "<option value='" + id + "'>" + name + "</option>";
                            }
                            _form.find('select#RecipientAddressName').html(shop);
                        }
                    }
                });
            });

            $('#CitySender').select2({
                placeholder: 'Город',
                searchInputPlaceholder: 'Поиск города',
                allowClear: true,
            });

            $('#CitySender').on('select2:select', function (e) {
                let _form = $('form#nova-poshta'),
                    url = '{{ route('cabinet.nova_poshta.add_ttn') }}',
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
                            _form.find('select#SenderAddress').html(shop);
                        }
                    }
                });
            });

            $('#RecipientContact').on('change', function (e) {
                let selected = $(this).find(':selected');

                $('#LastName').val(selected.attr('data-last'));
                $('#FirstName').val(selected.attr('data-first'));
                $('#MiddleName').val(selected.attr('data-middle'));
                $('#RecipientsPhone').val(selected.attr('data-phone'));
            });
        });
    </script>
@endpush

