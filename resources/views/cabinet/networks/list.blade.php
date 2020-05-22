@extends('cabinet.layouts.main')

@section('title', 'Список користувачів')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Торговые сети</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="#add-network" class="btn btn-sm btn-dark btn-block" data-toggle="modal">Создать</a>
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
                <table class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th scope="col" width="40px">ID</th>
                        <th scope="col">Название</th>
                        <th scope="col" width="80px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($networks as $network)
                        <tr>
                            <th scope="row">{{ $network->id }}</th>
                            <td>{{ $network->name }}</td>
                            <td>
                                <a href="{{ route('cabinet.network.edit', ['id' => $network->id]) }}" class="btn btn-xxs btn-success btn-icon">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="{{ route('cabinet.network.delete', ['id' => $network->id]) }}" class="btn btn-xxs btn-danger btn-icon">
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

@push('modals')

    <div class="modal fade" id="add-network" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form action="{{ route('cabinet.network.add') }}" method="POST" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel6">Создать торговую сеть</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Название" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-sm btn-dark float-right"><i class="far fa-save"></i> Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $(function(){
            'use strict'

            // $('#add-network').on('show.bs.modal', function (event) {
            //
            //     var animation = $(event.relatedTarget).data('animation');
            //     $(this).addClass(animation);
            // })
            //
            // // hide modal with effect
            // $('#madd-network').on('hidden.bs.modal', function (e) {
            //     $(this).removeClass (function (index, className) {
            //         return (className.match (/(^|\s)effect-\S+/g) || []).join(' ');
            //     });
            // });

        });
    </script>
@endpush
