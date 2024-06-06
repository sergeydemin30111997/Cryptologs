@extends('template.app')

@section('title', __('dashboard.title'))

@section('header')

@endsection

@section('content')
    <main class="dashboard_content dashboard_content-norightsidebar">
        <div class="mx_title_split">
            <div class="mx_title">
                <h2 class="ttl">{{ __('dashboard.stats_main') }}</h2>
                <p class="desc">{{ __('dashboard.stats_desc') }}</p>
            </div>
            @can('view_users')
                <div class="mx_buttons">
                    <a href="{{ route('dashboard.all', $all = 'all') }}">
                        <button class="mx_button">
                            {{ __('dashboard.all_stats') }}
                        </button>
                    </a>
                </div>
            @endcan
        </div>
        @if(!$projectLogUser)
        <div style="display: none;" class="timer">
            <div style="color: red;">[days] : [hours] : [mins] : [secs] - Важная информация! После регистрации у вас 24 часа на добавление хотя бы одного лога. Иначе вы будете забанены автоматически нашей системой</div>
        </div>
        @endif
        <section class="charts_displays">
            <article class="chart_display">
                <p class="updated_time">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14">
                        <path
                            d="M7.00008 1.16663C3.78591 1.16663 1.16675 3.78579 1.16675 6.99996C1.16675 10.2141 3.78591 12.8333 7.00008 12.8333C10.2142 12.8333 12.8334 10.2141 12.8334 6.99996C12.8334 3.78579 10.2142 1.16663 7.00008 1.16663ZM9.53758 9.08246C9.45592 9.22246 9.31008 9.29829 9.15842 9.29829C9.08258 9.29829 9.00675 9.28079 8.93675 9.23413L7.12842 8.15496C6.67925 7.88663 6.34675 7.29746 6.34675 6.77829V4.38663C6.34675 4.14746 6.54508 3.94913 6.78425 3.94913C7.02342 3.94913 7.22175 4.14746 7.22175 4.38663V6.77829C7.22175 6.98829 7.39675 7.29746 7.57758 7.40246L9.38592 8.48163C9.59592 8.60413 9.66592 8.87246 9.53758 9.08246Z"/>
                    </svg>
                    updated
                </p>
                <h2 class="ttl">{{ __('dashboard.stats_day') }}</h2>
                <div class="jscanvas_cn">
                    <div class="jscanvas">
                        <canvas id="logcharts_30days"></canvas>
                    </div>
                </div>
            </article>
            <article class="chart_display">
                <p class="updated_time">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14">
                        <path
                            d="M7.00008 1.16663C3.78591 1.16663 1.16675 3.78579 1.16675 6.99996C1.16675 10.2141 3.78591 12.8333 7.00008 12.8333C10.2142 12.8333 12.8334 10.2141 12.8334 6.99996C12.8334 3.78579 10.2142 1.16663 7.00008 1.16663ZM9.53758 9.08246C9.45592 9.22246 9.31008 9.29829 9.15842 9.29829C9.08258 9.29829 9.00675 9.28079 8.93675 9.23413L7.12842 8.15496C6.67925 7.88663 6.34675 7.29746 6.34675 6.77829V4.38663C6.34675 4.14746 6.54508 3.94913 6.78425 3.94913C7.02342 3.94913 7.22175 4.14746 7.22175 4.38663V6.77829C7.22175 6.98829 7.39675 7.29746 7.57758 7.40246L9.38592 8.48163C9.59592 8.60413 9.66592 8.87246 9.53758 9.08246Z"/>
                    </svg>
                    updated
                </p>
                <h2 class="ttl">{{ __('dashboard.stats_country') }}</h2>
                <div class="jscanvas_cn">
                    <div class="jscanvas">
                        <canvas id="logcharts_country"></canvas>
                    </div>
                </div>
            </article>
            <article class="chart_display">
                <p class="updated_time">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14">
                        <path
                            d="M7.00008 1.16663C3.78591 1.16663 1.16675 3.78579 1.16675 6.99996C1.16675 10.2141 3.78591 12.8333 7.00008 12.8333C10.2142 12.8333 12.8334 10.2141 12.8334 6.99996C12.8334 3.78579 10.2142 1.16663 7.00008 1.16663ZM9.53758 9.08246C9.45592 9.22246 9.31008 9.29829 9.15842 9.29829C9.08258 9.29829 9.00675 9.28079 8.93675 9.23413L7.12842 8.15496C6.67925 7.88663 6.34675 7.29746 6.34675 6.77829V4.38663C6.34675 4.14746 6.54508 3.94913 6.78425 3.94913C7.02342 3.94913 7.22175 4.14746 7.22175 4.38663V6.77829C7.22175 6.98829 7.39675 7.29746 7.57758 7.40246L9.38592 8.48163C9.59592 8.60413 9.66592 8.87246 9.53758 9.08246Z"/>
                    </svg>
                    updated
                </p>
                <h2 class="ttl">{{ __('dashboard.stats_months') }}</h2>
                <div class="jscanvas_cn">
                    <div class="jscanvas">
                        <canvas id="logcharts_yearlogs"></canvas>
                    </div>
                </div>
            </article>
        </section>
        <section class="main_statistics_displays">
            <article class="display">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M20.5 10.19H17.61C15.24 10.19 13.31 8.26 13.31 5.89V3C13.31 2.45 12.86 2 12.31 2H8.07C4.99 2 2.5 4 2.5 7.57V16.43C2.5 20 4.99 22 8.07 22H15.93C19.01 22 21.5 20 21.5 16.43V11.19C21.5 10.64 21.05 10.19 20.5 10.19Z"/>
                        <path
                            d="M15.7999 2.20999C15.3899 1.79999 14.6799 2.07999 14.6799 2.64999V6.13999C14.6799 7.59999 15.9199 8.80999 17.4299 8.80999C18.3799 8.81999 19.6999 8.81999 20.8299 8.81999C21.3999 8.81999 21.6999 8.14999 21.2999 7.74999C19.8599 6.29999 17.2799 3.68999 15.7999 2.20999Z"/>
                    </svg>
                </div>
                <div class="txt">
                    <h4 class="ttl">{{ __('dashboard.all_logs') }}</h4>
                    <p class="val">{{ $projectLogCountUser }}</p>
                </div>
            </article>
            <article class="display">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M22 10.97V13.03C22 13.58 21.56 14.03 21 14.05H19.04C17.96 14.05 16.97 13.26 16.88 12.18C16.82 11.55 17.06 10.96 17.48 10.55C17.85 10.17 18.36 9.94995 18.92 9.94995H21C21.56 9.96995 22 10.42 22 10.97Z"/>
                        <path
                            d="M20.47 15.55H19.04C17.14 15.55 15.54 14.12 15.38 12.3C15.29 11.26 15.67 10.22 16.43 9.48C17.07 8.82 17.96 8.45 18.92 8.45H20.47C20.76 8.45 21 8.21 20.97 7.92C20.75 5.49 19.14 3.83 16.75 3.55C16.51 3.51 16.26 3.5 16 3.5H7C6.72 3.5 6.45 3.52 6.19 3.56C3.64 3.88 2 5.78 2 8.5V15.5C2 18.26 4.24 20.5 7 20.5H16C18.8 20.5 20.73 18.75 20.97 16.08C21 15.79 20.76 15.55 20.47 15.55ZM13 9.75H7C6.59 9.75 6.25 9.41 6.25 9C6.25 8.59 6.59 8.25 7 8.25H13C13.41 8.25 13.75 8.59 13.75 9C13.75 9.41 13.41 9.75 13 9.75Z"/>
                    </svg>
                </div>
                <div class="txt">
                    <h4 class="ttl">{{ __('dashboard.balance') }}</h4>
                    <p class="val">${{ $dashboard_user->balance }}</p>
                </div>
            </article>
        </section>
        <br>
        <div class="mx_title">
            <h2 class="ttl">{{ __('dashboard.logs_main') }}</h2>
            <p class="desc">{{ __('dashboard.logs_desc') }}</p>
        </div>
        <div class="dash_list">
            <div class="row row-title">
                <div class="cell">
                    @lang('dashboard.table_domain')
                </div>
                <div class="cell">
                    @lang('dashboard.table_device')
                </div>
                <div class="cell">
                    @lang('dashboard.table_ip')
                </div>
                <div class="cell">
                    @lang('dashboard.table_city')
                </div>
            </div>
            @if($projectLogUser)
                @foreach($projectLogUser as $item)
                    <div class="row">
                        <div class="cell">
                            {{ $item->domain }}
                        </div>
                        <div class="cell">
                            {{ $item->user_agent }}
                        </div>
                        <div class="cell">
                            {{ $item->user_ip }}
                        </div>
                        <div class="cell">
                            {{ $item->country }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>
@endsection
@section('footer')
    @push('logCharts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
        <script>

            var logcharts30days = new Chart(document.getElementById('logcharts_30days').getContext('2d'), {
                type: "line",
                data: {
                    labels: [@if($statsLogDays) @foreach($statsLogDays as $key => $itemStats)'{{ $key }}', @endforeach @else 'Нет статистики', @endif],
                    datasets: [{
                        data: [
                                @if($statsLogDays)
                                @foreach($statsLogDays as $key => $itemStats)
                                @if(!isset($counter))
                                @php $counter = 1 @endphp
                                @else
                                @php $counter++ @endphp
                                @endif
                            {
                                x: {{ $counter }}, y: {{ $itemStats }}
                            },
                            @endforeach
                                @else
                                0
                            @endif
                        ],
                        fill: false,
                        borderColor: "#fff",
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderColor: "#7D7B8D",
                                borderDash: [5],
                                borderDashOffset: 5
                            }
                        },
                        x: {
                            grid: {
                                borderColor: "#7D7B8D",
                                borderDash: [5],
                                borderDashOffset: 5
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                },
            });
        </script>
        <script>
            var logcharts_country = new Chart(document.getElementById('logcharts_country').getContext('2d'), {
                type: "bar",
                data: {
                    labels: [@if($statsLogCountry) @foreach($statsLogCountry as $key => $itemStats)'{{ $key }}', @endforeach @else 'Нет статистики', @endif],
                    datasets: [{
                        data: [
                                @if($statsLogCountry)
                                @foreach($statsLogCountry as $key => $itemStats)
                                @if(!isset($counter))
                                @php $counter = 1 @endphp
                                @else
                                @php $counter++ @endphp
                                @endif
                            {
                                x: {{ $counter }}, y: {{ $itemStats }}
                            },
                            @endforeach
                                @else
                                0
                            @endif
                        ],
                        fill: false,
                        borderColor: "#fff",
                        backgroundColor: "#fff",
                        barPercentage: 0.4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderColor: "#7D7B8D",
                                borderDash: [5],
                                borderDashOffset: 5
                            }
                        },
                        x: {
                            grid: {
                                borderColor: "#7D7B8D",
                                borderDash: [5],
                                borderDashOffset: 5
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                },
            });
        </script>
        <script>
            var logcharts_country = new Chart(document.getElementById('logcharts_yearlogs').getContext('2d'), {
                type: "line",
                data: {
                    labels: [@if($statsLogMonth) @foreach($statsLogMonth as $key => $itemStats)'{{ $key }}', @endforeach @else 'Нет статистики', @endif],
                    datasets: [{
                        data: [
                                @if($statsLogMonth)
                                @foreach($statsLogMonth as $key => $itemStats)
                                @if(!isset($counter))
                                @php $counter = 1 @endphp
                                @else
                                @php $counter++ @endphp
                                @endif
                            {
                                x: {{ $counter }}, y: {{ $itemStats }}
                            },
                            @endforeach
                                @else
                                0
                            @endif
                        ],
                        fill: false,
                        borderColor: "#fff",
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderColor: "#7D7B8D",
                                borderDash: [5],
                                borderDashOffset: 5
                            }
                        },
                        x: {
                            grid: {
                                borderColor: "#7D7B8D",
                                borderDash: [5],
                                borderDashOffset: 5
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                },
            });
        </script>
    @endpush
    @if(Route::is('dashboard'))
        @push('timerUser')
        @php $dashboard_user->created_at = $dashboard_user->created_at->add(1, 'Days'); @endphp
        <script src="{{ asset('js/DPTimerCookie.js') }}"></script>
        <script>
            var timer = new DPTimerCookie({
                htmlLayouts: [ // масив контейнеров версток таймера на странице которые определены в html
                    {
                        selector: ".timer",
                        display: "block" // применится ко всем контейнерам найденым по селектору
                    }
                ],
                // Время сеществования куков
                lifeDurationCookieDays: 0,
                //cookieIdForTimer - если изменить то таймеры гарантировано
                //стартуют заново для всех пользователей
                cookieIdForTimer: "id11",

                timers: [
                    {
                        duration: { // Период времени. (счет начнется с первого захода на страницу)
                            days:
                            {{ $dashboard_user->created_at->diff(\Carbon\Carbon::now())->format('%d') }},
                            hours:
                            {{ $dashboard_user->created_at->diff(\Carbon\Carbon::now())->format('%H') }},
                            minutes:
                            {{ $dashboard_user->created_at->diff(\Carbon\Carbon::now())->format('%i') }},
                            seconds:
                            {{ $dashboard_user->created_at->diff(\Carbon\Carbon::now())->format('%s') }},
                        },
                        timerStarted: function () {
                            console.log("");
                        },
                        timerFinished: function () {
                            console.log("");
                        }
                    },
                    {
                        duration: { // Период времени. (счет начнется по окончанию (таймер 1))
                            days:
                            {{ $dashboard_user->created_at->diff(\Carbon\Carbon::now())->format('%d') }},
                            hours:
                            {{ $dashboard_user->created_at->diff(\Carbon\Carbon::now())->format('%H') }},
                            minutes:
                            {{ $dashboard_user->created_at->diff(\Carbon\Carbon::now())->format('%i') }},
                            seconds:
                            {{ $dashboard_user->created_at->diff(\Carbon\Carbon::now())->format('%s') }},
                        },
                        timerStarted: function () {
                            console.log("");
                        },
                        timerFinished: function () {
                            console.log("");
                        }
                    }
                    // ... любое количество промежутков
                ]
            });
            timer.start();
        </script>
    @endpush
    @endif
@endsection

