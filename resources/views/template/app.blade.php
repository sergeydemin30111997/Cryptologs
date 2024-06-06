<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">
    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
</head>
<body>
    <div class="form_message modal_window">
        <button class="close mx_button_act-closemessagewindow">x</button>
        <h4 class="ttl" style="width: 343px">Ведется плановое обновление, все данные по истории аккаунта будут удалены. Данные по начислению за лог переносятся из истории аккаунта в другой раздел.</h4>
    </div>
@stack('pop-up')
@section('header')
@show
{{-- form message right bottom fixed--}}
@if(session()->has('message'))
    <div class="form_message modal_window" id="form_message">
        <button class="close mx_button_act-closemessagewindow" target_modal_id="form_message">x</button>
        <h4 class="ttl" style="width: 343px">{{session()->get('message')}}</h4>
    </div>
@endif
{{-- end form message right bottom fixed --}}
{{-- pop-up create payment request --}}
<div class="modal_windows_container" id="modal_windows_container">
    <div class="modal_window" id="modal_create_payment_request">
        <button class="close mx_button_act-openmodalwindow" target_modal_id="modal_create_payment_request">x</button>
        <h4 class="ttl">Вывод средств</h4>
        <form action="{{ route('payments_request.store') }}" method="POST" class="def_form" style="width: 343px">
            @csrf
            @method('POST')
            <p class="txt">@lang('profile.popup_request_payment_top')</p>
            <input type="number" name="balance_request" class="default_input" value="{{ $profile->balance }}">
            @if($profile->payment_desc)
                <p class="txt">@lang('profile.popup_list_wallets')</p>
                <select name="wallet_name">
                    @foreach($profile->payment_desc as $name_wallet => $wallet)
                        @if(!empty($wallet))
                            <option value="{{ $name_wallet }}">{{ $name_wallet }}</option>
                        @endif
                    @endforeach
                </select>
            @endif
            <br>
            <button type="submit" class="submit_button">@lang('profile.popup_button_save')</button>
        </form>
    </div>
    @stack('modal_create_mass_notification')
    @stack('modal_sum_balance')
    @stack('modal_replace_balance')
    @stack('modal_create_demo_project')
    @stack('modal_create_request_demo_project')
    @if(isset($demo_project))
        @foreach($demo_project as $item_project)
            @stack('modal_full_view_demo_project-'.$item_project->id)
            @stack('modal_full_edit_demo_project-'.$item_project->id)
        @endforeach
    @endif
    @stack('modal_full_view_project_logs')
