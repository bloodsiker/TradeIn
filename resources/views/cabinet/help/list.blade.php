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
                    <a href="{{ route('cabinet.help.add') }}" class="btn btn-sm btn-dark btn-block">Добавить</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('danger'))
            <div class="alert alert-danger">{{ session('danger') }}</div>
        @endif
        <div class="row">
            @foreach($helps as $help)
                <div class="col-sm-12 col-lg-12 mg-t-10 order-md-1 order-lg-0">
                    <div class="card">
                        <div class="card-body pd-0">
                            <div class="d-sm-flex pd-20">
                                <div class="media-body mg-t-20 mg-sm-t-0 mg-sm-l-20">
                                    <h6><a href="{{ route('cabinet.help.view', ['id' => $help->id]) }}" class="link-01">{{ $help->title }}</a></h6>
                                    <p class="tx-color-03 tx-13 mg-b-10">{{ $help->short_description }}</p>
                                    @if (Auth::user()->isAdmin())
                                        <a href="{{ route('cabinet.help.edit', ['id' => $help->id]) }}" class="btn btn-success btn-xxs tx-11 tx-medium mg-b-5">Редактировать</a>
                                        <a href="{{ route('cabinet.help.delete', ['id' => $help->id]) }}" class="btn btn-danger btn-xxs tx-11 tx-medium mg-b-5">Удалить</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@push('scripts')

@endpush

