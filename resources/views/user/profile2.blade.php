@extends('template.app')

@section('title', 'Профиль')

@section('header')

@endsection

@section('content')
    @if(Route::is('profile'))
        @if($data_user->payment_desc !== null)
            <div class="modal fade" id="paymentRequest-{{ $data_user->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content card">
                        <div class="card-body">
                            <p class="modal-title" id="exampleModalLongTitle">Запрос на выплату</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="container-fluid card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{ route('payments_request.store') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Сумма</label>
                                            <input type="number" name="balance_request" class="form-control"
                                                   value="{{ $data_user->balance }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Кошелек</label>
                                            <select name="wallet_name" class="form-control" style="color: #d2d2d2;">
                                                @foreach($data_user->payment_desc as $name_wallet => $wallet)
                                                    @if(!empty($wallet))
                                                        <option value="{{ $name_wallet }}">{{ $name_wallet }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Запросить вывод
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    @if(Route::is('user_data.show'))
            <div class="modal fade" id="paymentUpdateRequest-{{ $data_user->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content card">
                        <div class="card-body">
                            <p class="modal-title" id="exampleModalLongTitle">Изменение баланса</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="container-fluid card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form
                                        action="{{ route('user_data.update', $data_user->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <label class="bmd-label-floating">Сумма</label>
                                        <input type="number" name="balance_replace"
                                               class="form-control"
                                               value="{{ $data_user->balance }}">
                                        <label class="bmd-label-floating">Сообщение</label>
                                        <input type="text" name="message"
                                               class="form-control">
                                        <button type="submit" class="btn btn-primary">
                                            Засчитать баланс
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endif
    @if(Route::is('user_data.show'))
        <div class="modal fade" id="paymentSumRequest-{{ $data_user->id }}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content card">
                    <div class="card-body">
                        <p class="modal-title" id="exampleModalLongTitle">Добавлене к балансу</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container-fluid card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form
                                    action="{{ route('user_data.update', $data_user->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label class="bmd-label-floating">Сумма</label>
                                    <input type="number" name="balance_sum"
                                           class="form-control">
                                    <label class="bmd-label-floating">Сообщение</label>
                                    <input type="text" name="message"
                                           class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        Добавить к балансу
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @if(Session::has('message'))
                    <div class="col-md-8">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{Session::get('message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Профиль - {{ $data_user->name_telegram }}</h4>
                            <p class="card-category">Информация по аккаунту</p>
                        </div>
                        <div class="card-body">
                            @if(Route::is('user_data.show'))
                                <form action="{{ route('user_data.update', $data_user->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row justify-content-end">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Текущая роль</label>
                                                <select name="role" class="form-control"
                                                        style="color: #d2d2d2;">
                                                    @foreach($all_roles_in_database as $role)
                                                        @foreach($role_user as $user_role)
                                                            @if($user_role == $role)
                                                                <option value="{{ $role }}"
                                                                        selected>{{ $role }}</option>
                                                            @else
                                                                <option
                                                                    value="{{ $role }}">{{ $role }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit"
                                                    class="btn btn-default disabled">Применить роль
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info">
                                            Баланс: {{ $data_user->balance.'$' }}</button>
                                    </div>
                                </div>
                                @if(Route::is('user_data.show'))
                                    @can('payment_request')
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                @if(Route::is('user_data.show'))
                                                            <a type="button" class="btn btn-primary" data-toggle="modal"
                                                               data-target="#paymentUpdateRequest-{{ $data_user->id }}"
                                                               data-placement="left">
                                                                Поменять
                                                                баланс
                                                            </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                @if(Route::is('user_data.show'))
                                                    <a type="button" class="btn btn-primary" data-toggle="modal"
                                                       data-target="#paymentSumRequest-{{ $data_user->id }}"
                                                       data-placement="left">
                                                        Добавить к
                                                        балансу
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endcan
                                @endif
                                @if(Route::is('profile'))
                                    @if($data_user->payment_desc !== null)
                                        <div class="col-md-5">
                                            <a type="button" class="btn btn-success" data-toggle="modal"
                                               data-target="#paymentRequest-{{ $data_user->id }}"
                                               data-placement="left">
                                                <i class="material-icons">paid</i> Запросить выплату
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <form class="row" action="{{ route('user_data.update', $data_user->id) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <p>Реквизиты для вывода (заполняется минимум 1, изменить можно
                                            только
                                            обратившись к администратору)
                                        </p>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label
                                                    class="bmd-label{{empty($data_user->payment_desc['BTC']) ? '-floating' : ''}}">BTC</label>
                                                <input type="text" name="payment_desc[BTC]"
                                                       class="form-control"
                                                       @if(!empty($data_user->payment_desc['BTC'])) value="{{$data_user->payment_desc['BTC']}}" @endif>
                                            </div>
                                            <div class="col-md-4">
                                                <label
                                                    class="bmd-label{{empty($data_user->payment_desc['ETH']) ? '-floating' : ''}}">ETH(ERC
                                                    20)</label>
                                                <input type="text" name="payment_desc[ETH]"
                                                       class="form-control"
                                                       @if(!empty($data_user->payment_desc['ETH'])) value="{{$data_user->payment_desc['ETH']}}" @endif>
                                            </div>
                                            <div class="col-md-4">
                                                <label
                                                    class="bmd-label{{empty($data_user->payment_desc['Monero']) ? '-floating' : ''}}">Monero</label>
                                                <input type="text" name="payment_desc[Monero]"
                                                       class="form-control"
                                                       @if(!empty($data_user->payment_desc['Monero'])) value="{{$data_user->payment_desc['Monero']}}" @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success"><i
                                                class="material-icons">done</i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#pablo">
                                <img class="img" src="{{ $data_user->photo_telegram }}"/>
                            </a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-category">{{$data_user->getRoleNames()->first()}}</h6>
                            <h4 class="card-title">{{ $data_user->first_name_telegram }}</h4>
                            <p class="card-description">
                                Последний онлайн: {{ $data_user->last_time_online }}
                            </p>
                            <p class="card-description">
                                Телеграм ID: {{ $data_user->id_telegram }}
                            </p>
                            @if(Route::is('user_data.show'))
                                <form action="{{ route('user_data.update', $data_user->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if($data_user->banned == 0)
                                        <input type="hidden" name="banned" value="1">
                                        <button type="submit" class="btn btn-round btn-danger"><i
                                                class="material-icons">delete_forever</i> Забанить
                                        </button>
                                    @else
                                        <input type="hidden" name="banned" value="0">
                                        <button type="submit" class="btn btn-round btn-success"><i
                                                class="material-icons">done</i> Разбанить
                                        </button>
                                    @endif
                                </form>
                            @endif
                            {{--                  <a href="#pablo" class="btn btn-primary btn-round">Follow</a>--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Выплаты</h4>
                            <p class="card-category"> История о последних выплатах</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th>
                                        Номер
                                    </th>
                                    <th>
                                        Сумма
                                    </th>
                                    <th>
                                        Статус
                                    </th>
                                    <th>
                                        Время
                                    </th>
                                    </thead>
                                    <tbody>

                                    @if($history_payments)
                                        @foreach($history_payments as $item_history_payment)
                                            <tr>
                                                <td>
                                                    {{ $item_history_payment->id }}
                                                </td>
                                                <td>
                                                    {{ $item_history_payment->sum.'$' }}
                                                </td>
                                                <td>
                                                    {{ $item_history_payment->status_payment }}
                                                </td>
                                                <td>
                                                    {{ $item_history_payment->created_at->format('G:i:s j.m.Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">История аккаунта</h4>
                            <p class="card-category"> История о последних действиях</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th>
                                        Номер
                                    </th>
                                    <th>
                                        Действие
                                    </th>
                                    <th>
                                        Статус
                                    </th>
                                    <th>
                                        Время
                                    </th>
                                    </thead>
                                    <tbody>

                                    @if($history_user)
                                        @foreach($history_user as $item_history_user)
                                            <tr>
                                                <td>
                                                    {{ $item_history_user->id }}
                                                </td>
                                                <td>
                                                    {{ $item_history_user->message }}
                                                </td>
                                                <td>
                                                    @if($item_history_user->status_view)
                                                        Просмотрено
                                                    @else
                                                        Не просмотрено
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item_history_user->created_at->format('G:i:s j.m.Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('footer')

@endsection
