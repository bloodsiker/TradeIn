@extends('cabinet.layouts.main')

@section('title', 'Бонусы')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Бонусы</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="media d-block d-lg-flex">
            <div class="col-md-6 col-xl-3 mg-t-10 order-md-1 order-xl-0">
                <div class="card ht-lg-100p">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mg-b-0">Фильтр</h6>
                    </div>
                    <div class="card-body pd-20">
                        <form action="{{ route('cabinet.profile.bonus') }}" method="GET" novalidate>

                            <div class="form-group">
                                <input type="text" class="form-control filter_date" name="date_from" value="{{ request('date_from') ?: null }}" placeholder="Дата с" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control filter_date" name="date_to" value="{{ request('date_to') ?: null }}" placeholder="Дата по" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-dark">Применить</button>
                                    <a href="{{ route('cabinet.profile.bonus') }}" class="btn btn-danger">Сбросить</a>
                                </div>
                            </div>

                        </form>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col -->


            <div class="col-lg-12 col-xl-9 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            @if (request()->get('date_from') && request()->get('date_to'))
                                <h6 class="mg-b-5">Ваши бонусы в период с {{ \Carbon\Carbon::parse(request()->get('date_from'))->format('d.m.Y') }} - {{ \Carbon\Carbon::parse(request()->get('date_to'))->format('d.m.Y') }}</h6>
                            @else
                                <h6 class="mg-b-5">Ваши бонусы в период с {{ $lastMonth->format('d.m.Y') }} - {{ $now->format('d.m.Y') }}</h6>
                            @endif
                        </div>
                        <div class="d-flex mg-t-20 mg-sm-t-0">

                        </div>
                    </div><!-- card-header -->
                    <div class="card-body pd-y-30">
                        <div class="d-sm-flex">
                            <div class="media">
                                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                                    <i data-feather="bar-chart-2"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Выплачено за период</h6>
                                    <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{ $sumPaid['paid'] }} грн</h4>
                                </div>
                            </div>
                            <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-40">
                                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                                    <i data-feather="bar-chart-2"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Выплачено за все время</h6>
                                    <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{ $sumPaid['all'] }} грн</h4>
                                </div>
                            </div>
                            <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-40">
                                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
                                    <i data-feather="bar-chart-2"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Не выплачено</h6>
                                    <h4 class="tx-20 tx-sm-18 tx-md-24 tx-normal tx-rubik mg-b-0">{{ $sumPaid['not_paid'] }} грн</h4>
                                </div>
                            </div>
                        </div>
                    </div><!-- card-body -->
                    <div class="table-responsive">
                        <table class="table table-dashboard mg-b-0">
                            <thead>
                            <tr>
                                <th>Заявка</th>
                                <th class="text-right">Бонус</th>
                                <th class="text-right">Статус</th>
                                <th class="text-right">Дата выплаты</th>
                                <th class="text-right">Кто выплатил</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bonuses as $bonus)
                                <tr>
                                    <td class="tx-color-03 tx-normal"><a href="">Заявка #{{ $bonus->id }}</a></td>
                                    <td class="tx-medium text-right">{{ $bonus->bonus }}</td>
                                    <td class="text-right {{ $bonus->is_paid ? 'tx-teal' : 'tx-pink' }}">{{ $bonus->is_paid ? 'Выплачена' : 'Не выплачена' }}</td>
                                    <td class="tx-color-03 text-right">{{ $bonus->paid_at ? \Carbon\Carbon::parse($bonus->paid_at)->format('d.m.Y') : '--.--.----' }}</td>
                                    <td class="tx-medium text-right">{{ $bonus->paid_by ? $bonus->paidBy->fullName() : null }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- card -->
            </div><!-- col -->

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.filter_date').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            language: "{{app()->getLocale()}}",
            isRTL: false,
            autoClose: true,
            format: "dd.mm.yyyy",
        });

    </script>
@endpush