</div>
{{-- end pop-up create payment request --}}
<div class="app app-starthiddenprofile">
    <aside class="topbar_bar">
        <div class="topbar_bar_left">
            <button class="mobile_opensidebar_menu" id="opendashboardsidebarbutton">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <rect x="1.25" y="13.12" width="27.5" height="3.75"/>
                    <rect x="1.25" y="5" width="27.5" height="3.75"/>
                    <rect x="1.25" y="21.25" width="27.5" height="3.75"/>
                </svg>
            </button>
            <div class="dashboard_title">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                        <path class="cls-1"
                              d="M29.13,13.78h-13V1h6.21A6.85,6.85,0,0,1,26.1,2.44a6.5,6.5,0,0,1,2.07,2.49,6.58,6.58,0,0,1,.74,3c0,.61.18,1.22.21,1.83s0,1.37,0,2Z"/>
                        <path class="cls-1"
                              d="M29.13,16.26a44.27,44.27,0,0,1,0,4.47,14.8,14.8,0,0,1-.47,3.18,6.8,6.8,0,0,1-1,2.1,7.32,7.32,0,0,1-4.38,2.79A10.92,10.92,0,0,1,21,29c-1.6,0-3.21,0-4.82,0-.18-1-.23-9.06-.08-12.75Z"/>
                        <path class="cls-1"
                              d="M.89,13.75c0-2.09-.1-4.14,0-6.18A6.81,6.81,0,0,1,2.66,3.48,6.25,6.25,0,0,1,4.34,2,7,7,0,0,1,7.41,1c2.05-.05,4.1,0,6.16,0,.17,1,.22,9.3.07,12.75Z"/>
                        <path class="cls-1"
                              d="M.83,16.23h12.8V29c-2.09,0-4.18.05-6.26,0a5.88,5.88,0,0,1-1.62-.42,6.72,6.72,0,0,1-3-2,7.45,7.45,0,0,1-1.61-3.44C.65,20.83,1.1,18.55.83,16.23Z"/>
                    </svg>
                </div>
                <h1 class="ttl">@yield('title')</h1>
            </div>
        </div>

        <div class="dashboard_toprightelements">
            {{--            <form class="search">--}}
            {{--                <div class="iconofied_input">--}}
            {{--                    <input type="text" placeholder="Поиск по сайту...">--}}
            {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">--}}
            {{--                        <path--}}
            {{--                            d="M8.25002 3.08574C5.39786 3.08574 3.08574 5.39786 3.08574 8.25002C3.08574 11.1022 5.39786 13.4143 8.25002 13.4143C11.1022 13.4143 13.4143 11.1022 13.4143 8.25002C13.4143 5.39786 11.1022 3.08574 8.25002 3.08574ZM1.41431 8.25002C1.41431 4.47476 4.47476 1.41431 8.25002 1.41431C12.0253 1.41431 15.0857 4.47476 15.0857 8.25002C15.0857 12.0253 12.0253 15.0857 8.25002 15.0857C4.47476 15.0857 1.41431 12.0253 1.41431 8.25002Z"/>--}}
            {{--                        <path--}}
            {{--                            d="M11.8966 11.8965C12.223 11.5701 12.7521 11.5701 13.0785 11.8965L16.341 15.159C16.6674 15.4854 16.6674 16.0145 16.341 16.3409C16.0146 16.6673 15.4855 16.6673 15.1591 16.3409L11.8966 13.0784C11.5703 12.752 11.5703 12.2229 11.8966 11.8965Z"/>--}}
            {{--                    </svg>--}}
            {{--                </div>--}}
            {{--            </form>--}}
            @if(!Route::is('profile'))
                <a class="gotoprofile" id="openprofilebutton">
                    {{ $profile->name_telegram }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M9 1.5C7.035 1.5 5.4375 3.0975 5.4375 5.0625C5.4375 6.99 6.945 8.55 8.91 8.6175C8.97 8.61 9.03 8.61 9.075 8.6175C9.09 8.6175 9.0975 8.6175 9.1125 8.6175C9.12 8.6175 9.12 8.6175 9.1275 8.6175C11.0475 8.55 12.555 6.99 12.5625 5.0625C12.5625 3.0975 10.965 1.5 9 1.5Z"/>
                        <path
                            d="M12.8102 10.6125C10.7177 9.21753 7.30521 9.21753 5.19771 10.6125C4.24521 11.25 3.72021 12.1125 3.72021 13.035C3.72021 13.9575 4.24521 14.8125 5.19021 15.4425C6.24021 16.1475 7.62021 16.5 9.00021 16.5C10.3802 16.5 11.7602 16.1475 12.8102 15.4425C13.7552 14.805 14.2802 13.95 14.2802 13.02C14.2727 12.0975 13.7552 11.2425 12.8102 10.6125Z"/>
                    </svg>
                </a>
            @endif
        </div>
    </aside>
    <aside class="dashboard_sidebar" id="dashboard_sidebar">
        <div class="logo">
            <button class="mobile_opensidebar_menu" id="opendashboardsidebarbutton">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <rect x="1.25" y="13.12" width="27.5" height="3.75"/>
                    <rect x="1.25" y="5" width="27.5" height="3.75"/>
                    <rect x="1.25" y="21.25" width="27.5" height="3.75"/>
                </svg>
            </button>
            <img class="large" loading="lazy" src="{{ asset('assets/logo-large.png') }}">
            <img class="small" loading="lazy" src="{{ asset('assets/logo-small.png') }}">
        </div>
        <div class="sidebar_title">
            @yield('title')
        </div>
        <ul class="sidebar_menu">
            <a href="{{ route('profile') }}">
                <li class="sidebar_menu-item{!! (Route::is('profile') ? ' sidebar_menu-item-acitve' : '') !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M14.0302 4.11501L9.71018 1.09251C8.53268 0.267514 6.72518 0.312514 5.59268 1.19001L1.83518 4.12251C1.08518 4.70751 0.492676 5.90751 0.492676 6.85251V12.0275C0.492676 13.94 2.04518 15.5 3.95768 15.5H12.0427C13.9552 15.5 15.5077 13.9475 15.5077 12.035V6.95002C15.5077 5.93751 14.8552 4.69251 14.0302 4.11501ZM8.56268 12.5C8.56268 12.8075 8.30768 13.0625 8.00018 13.0625C7.69268 13.0625 7.43768 12.8075 7.43768 12.5V10.25C7.43768 9.94251 7.69268 9.68751 8.00018 9.68751C8.30768 9.68751 8.56268 9.94251 8.56268 10.25V12.5Z"/>
                    </svg>
                    <h3 class="ttl">@lang('profile.title')</h3>
                </li>
            </a>
            <a href="{{ route('dashboard') }}">
                <li class="sidebar_menu-item{!! (Route::is('dashboard') ? ' sidebar_menu-item-acitve' : '') !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M8.4375 9.5625V16.5H5.8575C3.1275 16.5 1.5 14.8725 1.5 12.1425V9.5625H8.4375Z"/>
                        <path d="M16.5 5.8575V8.4375H9.5625V1.5H12.1425C14.8725 1.5 16.5 3.1275 16.5 5.8575Z"/>
                        <path d="M8.4375 1.5V8.4375H1.5V5.8575C1.5 3.1275 3.1275 1.5 5.8575 1.5H8.4375Z"/>
                        <path d="M16.5 9.5625V12.1425C16.5 14.8725 14.8725 16.5 12.1425 16.5H9.5625V9.5625H16.5Z"/>
                    </svg>
                    <h3 class="ttl">@lang('dashboard.title')</h3>
                </li>
            </a>
            <a href="{{ route('project_logs.index') }}">
                <li class="sidebar_menu-item{!! (Route::is('project_logs.index') ? ' sidebar_menu-item-acitve' : '') !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M15.375 7.6425H13.2075C11.43 7.6425 9.9825 6.195 9.9825 4.4175V2.25C9.9825 1.8375 9.645 1.5 9.2325 1.5H6.0525C3.7425 1.5 1.875 3 1.875 5.6775V12.3225C1.875 15 3.7425 16.5 6.0525 16.5H11.9475C14.2575 16.5 16.125 15 16.125 12.3225V8.3925C16.125 7.98 15.7875 7.6425 15.375 7.6425Z"/>
                        <path
                            d="M11.8498 1.65749C11.5423 1.34999 11.0098 1.55999 11.0098 1.98749V4.60499C11.0098 5.7 11.9398 6.6075 13.0723 6.6075C13.7848 6.615 14.7748 6.615 15.6223 6.615C16.0498 6.615 16.2748 6.11249 15.9748 5.81249C14.8948 4.72499 12.9598 2.76749 11.8498 1.65749Z"/>
                    </svg>
                    <h3 class="ttl">@lang('project_logs.title')</h3>
                </li>
            </a>
            @can('verify_confirm_users')
                <a href="{{ route('confirm_users.index') }}">
                    <li class="sidebar_menu-item{!! (Route::is('confirm_users.index') ? ' sidebar_menu-item-acitve' : '') !!}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path
                                d="M12.1425 1.5H5.8575C3.1275 1.5 1.5 3.1275 1.5 5.8575V12.135C1.5 14.8725 3.1275 16.5 5.8575 16.5H12.135C14.865 16.5 16.4925 14.8725 16.4925 12.1425V5.8575C16.5 3.1275 14.8725 1.5 12.1425 1.5ZM12.585 7.275L8.3325 11.5275C8.2275 11.6325 8.085 11.6925 7.935 11.6925C7.785 11.6925 7.6425 11.6325 7.5375 11.5275L5.415 9.405C5.1975 9.1875 5.1975 8.8275 5.415 8.61C5.6325 8.3925 5.9925 8.3925 6.21 8.61L7.935 10.335L11.79 6.48C12.0075 6.2625 12.3675 6.2625 12.585 6.48C12.8025 6.6975 12.8025 7.05 12.585 7.275Z"/>
                        </svg>
                        <h3 class="ttl">@lang('confirm_users.title') @if($count_confirm_users){{ '('.$count_confirm_users.')' }}@endif</h3>
                    </li>
                </a>
            @endcan
            @can('view_users')
                <a href="{{ route('user_list') }}">
                    <li class="sidebar_menu-item{!! (Route::is('user_list') ? ' sidebar_menu-item-acitve' : '') !!}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path
                                d="M9 1.5C7.035 1.5 5.4375 3.0975 5.4375 5.0625C5.4375 6.99 6.945 8.55 8.91 8.6175C8.97 8.61 9.03 8.61 9.075 8.6175C9.09 8.6175 9.0975 8.6175 9.1125 8.6175C9.12 8.6175 9.12 8.6175 9.1275 8.6175C11.0475 8.55 12.555 6.99 12.5625 5.0625C12.5625 3.0975 10.965 1.5 9 1.5Z"/>
                            <path
                                d="M12.8102 10.6125C10.7177 9.21753 7.30521 9.21753 5.19771 10.6125C4.24521 11.25 3.72021 12.1125 3.72021 13.035C3.72021 13.9575 4.24521 14.8125 5.19021 15.4425C6.24021 16.1475 7.62021 16.5 9.00021 16.5C10.3802 16.5 11.7602 16.1475 12.8102 15.4425C13.7552 14.805 14.2802 13.95 14.2802 13.02C14.2727 12.0975 13.7552 11.2425 12.8102 10.6125Z"/>
                        </svg>
                        <h3 class="ttl">@lang('list_users.title')</h3>
                    </li>
                </a>
            @endcan
            <a href="{{ route('payments_request.index') }}">
                <li class="sidebar_menu-item{!! (Route::is('payments_request.index') ? ' sidebar_menu-item-acitve' : '') !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M16.5002 8.22752V9.77252C16.5002 10.185 16.1702 10.5225 15.7502 10.5375H14.2802C13.4702 10.5375 12.7277 9.94503 12.6602 9.13503C12.6152 8.66252 12.7952 8.22002 13.1102 7.91252C13.3877 7.62752 13.7702 7.46252 14.1902 7.46252H15.7502C16.1702 7.47752 16.5002 7.81502 16.5002 8.22752Z"/>
                        <path
                            d="M15.3525 11.6625H14.28C12.855 11.6625 11.655 10.59 11.535 9.225C11.4675 8.445 11.7525 7.665 12.3225 7.11C12.8025 6.615 13.47 6.3375 14.19 6.3375H15.3525C15.57 6.3375 15.75 6.1575 15.7275 5.94C15.5625 4.1175 14.355 2.8725 12.5625 2.6625C12.3825 2.6325 12.195 2.625 12 2.625H5.25C5.04 2.625 4.8375 2.64 4.6425 2.67C2.73 2.91 1.5 4.335 1.5 6.375V11.625C1.5 13.695 3.18 15.375 5.25 15.375H12C14.1 15.375 15.5475 14.0625 15.7275 12.06C15.75 11.8425 15.57 11.6625 15.3525 11.6625ZM9.75 7.3125H5.25C4.9425 7.3125 4.6875 7.0575 4.6875 6.75C4.6875 6.4425 4.9425 6.1875 5.25 6.1875H9.75C10.0575 6.1875 10.3125 6.4425 10.3125 6.75C10.3125 7.0575 10.0575 7.3125 9.75 7.3125Z"/>
                    </svg>
                    <h3 class="ttl">@lang('payment_requests.title')</h3>
                </li>
            </a>
            <a href="{{ route('demo_project.index') }}">
                <li class="sidebar_menu-item{!! (Route::is('demo_project.index') ? ' sidebar_menu-item-acitve' : '') !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M12.1425 1.74744H5.8575C3.1275 1.74744 1.5 3.38244 1.5 6.11244V12.3899C1.5 15.1199 3.1275 16.7474 5.8575 16.7474H12.135C14.865 16.7474 16.4925 15.1199 16.4925 12.3899V6.11244C16.5 3.38244 14.8725 1.74744 12.1425 1.74744ZM8.6775 12.8399C8.6775 13.0649 8.565 13.2674 8.37 13.3874C8.265 13.4549 8.1525 13.4849 8.0325 13.4849C7.935 13.4849 7.8375 13.4624 7.74 13.4174L5.115 12.1049C4.74 11.9099 4.5 11.5274 4.5 11.0999V8.61744C4.5 8.39244 4.6125 8.18994 4.8075 8.06994C5.0025 7.94994 5.235 7.94244 5.4375 8.03994L8.0625 9.35244C8.445 9.54744 8.685 9.92994 8.685 10.3574V12.8399H8.6775ZM8.52 8.82744L5.7 7.30494C5.4975 7.19244 5.37 6.97494 5.37 6.72744C5.37 6.48744 5.4975 6.26244 5.7 6.14994L8.52 4.62744C8.82 4.46994 9.1725 4.46994 9.4725 4.62744L12.2925 6.14994C12.495 6.26244 12.6225 6.47994 12.6225 6.72744C12.6225 6.97494 12.495 7.19244 12.2925 7.30494L9.4725 8.82744C9.3225 8.90994 9.1575 8.94744 8.9925 8.94744C8.8275 8.94744 8.67 8.90994 8.52 8.82744ZM13.5 11.0999C13.5 11.5274 13.26 11.9174 12.8775 12.1049L10.2525 13.4174C10.1625 13.4624 10.065 13.4849 9.96 13.4849C9.84 13.4849 9.7275 13.4549 9.6225 13.3874C9.4275 13.2674 9.315 13.0649 9.315 12.8399V10.3574C9.315 9.92994 9.555 9.53994 9.9375 9.35244L12.5625 8.03994C12.765 7.94244 12.9975 7.94994 13.1925 8.06994C13.3875 8.18994 13.5 8.39244 13.5 8.61744V11.0999Z"/>
                    </svg>
                    <h3 class="ttl">@lang('demo_project.title')</h3>
                </li>
            </a>
            <a href="{{ route('alerts.index') }}">
                <li class="sidebar_menu-item{!! (Route::is('alerts.index') ? ' sidebar_menu-item-acitve' : '') !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M14.505 10.8675L13.755 9.6225C13.5975 9.345 13.455 8.82 13.455 8.5125V6.615C13.455 4.8525 12.42 3.33 10.9275 2.6175C10.5375 1.9275 9.81746 1.5 8.99246 1.5C8.17496 1.5 7.43996 1.9425 7.04996 2.64C5.58746 3.3675 4.57496 4.875 4.57496 6.615V8.5125C4.57496 8.82 4.43246 9.345 4.27496 9.615L3.51746 10.8675C3.21746 11.37 3.14996 11.925 3.33746 12.435C3.51746 12.9375 3.94496 13.3275 4.49996 13.515C5.95496 14.01 7.48496 14.25 9.01496 14.25C10.545 14.25 12.075 14.01 13.53 13.5225C14.055 13.35 14.46 12.9525 14.655 12.435C14.85 11.9175 14.7975 11.3475 14.505 10.8675Z"/>
                        <path
                            d="M11.1223 15.0075C10.8073 15.8775 9.97477 16.5 8.99977 16.5C8.40727 16.5 7.82227 16.26 7.40977 15.8325C7.16977 15.6075 6.98977 15.3075 6.88477 15C6.98227 15.015 7.07977 15.0225 7.18477 15.0375C7.35727 15.06 7.53727 15.0825 7.71727 15.0975C8.14477 15.135 8.57977 15.1575 9.01477 15.1575C9.44227 15.1575 9.86977 15.135 10.2898 15.0975C10.4473 15.0825 10.6048 15.075 10.7548 15.0525C10.8748 15.0375 10.9948 15.0225 11.1223 15.0075Z"/>
                    </svg>
                    <h3 class="ttl">@lang('alert_users.title') @if($count_no_view_alerts){{ '('.$count_no_view_alerts.')' }}@endif</h3>
                </li>
            </a>
            <a href="{{ route('profile.history') }}">
                <li class="sidebar_menu-item{!! (Route::is('profile.history') ? ' sidebar_menu-item-acitve' : '') !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M5.8125 2.625V1.5C5.8125 1.1925 5.5575 0.9375 5.25 0.9375C4.9425 0.9375 4.6875 1.1925 4.6875 1.5V2.67C4.875 2.6475 5.0475 2.625 5.25 2.625H5.8125Z"/>
                        <path
                            d="M11.8125 2.67V1.5C11.8125 1.1925 11.5575 0.9375 11.25 0.9375C10.9425 0.9375 10.6875 1.1925 10.6875 1.5V2.625H11.25C11.4525 2.625 11.625 2.6475 11.8125 2.67Z"/>
                        <path
                            d="M15.9675 11.2275C15.39 10.77 14.6625 10.5 13.875 10.5C13.0875 10.5 12.345 10.7775 11.7675 11.2425C10.9875 11.8575 10.5 12.8175 10.5 13.875C10.5 14.505 10.68 15.1125 10.9875 15.6075C11.2275 15.9975 11.535 16.3425 11.9025 16.605C12.4575 17.01 13.1325 17.25 13.875 17.25C14.73 17.25 15.5025 16.935 16.095 16.41C16.3575 16.1925 16.5825 15.9225 16.7625 15.615C17.07 15.1125 17.25 14.505 17.25 13.875C17.25 12.8025 16.7475 11.8425 15.9675 11.2275ZM13.875 15.48C13.875 14.595 13.155 13.875 12.27 13.875C13.155 13.875 13.875 13.155 13.875 12.27C13.875 13.155 14.595 13.875 15.48 13.875C14.595 13.875 13.875 14.595 13.875 15.48Z"/>
                        <path
                            d="M11.8125 2.67V3.75C11.8125 4.0575 11.5575 4.3125 11.25 4.3125C10.9425 4.3125 10.6875 4.0575 10.6875 3.75V2.625H5.8125V3.75C5.8125 4.0575 5.5575 4.3125 5.25 4.3125C4.9425 4.3125 4.6875 4.0575 4.6875 3.75V2.67C2.475 2.8725 1.5 4.2975 1.5 6.375V12.75C1.5 15 2.625 16.5 5.25 16.5H8.3475C8.9175 16.5 9.3 15.8625 9.1575 15.3075C9.0525 14.9025 9 14.4825 9 14.0625C9 12.5025 9.6975 11.0625 10.905 10.11C11.7825 9.3975 12.9075 9 14.0625 9H14.0925C14.565 9 15 8.655 15 8.1825V6.375C15 4.2975 14.025 2.8725 11.8125 2.67ZM6.75 12.5625H5.25C4.9425 12.5625 4.6875 12.3075 4.6875 12C4.6875 11.6925 4.9425 11.4375 5.25 11.4375H6.75C7.0575 11.4375 7.3125 11.6925 7.3125 12C7.3125 12.3075 7.0575 12.5625 6.75 12.5625ZM9 8.8125H5.25C4.9425 8.8125 4.6875 8.5575 4.6875 8.25C4.6875 7.9425 4.9425 7.6875 5.25 7.6875H9C9.3075 7.6875 9.5625 7.9425 9.5625 8.25C9.5625 8.5575 9.3075 8.8125 9 8.8125Z"/>
                    </svg>
                    <h3 class="ttl">@lang('history_users.title') @if($count_no_view_history_users){{ '('.$count_no_view_history_users.')' }}@endif</h3>
                </li>
            </a>
            @can('attracting_referrals')
                <a href="{{ route('referrals.index') }}">
                    <li class="sidebar_menu-item{!! (Route::is('referrals.index') ? ' sidebar_menu-item-acitve' : '') !!}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path
                                d="M15.375 7.6425H13.2075C11.43 7.6425 9.9825 6.195 9.9825 4.4175V2.25C9.9825 1.8375 9.645 1.5 9.2325 1.5H6.0525C3.7425 1.5 1.875 3 1.875 5.6775V12.3225C1.875 15 3.7425 16.5 6.0525 16.5H11.9475C14.2575 16.5 16.125 15 16.125 12.3225V8.3925C16.125 7.98 15.7875 7.6425 15.375 7.6425Z"/>
                            <path
                                d="M11.8498 1.65749C11.5423 1.34999 11.0098 1.55999 11.0098 1.98749V4.60499C11.0098 5.7 11.9398 6.6075 13.0723 6.6075C13.7848 6.615 14.7748 6.615 15.6223 6.615C16.0498 6.615 16.2748 6.11249 15.9748 5.81249C14.8948 4.72499 12.9598 2.76749 11.8498 1.65749Z"/>
                        </svg>
                        <h3 class="ttl">@lang('referrals.title')</h3>
                    </li>
                </a>
            @endcan
            <a href="{{ route('charges.index') }}">
                <li class="sidebar_menu-item{!! (Route::is('charges.index') ? ' sidebar_menu-item-acitve' : '') !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M16.5002 8.22752V9.77252C16.5002 10.185 16.1702 10.5225 15.7502 10.5375H14.2802C13.4702 10.5375 12.7277 9.94503 12.6602 9.13503C12.6152 8.66252 12.7952 8.22002 13.1102 7.91252C13.3877 7.62752 13.7702 7.46252 14.1902 7.46252H15.7502C16.1702 7.47752 16.5002 7.81502 16.5002 8.22752Z"/>
                        <path
                            d="M15.3525 11.6625H14.28C12.855 11.6625 11.655 10.59 11.535 9.225C11.4675 8.445 11.7525 7.665 12.3225 7.11C12.8025 6.615 13.47 6.3375 14.19 6.3375H15.3525C15.57 6.3375 15.75 6.1575 15.7275 5.94C15.5625 4.1175 14.355 2.8725 12.5625 2.6625C12.3825 2.6325 12.195 2.625 12 2.625H5.25C5.04 2.625 4.8375 2.64 4.6425 2.67C2.73 2.91 1.5 4.335 1.5 6.375V11.625C1.5 13.695 3.18 15.375 5.25 15.375H12C14.1 15.375 15.5475 14.0625 15.7275 12.06C15.75 11.8425 15.57 11.6625 15.3525 11.6625ZM9.75 7.3125H5.25C4.9425 7.3125 4.6875 7.0575 4.6875 6.75C4.6875 6.4425 4.9425 6.1875 5.25 6.1875H9.75C10.0575 6.1875 10.3125 6.4425 10.3125 6.75C10.3125 7.0575 10.0575 7.3125 9.75 7.3125Z"/>
                    </svg>
                    <h3 class="ttl">@lang('charges.title')</h3>
                </li>
            </a>
        </ul>
        <div class="language_menu">
            <ul class="list_language">
                <li class="item @if(App::currentLocale() == 'en')active @endif"><a
                        href="{{ route('set_locale', 'en') }}"><img style="height: 12px; margin-right: 5px;"
                                                                    src="https://assets.ipstack.com/flags/us.svg">English</a>
                </li>
                <li class="item @if(App::currentLocale() == 'ru')active @endif"><a
                        href="{{ route('set_locale', 'ru') }}"><img style="height: 12px; margin-right: 5px;"
                                                                    src="https://assets.ipstack.com/flags/ru.svg">Русский</a>
                </li>
            </ul>
        </div>
    </aside>

    @yield('content')

    @section('footer')
    @show
    @if(!Route::is('profile'))
        <aside class="profile_sidebar" id="profile_sidebar">
            <div class="profile_sidebar-balance">
                <p>@lang('profile.balance')</p>
                <p><b>${{ $profile->balance }}</b></p>
            </div>
            <section class="profile_minibar">
                <div class="icon">
                    <img src="{{ $profile->photo_telegram }}">
                </div>
                <div class="tprows">
                    <p><b>{{ $profile->name_telegram }}</b></p>
                    <p>{{ $profile->getRoleNames()->first() }}</p>
                </div>
            </section>
            <div class="hr_gripline"></div>
            <div class="profile_registrationinfo">
                <div class="cell">
                    <p class="ttl">@lang('profile.last_time_online')</p>
                    <p class="val">{{ $profile->last_time_online }}</p>
                </div>
                <div class="cell">
                    <p class="ttl">@lang('profile.text_telegram_id')</p>
                    <p class="val">{{ $profile->id_telegram }}</p>
                </div>
                @if($partner = $profile->getPartner($profile->id))
                    <div class="cell">
                        <p class="ttl">@lang('profile.text_partner_name')</p>
                        <p class="val">{{ $partner->name_telegram }}</p>
                    </div>
                @endif
            </div>
            <div class="hr_gripline"></div>
            <form class="form-fullsized" action="{{ route('user_data.update', $profile->id) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <h3 class="ttl">@lang('profile.text_address')</h3>
                <p class="desc">@lang('profile.text_address_desc')</p>
                <div class="iconofied_input">
                    <input type="text" placeholder="@lang('profile.text_placeholder_input_wallet') BTC"
                           name="payment_desc[BTC]"
                           @if(!empty($profile->payment_desc['BTC'])) value="{{$profile->payment_desc['BTC']}}" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <g>
                            <path
                                d="M17.9986 8.84482C18.0862 13.815 14.1263 17.9123 9.15495 17.9983C4.18848 18.0938 0.0843045 14.1258 0.00150592 9.16204C-0.0885547 4.18861 3.87221 0.0887251 8.84009 0.00135776C13.8124 -0.0840819 17.9122 3.87351 17.999 8.84627L17.9986 8.84482ZM12.5001 6.73514C12.3652 5.53643 11.3183 5.14898 9.9981 5.05218L9.97136 3.38728L8.95413 3.40348L8.98281 5.03213C8.71586 5.03608 8.43938 5.04801 8.16306 5.05757L8.13122 3.41422L7.11037 3.43139L7.13944 5.10499C6.91986 5.11177 6.70428 5.11904 6.49175 5.12316L5.08881 5.14948L5.10839 6.23694C5.10839 6.23694 5.85878 6.21068 5.84642 6.22253C6.26061 6.2172 6.39744 6.45237 6.44095 6.65817L6.52014 11.2345C6.49802 11.3694 6.42504 11.5753 6.13609 11.5813C6.15085 11.5929 5.39366 11.5938 5.39366 11.5938L5.20854 12.8161L6.53071 12.7927L7.25179 12.7875L7.28572 14.4792L8.30598 14.4599L8.27594 12.7827C8.55629 12.7852 8.82384 12.7835 9.09002 12.7766L9.1387 14.4364L10.1595 14.4193L10.1292 12.7266C11.8358 12.6011 13.0277 12.1498 13.1479 10.5403C13.2431 9.24342 12.625 8.67662 11.645 8.46073C12.2266 8.15507 12.5847 7.6188 12.4879 6.73607L12.4951 6.73413L12.5001 6.73514ZM11.138 10.3773C11.1637 11.6441 8.99538 11.5337 8.3054 11.5477L8.26404 9.30659C8.95815 9.29928 11.1173 9.06263 11.138 10.3773ZM10.6117 7.22545C10.6329 8.37694 8.82496 8.27487 8.25049 8.28508L8.2118 6.24516C8.78602 6.23114 10.5873 6.01579 10.6098 7.2213L10.6117 7.22545Z"/>
                        </g>
                    </svg>
                </div>
                <div class="iconofied_input">
                    <input type="text" placeholder="@lang('profile.text_placeholder_input_wallet') ETH (ERC-20)"
                           name="payment_desc[ETH]"
                           @if(!empty($profile->payment_desc['ETH'])) value="{{$profile->payment_desc['ETH']}}" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M8.95806 13.4775L3.43506 10.215L8.95731 18L14.4848 10.215L8.95581 13.4775H8.95806ZM9.04206 0L3.51756 9.16725L9.04131 12.4327L14.5651 9.17025L9.04206 0Z"/>
                    </svg>
                </div>
                <div class="iconofied_input">
                    <input type="text" placeholder="@lang('profile.text_placeholder_input_wallet') XMR"
                           name="payment_desc[Monero]"
                           @if(!empty($profile->payment_desc['Monero'])) value="{{$profile->payment_desc['Monero']}}" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M9 0C4.02375 0 0 4.02975 0 9.01125C0 10.0125 0.171 10.9665 0.4635 11.8687H3.14625V4.29675L9 10.1588L14.8538 4.2975V11.8687H17.5365C17.8283 10.9665 18 10.0125 18 9.01125C18 4.03125 13.9762 0 9 0ZM7.659 11.4803L5.09625 8.9145V13.6777H1.3185C2.9025 16.2668 5.7585 18 9 18C12.2415 18 15.1215 16.2668 16.6838 13.677H12.9037V8.91375L10.3643 11.4795L9.02325 12.822L7.66275 11.4795H7.659V11.4803Z"/>
                    </svg>
                </div>
                <button type="submit"
                        class="complete_wallets hidden btn green">@lang('profile.button_save_address')</button>
                @if($profile->payment_desc !== null)
                    <button type="button" class="btn purple mx_button mx_button_act-openmodalwindow"
                            target_modal_id="modal_create_payment_request">@lang('profile.button_request_payment')
                    </button>
                @endif
            </form>
        </aside>
    @endif
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/mobilemenu.js') }}"></script>
<script src="{{ asset('assets/modalwindows.js') }}"></script>
@stack('logCharts')
@stack('timerUser')
<script>
    $('.profile_sidebar .iconofied_input input').keyup(function () {
        $('.complete_wallets').show();
    });
    $('.profile_sidebar_main .iconofied_input input').keyup(function () {
        $('.complete_wallets_main').show();
    });
</script>
</body>
</html>
