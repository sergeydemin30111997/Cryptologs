@extends('template.app')

@section('title', __('profile.title'))



@section('header')
    @push('modal_sum_balance')
        <div class="modal_window" id="modal_sum_balance">
            <button class="close mx_button_act-openmodalwindow" target_modal_id="modal_sum_balance">x
            </button>
            <h4 class="ttl">@lang('profile.popup_sum_balance_top')</h4>
            <form class="def_form" style="width: 343px" action="{{ route('user_data.update', $data_user->id) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <p class="txt">@lang('profile.popup_message')</p>
                <textarea type="text" name="message" class="default_input"></textarea>
                <p class="txt">@lang('profile.popup_number')</p>
                <input type="number" name="balance_sum" class="default_input">
                <button type="submit" class="submit_button">Сохранить</button>
            </form>
        </div>
    @endpush
    @push('modal_replace_balance')
        <div class="modal_window" id="modal_replace_balance">
            <button class="close mx_button_act-openmodalwindow" target_modal_id="modal_replace_balance">x
            </button>
            <h4 class="ttl">@lang('profile.popup_replace_balance_top')</h4>
            <form class="def_form" style="width: 343px" action="{{ route('user_data.update', $data_user->id) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <p class="txt">@lang('profile.popup_message')</p>
                <textarea type="text" name="message" class="default_input"></textarea>
                <p class="txt">@lang('profile.popup_number')</p>
                <input type="number" name="balance_replace" class="default_input" value="{{ $data_user->balance }}">
                <button type="submit" class="submit_button">@lang('profile.popup_button_save')</button>
            </form>
        </div>
    @endpush
@endsection

