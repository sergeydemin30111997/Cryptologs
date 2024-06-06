@extends('template.app')

@section('title', 'Логи сайтов')

@section('header')

@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Уведомления</h4>
                            <p class="card-category"> Все уведомления присланные от администрации проекта</p>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th>
                                        Номер
                                    </th>
                                    <th>
                                        Сообщение
                                    </th>
                                    <th>
                                        Время
                                    </th>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td>
{{--                                                    {{ $item->id }}--}}
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
{{--                    {{ $projectLogUser->links() }}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection
