@extends('cabinet.layouts.main')

@section('title', 'Инструкции')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">{{ $help->title }}</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ route('cabinet.help.list') }}" class="btn btn-sm btn-dark btn-block">
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
            <div class="col-sm-12 col-lg-12 mg-t-10 order-md-1 order-lg-0">
                <div class="card">
                    <div class="card-body pd-0">
                        <div class="d-sm-flex pd-20">
                            <div class="tx-13 mg-b-10">
                                @if($help->image)
                                    <img src="{{ $help->image }}" class="wd-100p mg-sm-r-15 mg-b-15" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

