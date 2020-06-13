@extends('cabinet.layouts.main')

@section('title', 'Инструкции')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Инструкции</h4>
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
                            @if($help->image)
                                <img src="{{ $help->image }}" class="img-fit-cover wd-300 wd-md-300 wd-lg-300" alt="">
                            @endif
                            <div class="media-body mg-t-20 mg-sm-t-0 mg-sm-l-20">
                                <h6>{{ $help->title }}</h6>
                                <p class="tx-color-03 tx-13 mg-b-10">{!! $help->description !!} </p>
                            </div>
                        </div>
                    </div>
                </div>

{{--                <div class="media">--}}
{{--                    <img src="{{ $help->image }}" class="wd-200 rounded mg-r-20" alt="">--}}
{{--                    <div class="media-body">--}}
{{--                        <h5 class="mg-b-15 tx-inverse">{{ $help->title }}</h5>--}}
{{--                        {!! $help->description !!}--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

        </div>
    </div>
@endsection

