@extends('template.app')

@section('title', __('referrals.title'))

@section('header')

@endsection

@section('content')

    <main class="dashboard_content dashboard_content-norightsidebar">
        <div class="mx_title_split">
            <div class="mx_title">
                <h2 class="ttl">@lang('referrals.table_name')</h2>
                <p class="desc">@lang('referrals.table_desc') {{ route('ref_link', $profile->id) }}</p>
            </div>
            <form action="{{ route('referrals.update', 0) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <div class="mx_buttons" style="text-align: center">
                    @can('view_all_logs')
                        <div class="iconofied_input">
                            <input style="background: black; width: 45px;" type="number" placeholder="0-100"
                                   name="incineration"
                                   value="{{ $incineration }}">%
                        </div>
                        <a href="{{ route('project_logs.all', 'all') }}">
                            <button class="mx_button"><img src="{{ asset('assets/incineration.png') }}">
                            </button>
                        </a>
                    @endcan
                </div>
            </form>
        </div>
        <div class="dash_list dash_list-users">
            <div class="row row-title">
                <div class="cell">
                    @lang('referrals.table_name_telegram')
                </div>
                <div class="cell">
                    @lang('referrals.table_sum_balance')
                </div>
                <div class="cell">
                    @lang('referrals.table_benefit')
                </div>
                <div class="cell">
                    @lang('referrals.table_action')
                </div>
            </div>
            @if($listUsersReferral)
                @foreach($listUsersReferral as $userReferral)
                    <div class="row">
                        <div class="cell">
                            <a href="{{ route('project_logs.all', $profile->getReferral($userReferral->referral_id)->id) }}"> {{ '@'.$profile->getReferral($userReferral->referral_id)->name_telegram }}</a>
                        </div>
                        <div class="cell">
                            {{ $userReferral->sum_balance.'$' }}
                        </div>
                        <div class="cell">
                            @if(!$userReferral->edited)
                                <form action="{{ route('referrals.update', $userReferral->referral_id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="iconofied_input">
                                        <input style="background: black; width: 45px;" type="number" placeholder="0-100"
                                               name="benefit" value="{{ $userReferral->benefit }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                             viewBox="0 0 18 18">
                                            <g>
                                                <path
                                                    d="M17.9986 8.84482C18.0862 13.815 14.1263 17.9123 9.15495 17.9983C4.18848 18.0938 0.0843045 14.1258 0.00150592 9.16204C-0.0885547 4.18861 3.87221 0.0887251 8.84009 0.00135776C13.8124 -0.0840819 17.9122 3.87351 17.999 8.84627L17.9986 8.84482ZM12.5001 6.73514C12.3652 5.53643 11.3183 5.14898 9.9981 5.05218L9.97136 3.38728L8.95413 3.40348L8.98281 5.03213C8.71586 5.03608 8.43938 5.04801 8.16306 5.05757L8.13122 3.41422L7.11037 3.43139L7.13944 5.10499C6.91986 5.11177 6.70428 5.11904 6.49175 5.12316L5.08881 5.14948L5.10839 6.23694C5.10839 6.23694 5.85878 6.21068 5.84642 6.22253C6.26061 6.2172 6.39744 6.45237 6.44095 6.65817L6.52014 11.2345C6.49802 11.3694 6.42504 11.5753 6.13609 11.5813C6.15085 11.5929 5.39366 11.5938 5.39366 11.5938L5.20854 12.8161L6.53071 12.7927L7.25179 12.7875L7.28572 14.4792L8.30598 14.4599L8.27594 12.7827C8.55629 12.7852 8.82384 12.7835 9.09002 12.7766L9.1387 14.4364L10.1595 14.4193L10.1292 12.7266C11.8358 12.6011 13.0277 12.1498 13.1479 10.5403C13.2431 9.24342 12.625 8.67662 11.645 8.46073C12.2266 8.15507 12.5847 7.6188 12.4879 6.73607L12.4951 6.73413L12.5001 6.73514ZM11.138 10.3773C11.1637 11.6441 8.99538 11.5337 8.3054 11.5477L8.26404 9.30659C8.95815 9.29928 11.1173 9.06263 11.138 10.3773ZM10.6117 7.22545C10.6329 8.37694 8.82496 8.27487 8.25049 8.28508L8.2118 6.24516C8.78602 6.23114 10.5873 6.01579 10.6098 7.2213L10.6117 7.22545Z"></path>
                                            </g>
                                        </svg>
                                    </div>
                            @else
                                {{ $userReferral->benefit.'%' }}
                            @endif
                        </div>
                        @if(!$userReferral->edited)
                            <div class="cell">
                                <button type="submit" class="btn green" title="Выплачено">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                         fill="none">
                                        <path
                                            d="M7.00004 0.333374C3.32671 0.333374 0.333374 3.32671 0.333374 7.00004C0.333374 10.6734 3.32671 13.6667 7.00004 13.6667C10.6734 13.6667 13.6667 10.6734 13.6667 7.00004C13.6667 3.32671 10.6734 0.333374 7.00004 0.333374ZM10.1867 5.46671L6.40671 9.24671C6.31337 9.34004 6.18671 9.39337 6.05337 9.39337C5.92004 9.39337 5.79337 9.34004 5.70004 9.24671L3.81337 7.36004C3.62004 7.16671 3.62004 6.84671 3.81337 6.65337C4.00671 6.46004 4.32671 6.46004 4.52004 6.65337L6.05337 8.18671L9.48004 4.76004C9.67337 4.56671 9.99337 4.56671 10.1867 4.76004C10.38 4.95337 10.38 5.26671 10.1867 5.46671Z"
                                            fill="white"></path>
                                    </svg>
                                </button>
                            </div>
                            </form>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        {{ $listUsersReferral->links() }}
    </main>

@endsection
@section('footer')

@endsection
