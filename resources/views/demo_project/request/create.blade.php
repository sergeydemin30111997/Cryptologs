@extends('template.app')

@section('title', 'Заявка на демо проект')

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
                    @if($demo_projects && $data_user->payment_desc)
                    <form method="POST" action="{{ route('request_demo_project.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="demo_project_list">Выбор демо-проекта</label>
                                    <select name="demo_project_id" class="form-control" id="demo_project_list">
                                        @foreach($demo_projects as $demo_project_item)
                                            <option
                                                value="{{ $demo_project_item->id }}">{{ $demo_project_item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Домен - если присутствует</label>
                                    <input type="text" name="domain" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="text-center">Выберете кошелек для выплат</p>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="wallets" class="form-control" style="color: #d2d2d2;">
                                            @foreach($data_user->payment_desc as $name_wallet => $wallet)
                                                @if(!empty($wallet))
                                                    <option value="{{ $name_wallet }}">{{ $name_wallet }}</option>
                                                @endif
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                        @else
                    <h3>Нет созданных проектов, либо не добавлен как минимум 1 адрес кошелека в профиле</h3>
                        @endif
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
