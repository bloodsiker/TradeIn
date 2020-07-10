@extends('cabinet.layouts.main')

@section('title', 'Редактировать инструкцию')

@section('subHeader')
    <div class="sub-content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-0">Редактировать инструкцию</h4>
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
            <div class="col-lg-12 col-xl-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif
                <form action="{{ route('cabinet.help.edit', ['id' => $help->id]) }}" id="help" enctype="multipart/form-data"  method="POST" novalidate>
                    @csrf
                    <fieldset class="form-fieldset">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="title">Заголовок <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $help->title }}" id="title" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status">Статус</label>
                                <select class="custom-select" id="status" name="is_active">
                                    <option value="1" @if ($help->is_active === 1) {{ 'selected' }} @endif>Активный</option>
                                    <option value="0" @if ($help->is_active === 0) {{ 'selected' }} @endif>Не активный</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="short_description">Краткое описание</label>
                            <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" id="short_description" rows="2">{{ $help->short_description }}</textarea>
                            @error('short_description')
                                <span class="invalid-feedback"> <strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <select class="custom-select" id="type_file" name="type_file">
                                    @foreach(\App\Models\HelpFile::listType() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="image" onchange="processSelectedFiles(this)"
                                               aria-describedby="image">
                                        <label class="custom-file-label" id="file-name" for="image">Выберете файт</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row d-flex justify-content-end">
                            <a href="{{ route('cabinet.help.view', ['id' => $help->id]) }}" class="btn btn-sm btn-secondary"><i class="far fa-eye"></i> Посмотреть</a>
                            <button type="submit" class="btn btn-sm btn-dark mg-l-10"><i class="far fa-save"></i> Сохранить</button>
                        </div>
                    </fieldset>
                </form>

                @if($help->files->count())
                    <table class="table table-sm table-white table-hover table-bordered mg-t-20">
                        <thead>
                            <tr>
                                <th scope="col">Файл</th>
                                <th scope="col">Тип</th>
                                <th scope="col" width="80px"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($help->files as $file)
                            <tr data-id="{{ $file->id }}">
                                <td>{{ $file->file }}</td>
                                <td>{{ $file->typeName() }}</td>
                                <td>
                                    <a href="#" data-toggle="tooltip" title="Удалить" class="btn btnDelete btn-xxs btn-danger btn-icon">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{--    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>--}}

    <script>
        {{--CKEDITOR.replace( 'description', {--}}
        {{--    filebrowserUploadUrl: "{{route('cabinet.help.upload', ['_token' => csrf_token() ])}}",--}}
        {{--    filebrowserUploadMethod: 'form'--}}
        {{--});--}}

        deleteObject('.table', '.btnDelete', "{{ route('cabinet.help.delete_file') }}");

        function processSelectedFiles(fileInput) {
            var files = fileInput.files[0];
            document.getElementById('file-name').innerText = files.name;
        }
    </script>

@endpush
