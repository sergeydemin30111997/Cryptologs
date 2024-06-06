@extends('template.app')

@section('title', 'Создать демо-проект')

@section('header')

@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @if(Session::has('message'))
                    <div class="col-md-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{Session::get('message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="col-md-4">
                    <form method="POST" action="{{ route('demo_project.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Имя проекта</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">URL проекта - https://google.com(можно оставить пустым)</label>
                                    <input type="text" name="url_project" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-file-upload form-file-simple">
                                    <input type="text" class="form-control inputFileVisible"
                                           placeholder="Изображение (желательно равной высоты и ширины">
                                    <input type="file" name="image" class="inputFileHidden">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Описание</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @push('inputFile')
        <script type="text/javascript">
            $(document).ready(function () {
                // FileInput
                $('.form-file-simple .inputFileVisible').click(function () {
                    $(this).siblings('.inputFileHidden').trigger('click');
                });

                $('.form-file-simple .inputFileHidden').change(function () {
                    var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                    $(this).siblings('.inputFileVisible').val(filename);
                });

                $('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function () {
                    $(this).parent().parent().find('.inputFileHidden').trigger('click');
                    $(this).parent().parent().addClass('is-focused');
                });

                $('.form-file-multiple .inputFileHidden').change(function () {
                    var names = '';
                    for (var i = 0; i < $(this).get(0).files.length; ++i) {
                        if (i < $(this).get(0).files.length - 1) {
                            names += $(this).get(0).files.item(i).name + ',';
                        } else {
                            names += $(this).get(0).files.item(i).name;
                        }
                    }
                    $(this).siblings('.input-group').find('.inputFileVisible').val(names);
                });

                $('.form-file-multiple .btn').on('focus', function () {
                    $(this).parent().siblings().trigger('focus');
                });

                $('.form-file-multiple .btn').on('focusout', function () {
                    $(this).parent().siblings().trigger('focusout');
                });
            });
        </script>
    @endpush
@endsection
