@extends('template.app')

@section('title', __('charges.title'))

@section('header')

@endsection

@section('content')
    @if($projectLogUser)
        @foreach($projectLogUser as $item)
            @push('modal_full_view_project_logs')
                <div class="modal_window" id="modal_full_view_project_logs-{{ $item->id }}">
                    <button class="close mx_button_act-openmodalwindow"
                            target_modal_id="modal_full_view_project_logs-{{ $item->id }}">x
                    </button>
                    <h4 class="ttl">@lang('project_logs.popup_logs_id'){{ $item->id }}</h4>
                    <div class="flex" style="display: flex">
                        <div class="def_form" style="width: 40%;height: 430px;overflow-y: scroll;">
                            @if($item->country_img)
                                <img style="width: 100%;" loading="lazy" class="img" src="{{ $item->country_img }}"/>
                            @endif
                            @if($item->country)
                                <p class="txt">@lang('project_logs.popup_logs_city') {{ $item->country }}</p>
                            @endif
                            <p class="txt">@lang('project_logs.popup_logs_ip') {{ $item->user_ip }}</p>
                            <p class="txt">@lang('project_logs.popup_logs_device') {{ $item->user_agent }}</p>
                            <p class="txt">@lang('project_logs.popup_logs_domain') {{ $item->domain }}</p>
                            <p class="txt">@lang('project_logs.popup_logs_form_name') {{ $item->form_name }}</p>
                            <p class="txt">@lang('project_logs.popup_logs_token') {{ $item->token }}</p>
                            <p class="txt">@lang('project_logs.popup_logs_cloak_ip') {{ $item->getLogsIpCount($item->user_ip)->count() }}</p>
                            @can('view_all_logs')
                                <p class="txt">
                                    @lang('project_logs.popup_logs_name_telegram') <a href="{{ route('user_data.show', $item->getUserLog($item->telegram_id)->id) }}">{{ '@'.$item->getUserLog($item->telegram_id)->name_telegram }}</a>
                                </p>
                            @endcan
                            <p class="txt" style="word-break: break-all;">@lang('project_logs.popup_logs_main_dates') @php echo $item->main_dates @endphp</p>
                        </div>
                        <div class="def_form" style="width: 60%;height: 430px;padding:15px;overflow-y: scroll;">
                            @php $datalog = $item->getLogsIpCount($item->user_ip)->reverse();
                                                     $cloak = [0,];
                            @endphp
                            @foreach($datalog as $itemDataLog)
                                @if(!in_array($itemDataLog->created_at->format('j'), $cloak))
                                    <h4>{{ $itemDataLog->created_at->format('j.m.Y') }}</h4>
                                    @foreach($datalog as $dataItem)
                                        <ul>
                                            @if($dataItem->created_at->format('j') == $itemDataLog->created_at->format('j'))
                                                <li style="list-style: none">
                                                    <p class="txt">{{ $dataItem->domain }} - {{ $dataItem->created_at->format('G:i:s') }}</p>
                                                </li>
                                            @endif
                                        </ul>
                                    @endforeach
                                    @php array_push($cloak, $itemDataLog->created_at->format('j')); @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endpush
        @endforeach
    @endif
    <main class="dashboard_content dashboard_content-norightsidebar">
        <div class="mx_title_split">
            <div class="mx_title">
                <h2 class="ttl">@lang('charges.table_name')</h2>
                <p class="desc">@lang('charges.table_name_desc')</p>
            </div>
            <div class="mx_buttons">
                @can('view_all_logs')
                    <a href="{{ route('charges.user_id', 'all') }}">
                        <button class="mx_button">@lang('charges.button_all_charges')
                        </button>
                    </a>
                @endcan
            </div>
        </div>
        <div class="dash_list dash_list-users">
            <div class="row row-title">
                <div class="cell">
                    @lang('charges.table_id')
                </div>
                <div class="cell">
                    @lang('charges.table_name_telegram')
                </div>
                <div class="cell">
                    @lang('charges.table_sum')
                </div>
                <div class="cell">
                    @lang('charges.table_log')
                </div>
                <div class="cell">
                    @lang('charges.table_created_at')
                </div>
                @can('view_all_logs')
                    @if(!isset($chargesItem->confirm))
                        <div class="cell">
                        </div>
                    @endif
                @endcan
            </div>
            @if($chargesList)
                @foreach($chargesList as $chargesItem)
                    <div
                        class="row @if($chargesItem->confirm) confirm @elseif(!$chargesItem->confirm && isset($chargesItem->confirm)) noconfirm @endif">
                        <div class="cell">
                            {{ $chargesItem->id }}
                        </div>
                        <div class="cell">
                            <a href="{{ route('user_data.show', $chargesItem->user_id) }}">{{ $chargesItem->getNameUser() }}</a>
                        </div>
                        <div class="cell">
                            {{ $chargesItem->sum }}
                        </div>
                        <div class="cell">
                            @if($chargesItem->log_id != 0)
                            <div class="text_action_buttons">
                                <a target_modal_id="modal_full_view_project_logs-{{ $chargesItem->log_id }}" class="button mx_button mx_button_act-openmodalwindow">@lang('list_users.table_action_view') №{{ $chargesItem->log_id }}</a>
                            </div>
                                @else
                                <div class="text_action_buttons">
                                    <a class="button">@lang('list_users.table_action_view')</a>
                                </div>
                            @endif
                        </div>
                        <div class="cell">
                            {{ $chargesItem->created_at->format('G:i:s') }} {{ $chargesItem->created_at->format('j.m.Y') }}
                        </div>
                        @can('view_all_logs')
                            @if(!isset($chargesItem->confirm))
                                <div class="cell">
                                    <form
                                        action="{{ route('charges.update', $chargesItem->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="confirm" value="1">
                                        <button type="submit" class="btn green" title="Подвердить">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                 viewBox="0 0 14 14" fill="none">
                                                <path
                                                    d="M7.00004 0.333374C3.32671 0.333374 0.333374 3.32671 0.333374 7.00004C0.333374 10.6734 3.32671 13.6667 7.00004 13.6667C10.6734 13.6667 13.6667 10.6734 13.6667 7.00004C13.6667 3.32671 10.6734 0.333374 7.00004 0.333374ZM10.1867 5.46671L6.40671 9.24671C6.31337 9.34004 6.18671 9.39337 6.05337 9.39337C5.92004 9.39337 5.79337 9.34004 5.70004 9.24671L3.81337 7.36004C3.62004 7.16671 3.62004 6.84671 3.81337 6.65337C4.00671 6.46004 4.32671 6.46004 4.52004 6.65337L6.05337 8.18671L9.48004 4.76004C9.67337 4.56671 9.99337 4.56671 10.1867 4.76004C10.38 4.95337 10.38 5.26671 10.1867 5.46671Z"
                                                    fill="white"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form
                                        action="{{ route('charges.update', $chargesItem->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="confirm" value="0">
                                        <button type="submit" class="btn red" title="Отклонить">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 16 16" fill="none">
                                                <path
                                                    d="M14.0466 3.48671C12.9733 3.38004 11.8999 3.30004 10.8199 3.24004V3.23337L10.6733 2.36671C10.5733 1.75337 10.4266 0.833374 8.86661 0.833374H7.11994C5.56661 0.833374 5.41994 1.71337 5.31328 2.36004L5.17328 3.21337C4.55328 3.25337 3.93328 3.29337 3.31328 3.35337L1.95328 3.48671C1.67328 3.51337 1.47328 3.76004 1.49994 4.03337C1.52661 4.30671 1.76661 4.50671 2.04661 4.48004L3.40661 4.34671C6.89994 4.00004 10.4199 4.13337 13.9533 4.48671C13.9733 4.48671 13.9866 4.48671 14.0066 4.48671C14.2599 4.48671 14.4799 4.29337 14.5066 4.03337C14.5266 3.76004 14.3266 3.51337 14.0466 3.48671Z"
                                                    fill="white"/>
                                                <path
                                                    d="M12.82 5.42663C12.66 5.25996 12.44 5.16663 12.2134 5.16663H3.7867C3.56004 5.16663 3.33337 5.25996 3.18004 5.42663C3.0267 5.59329 2.94004 5.81996 2.95337 6.05329L3.3667 12.8933C3.44004 13.9066 3.53337 15.1733 5.86004 15.1733H10.14C12.4667 15.1733 12.56 13.9133 12.6334 12.8933L13.0467 6.05996C13.06 5.81996 12.9734 5.59329 12.82 5.42663ZM9.1067 11.8333H6.8867C6.61337 11.8333 6.3867 11.6066 6.3867 11.3333C6.3867 11.06 6.61337 10.8333 6.8867 10.8333H9.1067C9.38004 10.8333 9.6067 11.06 9.6067 11.3333C9.6067 11.6066 9.38004 11.8333 9.1067 11.8333ZM9.6667 9.16663H6.33337C6.06004 9.16663 5.83337 8.93996 5.83337 8.66663C5.83337 8.39329 6.06004 8.16663 6.33337 8.16663H9.6667C9.94004 8.16663 10.1667 8.39329 10.1667 8.66663C10.1667 8.93996 9.94004 9.16663 9.6667 9.16663Z"
                                                    fill="white"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endcan
                    </div>
                @endforeach
            @endif
        </div>
        {{ $chargesList->links() }}
    </main>
@endsection
@section('footer')

@endsection