@section('content')
    <main class="dashboard_content">
        @if(Route::is('user_data.show'))
            <aside class="admin_functions_section">
                <h4 class="title">@lang('profile.text_admin_form')</h4>
                <section class="adminfunc adminfunc_givearole">
                    <h5 class="adminfunc_title">@lang('profile.button_roles_text')</h5>
                    <form class="applyuser" action="{{ route('user_data.update', $data_user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="role" class="select">
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
                        <button type="submit" class="select_submit">@lang('profile.button_roles')</button>
                    </form>
                    <div class="act_buttons">
                        <button class="mx_button mx_button_act-openmodalwindow"
                                target_modal_id="modal_replace_balance">@lang('profile.button_replace_balance')
                        </button>
                        <button class="mx_button mx_button_act-openmodalwindow"
                                target_modal_id="modal_sum_balance">@lang('profile.button_sum_balance')
                        </button>
                        <form action="{{ route('user_data.update', $data_user->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')
                            @if($data_user->banned == 0)
                                <input type="hidden" name="banned" value="1">
                                <button type="submit" class="red">@lang('profile.button_ban')</button>
                            @else
                                <input type="hidden" name="banned" value="0">
                                <button type="submit" class="green">@lang('profile.button_unban')</button>
                            @endif
                        </form>
                    </div>
                </section>
            </aside>
            <br>
        @endif
        <aside class="profile_sidebar_main" id="profile_sidebar_main">
            <div class="profile_sidebar-balance">
                <p>@lang('profile.balance')</p>
                <p><b>${{ $data_user->balance }}</b></p>
            </div>
            <section class="profile_minibar">
                <div class="icon">
                    <img src="{{ $data_user->photo_telegram }}">
                </div>
                <div class="tprows">
                    <p><b>{{ $data_user->name_telegram }}</b></p>
                    <p>{{ $data_user->getRoleNames()->first() }}</p>
                </div>
            </section>
            <div class="hr_gripline"></div>
            <div class="profile_registrationinfo">
                <div class="cell">
                    <p class="ttl">@lang('profile.last_time_online')</p>
                    <p class="val">{{ $data_user->last_time_online }}</p>
                </div>
                <div class="cell">
                    <p class="ttl">@lang('profile.text_telegram_id')</p>
                    <p class="val">{{ $data_user->id_telegram }}</p>
                </div>
            </div>
            <div class="hr_gripline"></div>
            <form class="form-fullsized" action="{{ route('user_data.update', $data_user->id) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <h3 class="ttl">@lang('profile.text_address')</h3>
                <p class="desc">@lang('profile.text_address_desc')</p>
                <div class="iconofied_input">
                    <input type="text" placeholder="@lang('profile.text_placeholder_input_wallet') BTC" name="payment_desc[BTC]"
                           @if(!empty($data_user->payment_desc['BTC'])) value="{{$data_user->payment_desc['BTC']}}" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <g>
                            <path
                                d="M17.9986 8.84482C18.0862 13.815 14.1263 17.9123 9.15495 17.9983C4.18848 18.0938 0.0843045 14.1258 0.00150592 9.16204C-0.0885547 4.18861 3.87221 0.0887251 8.84009 0.00135776C13.8124 -0.0840819 17.9122 3.87351 17.999 8.84627L17.9986 8.84482ZM12.5001 6.73514C12.3652 5.53643 11.3183 5.14898 9.9981 5.05218L9.97136 3.38728L8.95413 3.40348L8.98281 5.03213C8.71586 5.03608 8.43938 5.04801 8.16306 5.05757L8.13122 3.41422L7.11037 3.43139L7.13944 5.10499C6.91986 5.11177 6.70428 5.11904 6.49175 5.12316L5.08881 5.14948L5.10839 6.23694C5.10839 6.23694 5.85878 6.21068 5.84642 6.22253C6.26061 6.2172 6.39744 6.45237 6.44095 6.65817L6.52014 11.2345C6.49802 11.3694 6.42504 11.5753 6.13609 11.5813C6.15085 11.5929 5.39366 11.5938 5.39366 11.5938L5.20854 12.8161L6.53071 12.7927L7.25179 12.7875L7.28572 14.4792L8.30598 14.4599L8.27594 12.7827C8.55629 12.7852 8.82384 12.7835 9.09002 12.7766L9.1387 14.4364L10.1595 14.4193L10.1292 12.7266C11.8358 12.6011 13.0277 12.1498 13.1479 10.5403C13.2431 9.24342 12.625 8.67662 11.645 8.46073C12.2266 8.15507 12.5847 7.6188 12.4879 6.73607L12.4951 6.73413L12.5001 6.73514ZM11.138 10.3773C11.1637 11.6441 8.99538 11.5337 8.3054 11.5477L8.26404 9.30659C8.95815 9.29928 11.1173 9.06263 11.138 10.3773ZM10.6117 7.22545C10.6329 8.37694 8.82496 8.27487 8.25049 8.28508L8.2118 6.24516C8.78602 6.23114 10.5873 6.01579 10.6098 7.2213L10.6117 7.22545Z"/>
                        </g>
                    </svg>
                </div>
                <div class="iconofied_input">
                    <input type="text" placeholder="@lang('profile.text_placeholder_input_wallet') ETH (ERC-20)" name="payment_desc[ETH]"
                           @if(!empty($data_user->payment_desc['ETH'])) value="{{$data_user->payment_desc['ETH']}}" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M8.95806 13.4775L3.43506 10.215L8.95731 18L14.4848 10.215L8.95581 13.4775H8.95806ZM9.04206 0L3.51756 9.16725L9.04131 12.4327L14.5651 9.17025L9.04206 0Z"/>
                    </svg>
                </div>
                <div class="iconofied_input">
                    <input type="text" placeholder="@lang('profile.text_placeholder_input_wallet') XMR" name="payment_desc[Monero]"
                           @if(!empty($data_user->payment_desc['Monero'])) value="{{$data_user->payment_desc['Monero']}}" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M9 0C4.02375 0 0 4.02975 0 9.01125C0 10.0125 0.171 10.9665 0.4635 11.8687H3.14625V4.29675L9 10.1588L14.8538 4.2975V11.8687H17.5365C17.8283 10.9665 18 10.0125 18 9.01125C18 4.03125 13.9762 0 9 0ZM7.659 11.4803L5.09625 8.9145V13.6777H1.3185C2.9025 16.2668 5.7585 18 9 18C12.2415 18 15.1215 16.2668 16.6838 13.677H12.9037V8.91375L10.3643 11.4795L9.02325 12.822L7.66275 11.4795H7.659V11.4803Z"/>
                    </svg>
                </div>
                <button type="submit" class="complete_wallets_main hidden btn green">@lang('profile.button_save_address')</button>
                @if($data_user->payment_desc !== null && Route::is('profile'))
                    <button type="button" class="btn purple mx_button mx_button_act-openmodalwindow"
                            target_modal_id="modal_create_payment_request">@lang('profile.button_request_payment')
                    </button>
                @endif
            </form>
        </aside>
            <div class="mx_title_split">
                <div class="mx_title">
                    <h2 class="ttl">@lang('profile.table_payment_name')</h2>
                    <p class="desc">@lang('profile.table_payment_name_desc')</p>
                </div>
                <div class="mx_buttons">
                    @can('view_all_logs')
                        <a href="{{ route('charges.user_id', $data_user->id) }}">
                            <button class="mx_button">@lang('profile.button_user_charges')
                            </button>
                        </a>
                    @endcan
                </div>
            </div>
        <div class="dash_list">
            <div class="row row-title">
                <div class="cell">
                    @lang('profile.table_payments_id')
                </div>
                <div class="cell">
                    @lang('profile.table_payments_number')
                </div>
                <div class="cell">
                    @lang('profile.table_payments_status')
                </div>
                <div class="cell">
                    @lang('profile.table_payments_time')
                </div>
            </div>
            @if(!empty($history_payments))
                @foreach($history_payments as $item_history_payment)
                    <div class="row">
                        <div class="cell">
                            {{ $item_history_payment->id }}
                        </div>
                        <div class="cell">
                            {{ '$'.$item_history_payment->sum }}
                        </div>
                        <div class="cell">
                            @if($item_history_payment->status_payment == 'payout')
                                <div class="status_span status_span-green">
                                    {{ __('payment_requests.'.$item_history_payment->status_payment) }}
                                </div>
                            @else
                                <div class="status_span status_span-red">
                                    {{ __('payment_requests.'.$item_history_payment->status_payment) }}
                                </div>
                            @endif
                        </div>
                        <div class="cell">
                            {{ $item_history_payment->created_at->format('G:i:s j.m.Y') }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <br>
        <div class="mx_title">
            <h2 class="ttl">@lang('profile.table_history_name')</h2>
            <p class="desc">@lang('profile.table_history_name_desc')</p>
        </div>
        <div class="dash_list dash_list-account_history">
            <div class="row row-title">
                <div class="cell">
                    @lang('profile.table_history_id')
                </div>
                <div class="cell">
                    @lang('profile.table_history_action')
                </div>
                <div class="cell">
                    @lang('profile.table_history_status')
                </div>
                <div class="cell">
                    @lang('profile.table_history_time')
                </div>
            </div>
            @if($history_user)
                @foreach($history_user as $item_history_user)
                    <div class="row">
                        <div class="cell">
                            {{ $item_history_user->id }}
                        </div>
                        <div class="cell">
                            {{ __('history_users.'.$item_history_user->key_translate_language, ['number' => $item_history_user->number,
'message' => $item_history_user->message, 'walletname' => $item_history_user->wallet_name, 'namerole' => $item_history_user->name_role, 'ip' => $item_history_user->ip]) }}
                        </div>
                        <div class="cell">
                            @if($item_history_user->status_view)
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
                            {{ $item_history_user->created_at->format('G:i:s j.m.Y') }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>
@endsection
@section('footer')

@endsection
