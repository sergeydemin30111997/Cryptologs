@extends('template.app')

@section('title', __('list_users.title'))

@section('header')

@endsection

@section('content')
    <main class="dashboard_content dashboard_content-norightsidebar">
        <div class="mx_title">
            <h2 class="ttl">@lang('list_users.table_name')</h2>
            <p class="desc">@lang('list_users.table_name_desc')</p>
        </div>
        <div class="dash_list dash_list-users">
            <div class="row row-title">
                <div class="cell">
                    @lang('list_users.table_name_telegram')
                </div>
                <div class="cell">
                    @lang('list_users.table_role')
                </div>
                <div class="cell">
                    @lang('list_users.table_cloak_logs')
                </div>
                <div class="cell">
                    @lang('list_users.table_balance')
                </div>
                <div class="cell">
                    @lang('list_users.table_last_time_online')
                </div>
                <div class="cell">
                </div>
            </div>
            @if($userList)
                @foreach($userList as $data_user)
                    <div class="row">
                        <div class="cell">
                            <a href="{{ route('user_data.show', $data_user->id) }}">{{ '@'.$data_user->name_telegram }}</a>
                        </div>
                        <div class="cell">
                            {{ $data_user->getRoleNames()->first() }}
                        </div>
                        <div class="cell">
                            {{ $data_user->getLogs($data_user->id_telegram)->count() }}
                        </div>
                        <div class="cell">
                            {{ '$'.$data_user->balance }}
                        </div>
                        <div class="cell">
                            {{ $data_user->last_time_online }}
                        </div>
                        <div class="cell">
                            <div class="text_action_buttons">
                                <a href="{{ route('user_data.show', $data_user->id) }}" class="button">@lang('list_users.table_action_view')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{ $userList->links() }}
    </main>
@endsection
@section('footer')

@endsection
