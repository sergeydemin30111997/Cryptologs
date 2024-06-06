<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">
    <title>{{ __('welcome.title') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
</head>
<body style="overflow: hidden;">
@if(session()->has('message'))
    <div class="form_message modal_window" id="form_message">
        <button class="close mx_button_act-closemessagewindow" target_modal_id="form_message">x</button>
        <h4 class="ttl" style="width: 343px">{{session()->get('message')}}</h4>
    </div>
@endif
<div class="loginscreen">
    <section class="loginwindow">
        <h2 class="txt">{{ __('welcome.welcome') }}</h2>
        <img class="logo" src="{{ asset('assets/logo-large-hd.png') }}">
        @if(config('app.name_bot_auth'))
            <script async src="https://telegram.org/js/telegram-widget.js?15"
                    data-telegram-login="{{ config('app.name_bot_auth') }}"
                    data-size="large" data-auth-url="/auth/login" data-request-access="write"></script>
        @endif
        <div class="accept_terms">
            <div class="leftside">
                <input type="checkbox" name="rules" value="true" class="inp" checked>
                <div class="checkbox">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                        <path d="M1.5 4.00005L4.65 7.15005L10.5 1.30005" stroke="#7E73FF" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
            </div>
            <div class="rightside">
                <p>{!! __('welcome.faq', ['href_faq' => route('faq')]) !!}</p>
            </div>
        </div>
    </section>
</div>
<script src="{{ asset('js/core/jquery.min.js') }}"></script>
</body>
</html>
