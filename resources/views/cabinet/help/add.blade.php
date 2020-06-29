@extends('cabinet.layouts.main')

@section('title', 'Добавить инструкию')

@push('styles')
{{--    <link href="{{ asset('lib/quill/quill.core.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('lib/quill/quill.snow.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('lib/quill/quill.bubble.css') }}" rel="stylesheet">--}}
@endpush

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Добавить инструкцию</h4>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <a href="{{ route('cabinet.help.list') }}" class="btn btn-sm btn-dark btn-block">
                        <i class="fa fa-undo"></i>
                        Назад
                    </a>
                </div>
            </div>
        </div><!-- container -->
    </div><!-- content -->
@endsection

@section('content')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
            <div class="col-lg-12 col-xl-12">

                <form action="{{ route('cabinet.help.add') }}" id="help" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <fieldset class="form-fieldset">

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="name">Заголовок <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="name" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status">Статус</label>
                                <select class="custom-select" id="status" name="is_active">
                                    <option value="1" @if (old('is_active') === 1) {{ 'selected' }} @endif>Активный</option>
                                    <option value="0" @if (old('is_active') === 0) {{ 'selected' }} @endif>Не активный</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="short_description">Краткое описание</label>
                            <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" id="short_description" rows="2">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mg-t-20">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image" onchange="processSelectedFiles(this)" aria-describedby="image">
                                    <label class="custom-file-label" id="file-name" for="image">Выберете файт</label>
                                </div>
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
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace( 'description', {
            filebrowserUploadUrl: "{{route('cabinet.help.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

        function processSelectedFiles(fileInput) {
            var files = fileInput.files[0];
            document.getElementById('file-name').innerText = files.name;
        }
    </script>

@endpush
