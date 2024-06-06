@extends('template.app')

@section('title', __('alert_users.title'))

@section('header')

@endsection

@section('content')
    @push('modal_create_mass_notification')
        <div class="modal_window" id="modal_create_mass_notification">
            <button class="close mx_button_act-openmodalwindow" target_modal_id="modal_create_mass_notification">x
            </button>
            <h4 class="ttl">@lang('alert_users.popup_all_send_top')</h4>
            <form class="def_form" style="width: 343px" action="{{ route('alerts.store') }}" method="POST">
                @csrf
                @method('POST')
                <textarea type="text" name="message" class="default_input" placeholder="@lang('alert_users.popup_input_message')"></textarea>
                <ul class="default_selectlist">
                    @if($userList)
                        @foreach($userList as $userItem)
                            <li class="default_selectlist-item">
                                <input name="usersAlert[]" class="rchbx" type="checkbox" value="{{ $userItem->id }}">
                                <p class="txt">{{ $userItem->name_telegram }}</p>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <div class="textcheckbox_custom">
                    <input name="alertAllUsers" class="inp" type="checkbox">
                    <div class="checkbox">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                            <path d="M1.5 4.00005L4.65 7.15005L10.5 1.30005" stroke="#7E73FF" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="txt">@lang('alert_users.popup_checkbox_all_send_alerts')</p>
                </div>
                <button type="submit" class="submit_button">@lang('alert_users.popup_button_save')</button>
            </form>
        </div>
    @endpush
    <main class="dashboard_content dashboard_content-norightsidebar">
        <div class="mx_title_split">
            <div class="mx_title">
                <h2 class="ttl">@lang('alert_users.table_name')</h2>
                <p class="desc">@lang('alert_users.table_name_desc')</p>
            </div>
            <div class="mx_buttons">
                @can('view_all_logs')
                    <button class="mx_button mx_button_act-openmodalwindow"
                            target_modal_id="modal_create_mass_notification">@lang('alert_users.button_all_alerts_send')
                    </button>
                @endcan
            </div>
            <form class="mx_buttons" action="{{ route('alerts.destroy', $all = 'all') }}" method="POST">
                @csrf
                @method('DELETE')
                    <button style="margin-top: unset;" type="submit" class="btn red">@lang('alert_users.button_all_destroy')
                    </button>
            </form>
        </div>


        <div class="dash_list dash_list-create_notification">
            <div class="row row-title">
                <div class="cell">
                    @lang('alert_users.table_alerts_id')
                </div>
                <div class="cell">
                    @lang('alert_users.table_message')
                </div>
                <div class="cell">
                    @lang('alert_users.table_status')
                </div>
                <div class="cell">
                    @lang('alert_users.table_time')
                </div>
            </div>
            @foreach($alert_list as $alertItem)
                <div class="row">
                    <div class="cell">
                        {{ $alertItem->id }}
                    </div>
                    <div class="cell">
                        {{ $alertItem->message }}
                    </div>
                    <div class="cell" style="color: green">
                        @if($alertItem->status_view)
                            <div class="status_span status_span-green">
                                {{ __('status_view.view') }}
                            </div>
                        @else
                            <div class="status_span status_span-red">
                                {{ __('status_view.no_view') }}
                            </div>
                        @endif
                    </div>
                    <div class="cell">
                        {{ $alertItem->created_at->format('G:i:s j.m.Y') }}
                    </div>
                </div>
            @endforeach
        </div>
        {{ $alert_list->links() }}
    </main>
@endsection
@section('footer')

@endsection
