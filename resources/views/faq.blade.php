@extends('template.app')

@section('title', __('faq.title'))

@section('header')

@endsection

@section('content')
    <main class="dashboard_content dashboard_content-norightsidebar">
        <div class="mx_title_split">
            <div class="mx_title">
                <h2 class="ttl">{{ __('faq.stats_main') }}</h2>
                <p class="desc">{{ __('faq.stats_desc') }}</p>
            </div>
        </div>
        <br>
        <style>
        pre {
        white-space: pre-wrap;       /* css-3 */
        white-space: -moz-pre-wrap;  /* Mozilla, с 1999 года*/
        white-space: -pre-wrap;      /* Opera 4-6 */
        white-space: -o-pre-wrap;    /* Opera 7 */
        word-wrap: break-word;       /* Internet Explorer 5.5+ */
        }
        </style>
                <p class="ttl"><pre>{{ __('faq.text') }}</pre></p>
    </main>
@endsection
@section('footer')

@endsection
