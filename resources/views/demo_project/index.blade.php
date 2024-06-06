@extends('template.app')

@section('title', __('demo_project.title'))

@section('header')

@endsection

@section('content')
    @push('modal_create_demo_project')
        <div class="modal_window" id="modal_create_demo_project">
            <button class="close mx_button_act-openmodalwindow" target_modal_id="modal_create_demo_project">x</button>
            <h4 class="ttl">@lang('demo_project.popup_create_project_top')</h4>
            <form class="def_form" style="width: 343px" method="POST" action="{{ route('demo_project.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input name="name" type="text" class="default_input" placeholder="@lang('demo_project.popup_create_project_placeholder_name')">
                <input name="url_project" type="text" class="default_input"
                       placeholder="@lang('demo_project.popup_create_project_placeholder_url')">
                <div class="file_input">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M17.4752 0.833252H15.0252C14.3002 0.833252 13.7668 1.13325 13.5252 1.66659C13.3918 1.90825 13.3335 2.19159 13.3335 2.52492V4.97492C13.3335 6.03325 13.9668 6.66659 15.0252 6.66659H17.4752C17.8085 6.66659 18.0918 6.60825 18.3335 6.47492C18.8668 6.23325 19.1668 5.69992 19.1668 4.97492V2.52492C19.1668 1.46659 18.5335 0.833252 17.4752 0.833252ZM18.2585 4.10825C18.1752 4.19159 18.0502 4.24992 17.9168 4.25825H16.7418V4.68325L16.7502 5.41659C16.7418 5.55825 16.6918 5.67492 16.5918 5.77492C16.5085 5.85825 16.3835 5.91659 16.2502 5.91659C15.9752 5.91659 15.7502 5.69159 15.7502 5.41659V4.24992L14.5835 4.25825C14.3085 4.25825 14.0835 4.02492 14.0835 3.74992C14.0835 3.47492 14.3085 3.24992 14.5835 3.24992L15.3168 3.25825H15.7502V2.09159C15.7502 1.81659 15.9752 1.58325 16.2502 1.58325C16.5252 1.58325 16.7502 1.81659 16.7502 2.09159L16.7418 2.68325V3.24992H17.9168C18.1918 3.24992 18.4168 3.47492 18.4168 3.74992C18.4085 3.89159 18.3502 4.00825 18.2585 4.10825Z"
                            fill="#7D7B8D"/>
                        <path
                            d="M7.49993 8.65002C8.5953 8.65002 9.48327 7.76205 9.48327 6.66668C9.48327 5.57132 8.5953 4.68335 7.49993 4.68335C6.40457 4.68335 5.5166 5.57132 5.5166 6.66668C5.5166 7.76205 6.40457 8.65002 7.49993 8.65002Z"
                            fill="#7D7B8D"/>
                        <path
                            d="M17.4748 6.66675H17.0832V10.5084L16.9748 10.4167C16.3248 9.85841 15.2748 9.85841 14.6248 10.4167L11.1582 13.3917C10.5082 13.9501 9.45817 13.9501 8.80817 13.3917L8.52484 13.1584C7.93317 12.6417 6.9915 12.5917 6.32484 13.0417L3.20817 15.1334C3.02484 14.6667 2.9165 14.1251 2.9165 13.4917V6.50841C2.9165 4.15841 4.15817 2.91675 6.50817 2.91675H13.3332V2.52508C13.3332 2.19175 13.3915 1.90841 13.5248 1.66675H6.50817C3.47484 1.66675 1.6665 3.47508 1.6665 6.50841V13.4917C1.6665 14.4001 1.82484 15.1917 2.13317 15.8584C2.84984 17.4417 4.38317 18.3334 6.50817 18.3334H13.4915C16.5248 18.3334 18.3332 16.5251 18.3332 13.4917V6.47508C18.0915 6.60842 17.8082 6.66675 17.4748 6.66675Z"
                            fill="#7D7B8D"/>
                    </svg>
                    <p class="desc">@lang('demo_project.popup_create_project_placeholder_image')</p>
                    <input name="image" type="file" class="inp">
                </div>
                <textarea name="description" class="default_textarea" rows="5" placeholder="@lang('demo_project.popup_create_project_placeholder_desc')"></textarea>
                <button type="submit" class="submit_button">@lang('demo_project.popup_button_save')</button>
            </form>
        </div>
    @endpush
    @push('modal_create_request_demo_project')
        <div class="modal_window" id="modal_create_request_demo_project">
            <button class="close mx_button_act-openmodalwindow" target_modal_id="modal_create_request_demo_project">x
            </button>
            <h4 class="ttl">@lang('demo_project.button_create_request')</h4>
            @if($demo_project && $profile->payment_desc)
                <form class="def_form" style="width: 343px" method="POST"
                      action="{{ route('request_demo_project.store') }}">
                    @csrf
                    @method('POST')
                    <p class="txt">@lang('demo_project.popup_create_request_list_project')</p>
                    <select name="demo_project_id">
                        @foreach($demo_project as $demo_project_item)
                            <option
                                value="{{ $demo_project_item->id }}">{{ $demo_project_item->name }}</option>
                        @endforeach
                    </select>
                    <br>
                    <input name="domain" type="text" class="default_input"
                           placeholder="@lang('demo_project.popup_create_request_placeholder_domain')">
                    <p class="txt">@lang('demo_project.popup_create_request_list_wallets')</p>
                    <select name="wallets">
                        @foreach($profile->payment_desc as $name_wallet => $wallet)
                            @if(!empty($wallet))
                                <option value="{{ $name_wallet }}">{{ $name_wallet }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                    <button type="submit" class="submit_button">@lang('demo_project.popup_button_save')</button>
                </form>
            @else
                <p class="txt">@lang('demo_project.popup_invalid_create')</p>
            @endif
        </div>
    @endpush
    @if($demo_project)
        @foreach($demo_project as $item_project)
            @push('modal_full_view_demo_project-'.$item_project->id)
                <div class="modal_window" id="modal_full_view_demo_project-{{ $item_project->id }}">
                    <button class="close mx_button_act-openmodalwindow"
                            target_modal_id="modal_full_view_demo_project-{{ $item_project->id }}">x
                    </button>
                    <h4 class="ttl">@lang('demo_project.popup_view_project_top'){{ $item_project->id }}</h4>
                    <div class="def_form" style="width: 343px;height: 430px;overflow-y: scroll;">
                        <img style="width: 100%;" loading="lazy"
                             src="{{ asset($item_project->image) }}">
                        <h4 class="ttl">{{ $item_project->name }}</h4>
                        <p class="txt">{!! $item_project->description !!}</p>
                    </div>
                    @if($item_project->url_project)
                        <a href="{{ $item_project->url_project }}">
                            <button class="btn purple">@lang('demo_project.popup_view_project_url')</button>
                        </a>
                    @endif
                    @can('demo_project_crud')
                        <form method="POST" action="{{ route('demo_project.destroy', $item_project->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn red">@lang('demo_project.popup_button_destroy')</button>
                        </form>
                    @endcan
                </div>
            @endpush
        @endforeach
    @endif
    @if($demo_project)
        @foreach($demo_project as $item_project)
            @push('modal_full_edit_demo_project-'.$item_project->id)
                <div class="modal_window" id="modal_full_edit_demo_project-{{ $item_project->id }}">
                    <button class="close mx_button_act-openmodalwindow"
                            target_modal_id="modal_full_edit_demo_project-{{ $item_project->id }}">x
                    </button>
                    <h4 class="ttl">@lang('demo_project.popup_view_project_top'){{ $item_project->id }}</h4>
                    <form class="def_form" style="width: 343px" method="POST"
                          action="{{ route('demo_project.update', $item_project->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input name="name" type="text" class="default_input" placeholder="@lang('demo_project.popup_create_project_placeholder_name')"
                               @if($item_project->name) value="{{ $item_project->name }}" @endif>
                        <input name="url_project" type="text" class="default_input"
                               placeholder="@lang('demo_project.popup_create_project_placeholder_url')"
                               @if($item_project->url_project) value="{{ $item_project->url_project }}" @endif>
                        <div class="file_input">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M17.4752 0.833252H15.0252C14.3002 0.833252 13.7668 1.13325 13.5252 1.66659C13.3918 1.90825 13.3335 2.19159 13.3335 2.52492V4.97492C13.3335 6.03325 13.9668 6.66659 15.0252 6.66659H17.4752C17.8085 6.66659 18.0918 6.60825 18.3335 6.47492C18.8668 6.23325 19.1668 5.69992 19.1668 4.97492V2.52492C19.1668 1.46659 18.5335 0.833252 17.4752 0.833252ZM18.2585 4.10825C18.1752 4.19159 18.0502 4.24992 17.9168 4.25825H16.7418V4.68325L16.7502 5.41659C16.7418 5.55825 16.6918 5.67492 16.5918 5.77492C16.5085 5.85825 16.3835 5.91659 16.2502 5.91659C15.9752 5.91659 15.7502 5.69159 15.7502 5.41659V4.24992L14.5835 4.25825C14.3085 4.25825 14.0835 4.02492 14.0835 3.74992C14.0835 3.47492 14.3085 3.24992 14.5835 3.24992L15.3168 3.25825H15.7502V2.09159C15.7502 1.81659 15.9752 1.58325 16.2502 1.58325C16.5252 1.58325 16.7502 1.81659 16.7502 2.09159L16.7418 2.68325V3.24992H17.9168C18.1918 3.24992 18.4168 3.47492 18.4168 3.74992C18.4085 3.89159 18.3502 4.00825 18.2585 4.10825Z"
                                    fill="#7D7B8D"/>
                                <path
                                    d="M7.49993 8.65002C8.5953 8.65002 9.48327 7.76205 9.48327 6.66668C9.48327 5.57132 8.5953 4.68335 7.49993 4.68335C6.40457 4.68335 5.5166 5.57132 5.5166 6.66668C5.5166 7.76205 6.40457 8.65002 7.49993 8.65002Z"
                                    fill="#7D7B8D"/>
                                <path
                                    d="M17.4748 6.66675H17.0832V10.5084L16.9748 10.4167C16.3248 9.85841 15.2748 9.85841 14.6248 10.4167L11.1582 13.3917C10.5082 13.9501 9.45817 13.9501 8.80817 13.3917L8.52484 13.1584C7.93317 12.6417 6.9915 12.5917 6.32484 13.0417L3.20817 15.1334C3.02484 14.6667 2.9165 14.1251 2.9165 13.4917V6.50841C2.9165 4.15841 4.15817 2.91675 6.50817 2.91675H13.3332V2.52508C13.3332 2.19175 13.3915 1.90841 13.5248 1.66675H6.50817C3.47484 1.66675 1.6665 3.47508 1.6665 6.50841V13.4917C1.6665 14.4001 1.82484 15.1917 2.13317 15.8584C2.84984 17.4417 4.38317 18.3334 6.50817 18.3334H13.4915C16.5248 18.3334 18.3332 16.5251 18.3332 13.4917V6.47508C18.0915 6.60842 17.8082 6.66675 17.4748 6.66675Z"
                                    fill="#7D7B8D"/>
                            </svg>
                            <p class="desc">@lang('demo_project.popup_create_project_placeholder_image')</p>
                            <input name="image" type="file" class="inp">
                        </div>
                        <textarea name="description" class="default_textarea" rows="5"
                                  placeholder="Описание">@if($item_project->description){!! $item_project->description !!}@endif</textarea>
                        <button type="submit" class="submit_button">@lang('demo_project.popup_button_save')</button>
                    </form>
                </div>
            @endpush
        @endforeach
    @endif
    <main class="dashboard_content dashboard_content-norightsidebar">

        <div class="mx_title_split">
            <div class="mx_title">
                <h2 class="ttl">@lang('demo_project.table_name')</h2>
                <p class="desc">@lang('demo_project.table_name_desc')</p>
            </div>
            <div class="mx_buttons">
                @can('demo_project_crud')
                    <button class="mx_button mx_button_act-openmodalwindow" target_modal_id="modal_create_demo_project">
                        @lang('demo_project.button_create')
                    </button>
                @endcan
                <button class="mx_button mx_button_act-openmodalwindow"
                        target_modal_id="modal_create_request_demo_project">@lang('demo_project.button_create_request')
                </button>
                <a href="{{ route('request_demo_project.index') }}">
                    <button class="mx_button">@lang('demo_project.button_view_request')</button>
                </a>
            </div>
        </div>


        <div class="dash_list dash_list-create_demo_project">
            <div class="row row-title">
                <div class="cell">
                    @lang('demo_project.table_id')
                </div>
                <div class="cell">
                    @lang('demo_project.table_photo')
                </div>
                <div class="cell">
                    @lang('demo_project.table_name_demo')
                </div>
                <div class="cell">
                    @lang('demo_project.table_desc')
                </div>
                <div class="cell">

                </div>
            </div>
            @if($demo_project)
                @foreach($demo_project as $item_project)
                    <div class="row">
                        <div class="cell">
                            {{ $item_project->id }}
                        </div>
                        <div class="cell">
                            <div class="dash_inlineimage">
                                <img loading="lazy" src="{{ asset($item_project->image) }}">
                            </div>
                        </div>
                        <div class="cell">
                            {{ Str::limit($item_project->name, 30, ' ...') }}
                        </div>
                        <div class="cell">
                            {!! Str::limit($item_project->description, 50, ' ...') !!}
                        </div>
                        <div class="cell">
                            <div class="inline_mx_buttons">
                                <button class="mx_button mx_button_act-openmodalwindow"
                                        target_modal_id="modal_full_view_demo_project-{{ $item_project->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                         viewBox="0 0 18 18" fill="none">
                                        <path
                                            d="M15.9375 6.86251C14.205 4.14001 11.67 2.57251 9 2.57251C7.665 2.57251 6.3675 2.96251 5.1825 3.69001C3.9975 4.42501 2.9325 5.49751 2.0625 6.86251C1.3125 8.04001 1.3125 9.95251 2.0625 11.13C3.795 13.86 6.33 15.42 9 15.42C10.335 15.42 11.6325 15.03 12.8175 14.3025C14.0025 13.5675 15.0675 12.495 15.9375 11.13C16.6875 9.96001 16.6875 8.04001 15.9375 6.86251ZM9 12.03C7.32 12.03 5.97 10.6725 5.97 9.00001C5.97 7.32751 7.32 5.97001 9 5.97001C10.68 5.97001 12.03 7.32751 12.03 9.00001C12.03 10.6725 10.68 12.03 9 12.03Z"
                                            fill="white"/>
                                        <path
                                            d="M8.99981 6.85498C7.82231 6.85498 6.8623 7.81498 6.8623 8.99998C6.8623 10.1775 7.82231 11.1375 8.99981 11.1375C10.1773 11.1375 11.1448 10.1775 11.1448 8.99998C11.1448 7.82248 10.1773 6.85498 8.99981 6.85498Z"
                                            fill="white"/>
                                    </svg>
                                </button>
                                @can('demo_project_crud')
                                <button class="mx_button mx_button_act-openmodalwindow"
                                        target_modal_id="modal_full_edit_demo_project-{{ $item_project->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         viewBox="0 0 512 512" fill="none">
                                        <path d="M192 320l64-32 224-224-32-32-224 224-32 64zM144.65 433.549c-15.816-33.364-32.833-50.381-66.198-66.197l49.548-136.396 64-38.956 192-192h-96l-192 192-96 320 320-96 192-192v-96l-192 192-38.956 64z" fill="white"/>
                                    </svg>
                                </button>
                                @endcan
                                <a href="https://t.me/PorscheCrypto_bot">
                                    <button>@lang('demo_project.button_view_telegram_request')</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>
@endsection
@section('footer')

@endsection
