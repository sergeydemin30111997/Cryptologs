@extends('template.app')

@section('title', __('history_users.title'))

@section('header')

@endsection

@section('content')
    <main class="dashboard_content dashboard_content-norightsidebar">

        <div class="mx_title_split">
            <div class="mx_title">
                <h2 class="ttl">@lang('history_users.table_name')</h2>
                <p class="desc">@lang('history_users.table_name_desc')</p>
            </div>
        </div>

        <div class="dash_list dash_list-create_notification">
            <div class="row row-title">
                <div class="cell">
                    @lang('history_users.table_id')
                </div>
                <div class="cell">
                    @lang('history_users.table_action')
                </div>
                <div class="cell">
                    @lang('history_users.table_status')
                </div>
                <div class="cell">
                    @lang('history_users.table_time')
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
                        <div class="cell" style="color: green">
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
        {{ $history_user->links() }}
    </main>
@endsection
@section('footer')

@endsection
