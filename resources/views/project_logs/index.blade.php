@extends('template.app')

@section('title', __('project_logs.title'))

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
                <h2 class="ttl">@lang('project_logs.table_main')</h2>
                <p class="desc">@lang('project_logs.table_desc')</p>
            </div>
            <div class="mx_buttons">
                @can('view_all_logs')
                    <a href="{{ route('project_logs.all', 'all') }}"><button class="mx_button">@lang('project_logs.button_all_logs')
                    </button></a>
                @endcan
            </div>
        </div>
        <div class="dash_list dash_list-logsinfo">
            <div class="row row-title">
                <div class="cell">
                    @lang('project_logs.table_logs_id')
                </div>
                @can('view_all_logs')
                    <div class="cell">
                        @lang('project_logs.table_logs_name_telegram')
                    </div>
                @endcan
                <div class="cell">
                    @lang('project_logs.table_logs_ip')
                </div>
                <div class="cell">
                    @lang('project_logs.table_logs_device')
                </div>
                <div class="cell">
                    @lang('project_logs.table_logs_domain')
                </div>
                <div class="cell">
                    @lang('project_logs.table_logs_cloak_ip')
                </div>
                <div class="cell">
                    @lang('project_logs.table_logs_time')
                </div>
                <div class="cell">

                </div>
            </div>
            @if($projectLogUser)
                @foreach($projectLogUser as $item)
                    <div class="row">
                        <div class="cell">
                            {{ $item->id }}
                        </div>
                        @can('view_all_logs')
                        <div class="cell">
                                <a href="{{ route('user_data.show', $item->getUserLog($item->telegram_id)->id) }}">{{ '@'.$item->getUserLog($item->telegram_id)->name_telegram }}</a>
                        </div>
                        @endcan
                        <div class="cell">
                            @if($item->country_img)
                                <img
                                    style="max-width: 13px;" src="{{ $item->country_img }}"
                                    data-toggle="tooltip" data-placement="left"
                                    title="{{ $item->country }}"/>
                            @else
                                -
                            @endif
                            {{--                    <div class="inline_icons">--}}
                            {{--                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">--}}
                            {{--                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6 1.67998L9.59999 2.87999C9.24749 2.94749 9 3.25499 9 3.61499V7.49999C9 7.91249 9.3375 8.24999 9.75 8.24999H15.75C16.1625 8.24999 16.5 7.91249 16.5 7.49999V2.41499C16.5 1.94249 16.065 1.58998 15.6 1.67998Z" fill="white"/>--}}
                            {{--                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6 16.32L9.59999 15.12C9.24749 15.0525 9 14.745 9 14.385V10.5C9 10.0875 9.3375 9.75 9.75 9.75H15.75C16.1625 9.75 16.5 10.0875 16.5 10.5V15.585C16.5 16.0575 16.065 16.41 15.6 16.32Z" fill="white"/>--}}
                            {{--                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.59248 3.41994L2.09248 4.37243C1.74748 4.44743 1.5 4.75494 1.5 5.10744V7.49994C1.5 7.91244 1.8375 8.24994 2.25 8.24994H6.75C7.1625 8.24994 7.5 7.91244 7.5 7.49994V4.14744C7.5 3.67494 7.05748 3.31494 6.59248 3.41994Z" fill="white"/>--}}
                            {{--                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.59248 14.58L2.09248 13.6275C1.74748 13.5525 1.5 13.245 1.5 12.8925V10.5C1.5 10.0875 1.8375 9.75 2.25 9.75H6.75C7.1625 9.75 7.5 10.0875 7.5 10.5V13.8525C7.5 14.325 7.05748 14.685 6.59248 14.58Z" fill="white"/>--}}
                            {{--                        </svg>--}}
                            {{--                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">--}}
                            {{--                            <path d="M8.86501 5.175C11.01 4.71 13.185 4.6425 15.3375 4.995C14.01 2.895 11.67 1.5 9.00001 1.5C6.66751 1.5 4.58251 2.565 3.20251 4.2375C3.53251 5.2125 3.95251 6.1425 4.45501 7.0275C4.74001 7.5375 5.46751 7.515 5.76001 7.0125C6.39751 5.94 7.54501 5.22 8.86501 5.175Z" fill="white"/>--}}
                            {{--                            <path d="M5.79001 11.04C4.29001 9.43496 3.12001 7.60496 2.31751 5.57996C1.19251 7.79996 1.20001 10.5225 2.57251 12.81C3.77251 14.8125 5.75251 16.0575 7.89751 16.38C8.56501 15.5925 9.15001 14.7525 9.65251 13.875C9.94501 13.365 9.54751 12.7575 8.96251 12.7575C7.71001 12.765 6.50251 12.15 5.79001 11.04Z" fill="white"/>--}}
                            {{--                            <path d="M6.42749 8.99997C6.42749 9.45747 6.53999 9.88497 6.77249 10.29C7.22999 11.0775 8.07749 11.5725 8.99249 11.5725C9.90749 11.5725 10.7625 11.0775 11.2125 10.29C11.445 9.88497 11.565 9.45747 11.565 8.99997C11.565 7.58247 10.41 6.43497 8.99249 6.43497C7.58249 6.42747 6.42749 7.58247 6.42749 8.99997Z" fill="white"/>--}}
                            {{--                            <path d="M16.005 6.31497C14.9775 6.09747 13.935 5.97747 12.9 5.96247C12.3075 5.95497 11.97 6.59997 12.2625 7.11747C12.5625 7.64997 12.735 8.26497 12.735 8.91747C12.735 9.54747 12.57 10.17 12.2625 10.725C11.5575 12.885 10.5075 14.805 9.12 16.5C13.2075 16.4325 16.5 13.1025 16.5 8.99997C16.5 8.05497 16.3275 7.14747 16.005 6.31497Z" fill="white"/>--}}
                            {{--                        </svg>--}}
                            {{--                    </div>--}}
                        </div>
                        <div class="cell">
                            @if(strripos($item->user_agent, 'chrome') !== false)
                                <img
                                    style="max-width: 20px;"
                                    src="{{ asset('browser_img/chrome.png') }}"
                                    data-toggle="tooltip" data-placement="left"
                                    title="Chrome"/>
                            @elseif(strripos($item->user_agent, 'opera') !== false)
                                <img
                                    style="max-width: 20px;"
                                    src="{{ asset('browser_img/opera.png') }}"
                                    data-toggle="tooltip" data-placement="left"
                                    title="Opera"/>
                            @endif
                            @if(strripos($item->user_agent, 'windows') !== false)
                                <img
                                    style="max-width: 20px;"
                                    src="{{ asset('device_img/windows.png') }}"
                                    data-toggle="tooltip" data-placement="left"
                                    title="windows"/>
                            @elseif(strripos($item->user_agent, 'linux') !== false)
                                <img
                                    style="max-width: 20px;"
                                    src="{{ asset('device_img/linux.png') }}"
                                    data-toggle="tooltip" data-placement="left"
                                    title="linux"/>
                            @elseif(strripos($item->user_agent, 'apple') !== false)
                                <img
                                    style="max-width: 20px;"
                                    src="{{ asset('device_img/ios.png') }}"
                                    data-toggle="tooltip" data-placement="left"
                                    title="IOS"/>
                            @elseif(strripos($item->user_agent, 'android') !== false)
                                <img
                                    style="max-width: 20px;"
                                    src="{{ asset('device_img/android.png') }}"
                                    data-toggle="tooltip" data-placement="left"
                                    title="android"/>
                            @endif
                        </div>
                        <div class="cell">
                            {{ $item->domain }}
                        </div>
                        <div class="cell">
                            {{ $item->getLogsIpCount($item->user_ip)->count() }}
                        </div>
                        <div class="cell">
                            {{ $item->created_at->format('G:i:s j.m.Y') }}
                        </div>
                        <div class="cell">
                            <button class="btn purple mx_button mx_button_act-openmodalwindow"
                                    target_modal_id="modal_full_view_project_logs-{{ $item->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18">
                                    <path
                                        d="M16.6042 6.86251C14.8717 4.14001 12.3367 2.57251 9.66675 2.57251C8.33175 2.57251 7.03425 2.96251 5.84925 3.69001C4.66425 4.42501 3.59925 5.49751 2.72925 6.86251C1.97925 8.04001 1.97925 9.95251 2.72925 11.13C4.46175 13.86 6.99675 15.42 9.66675 15.42C11.0017 15.42 12.2992 15.03 13.4842 14.3025C14.6692 13.5675 15.7342 12.495 16.6042 11.13C17.3542 9.96001 17.3542 8.04001 16.6042 6.86251ZM9.66675 12.03C7.98675 12.03 6.63675 10.6725 6.63675 9.00001C6.63675 7.32751 7.98675 5.97001 9.66675 5.97001C11.3467 5.97001 12.6967 7.32751 12.6967 9.00001C12.6967 10.6725 11.3467 12.03 9.66675 12.03Z"
                                        fill="white"/>
                                    <path
                                        d="M9.66674 6.85498C8.48924 6.85498 7.52924 7.81498 7.52924 8.99998C7.52924 10.1775 8.48924 11.1375 9.66674 11.1375C10.8442 11.1375 11.8117 10.1775 11.8117 8.99998C11.8117 7.82248 10.8442 6.85498 9.66674 6.85498Z"
                                        fill="white"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{ $projectLogUser->links() }}
    </main>

@endsection
@section('footer')

@endsection
