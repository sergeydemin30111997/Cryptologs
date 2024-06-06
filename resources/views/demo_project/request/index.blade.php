@extends('template.app')

@section('title', __('request_demo_project.title'))

@section('header')

@endsection

@section('content')
    @if($demo_project)
        @foreach($demo_project as $item_project)
            @push('modal_full_view_demo_project-'.$item_project->id)
                <div class="modal_window" id="modal_full_view_demo_project-{{ $item_project->id }}">
                    <button class="close mx_button_act-openmodalwindow"
                            target_modal_id="modal_full_view_demo_project-{{ $item_project->id }}">x
                    </button>
                    <h4 class="ttl">@lang('request_demo_project.popup_view_project_id'){{ $item_project->id }}</h4>
                    <div class="def_form" style="width: 343px;height: 430px;overflow-y: scroll;">
                        <img style="width: 100%;" loading="lazy"
                             src="{{ asset($item_project->image) }}">
                        <h4 class="ttl">{{ $item_project->name }}</h4>
                        <p class="txt">{!! $item_project->description !!}</p>
                    </div>
                    @if($item_project->url_project)
                        <a href="{{ $item_project->url_project }}">
                            <button class="btn purple">@lang('request_demo_project.popup_view_project_url')</button>
                        </a>
                    @endif
                    @can('demo_project_crud')
                        <form method="POST" action="{{ route('demo_project.destroy', $item_project->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn red">@lang('request_demo_project.popup_button_destroy')</button>
                        </form>
                    @endcan
                </div>
            @endpush
        @endforeach
    @endif
    <main class="dashboard_content dashboard_content-norightsidebar">

        <div class="mx_title_split">
            <div class="mx_title">
                <h2 class="ttl">@lang('request_demo_project.table_name')</h2>
                <p class="desc">@lang('request_demo_project.table_name_desc')</p>
            </div>
        </div>


        <div class="dash_list dash_list-create_demo_project">
            <div class="row row-title">
                <div class="cell">
                    @lang('request_demo_project.table_id')
                </div>
                <div class="cell">
                    @lang('request_demo_project.table_name_demo')
                </div>
                <div class="cell">
                    @lang('request_demo_project.table_user')
                </div>
                <div class="cell">
                    @lang('request_demo_project.table_info')
                </div>
                <div class="cell">

                </div>
            </div>
            @if($request_demo_projects)
                @foreach($request_demo_projects as $request_demo_projects_item)
                    <div class="row">
                        <div class="cell">
                            {{ $request_demo_projects_item->id }}
                        </div>
                        <div class="cell">
                            <a href="#" class="mx_button mx_button_act-openmodalwindow"
                               target_modal_id="modal_full_view_demo_project-{{ $request_demo_projects_item->demo_project_id }}">
                                {{ $request_demo_projects_item->getDemoProject($request_demo_projects_item->demo_project_id)->name }}
                            </a>
                        </div>
                        <div class="cell">
                            <a href="{{ route('user_data.show', $request_demo_projects_item->getUser($request_demo_projects_item->telegram_id)->id) }}">
                                {{ '@'.$request_demo_projects_item->getUser($request_demo_projects_item->telegram_id)->name_telegram }}
                            </a>
                        </div>
                        <div class="cell">
                            <span>
                            @if($request_demo_projects_item->domain)
                                    @lang('request_demo_project.table_info_domain') <b> {{ $request_demo_projects_item->domain }}</b><br>
                                @endif
                                @if($request_demo_projects_item->wallets)
                                    @lang('request_demo_project.table_info_wallet') <b>{{ $request_demo_projects_item->wallets }}</b><br>
                                @endif
                                @if($request_demo_projects_item->message)
                                    @lang('request_demo_project.table_info_more') <b>{{ $request_demo_projects_item->message }}</b><br>
                                @endif
                            </span>
                        </div>
                        <div class="cell">
                            <form method="POST"
                                  action="{{ route('request_demo_project.destroy', $request_demo_projects_item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn red">
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
                    </div>
                @endforeach
            @endif
        </div>
    </main>
@endsection
@section('footer')

@endsection
