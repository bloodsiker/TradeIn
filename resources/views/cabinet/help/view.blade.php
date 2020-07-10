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
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('cabinet.help.edit', ['id' => $help->id]) }}" class="btn btn-sm btn-dark">
                            <i class="fa fa-edit"></i>
                            Редактировать
                        </a>
                    @endif
                    <a href="{{ route('cabinet.help.list') }}" class="btn btn-sm btn-dark">
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
                        <div class="pd-30">
                            @foreach($help->files as $file)
                                @if ($file->type_file === \App\Models\HelpFile::TYPE_IMAGE)
                                    <div class="mg-sm-r-15 mg-b-15">
                                        <img src="{{ $file->file }}" class="wd-100p" alt="">
                                        <a href="{{ $file->file }}" class="badge badge-primary" download="">Скачать</a>
                                    </div>
                                @elseif($file->type_file === \App\Models\HelpFile::TYPE_PDF)
                                    <div class="mg-sm-r-15 mg-b-15">
{{--                                        <iframe src="{{ $file->file }}" width="100%" height="400"></iframe>--}}
                                        <object><embed src="{{ $file->file }}" width="100%" height="800"/></object>
                                    </div>
                                @elseif($file->type_file === \App\Models\HelpFile::TYPE_VIDEO)
                                    <div class="d-flex justify-content-center mg-sm-r-15 mg-b-15">
                                        <video src="{{ $file->file }}" width="800" height="600" controls></video>
                                    </div>
                                @elseif($file->type_file === \App\Models\HelpFile::TYPE_YOUTUBE_VIDEO)
                                    <div class="d-flex justify-content-center mg-sm-r-15 mg-b-15">
                                        <iframe width="100%" height="600" src="{{ $file->file }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

