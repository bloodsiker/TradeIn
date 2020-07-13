@extends('cabinet.layouts.main')

@section('title', 'Список ТТН накладных')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Список конгтрагентов</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0 justify-content-end">
                    <a href="{{ route('cabinet.nova_poshta.counterparty') }}" class="btn btn-sm btn-dark btn-block">
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

                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif

                <form action="{{ route('cabinet.nova_poshta.add_counterparty') }}" id="nova-poshta" method="POST" data-parsley-validate novalidate>
                    @csrf
                    <fieldset class="form-fieldset">

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
                                <label for="phone">Телефон <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone-mask @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" id="RecipientsPhone" autocomplete="off" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>


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
    <script src="{{ asset('lib/jquery.inputmask/jquery.inputmask.js') }}"></script>
    <script>
        $(function(){
            'use strict'

            $(".phone-mask").inputmask("mask", {
                "mask": "9999999999",
                "placeholder": "(999)9999999"
            });
        });
    </script>
@endpush

