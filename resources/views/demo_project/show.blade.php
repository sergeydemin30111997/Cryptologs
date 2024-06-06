@extends('template.app')

@section('title', 'Демо-проекты')

@section('header')

@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                @if(Session::has('message'))
                    <div class="col-md-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{Session::get('message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                    <div class="col-md-8">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset($demo_project->image) }}" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">{{ $demo_project->name }}</h4>
                                <p class="card-description">{{ $demo_project->description }}</p>
                                <div class="row">
                                    <div class="col-md-3">@if($demo_project->url_project)<a href="{{ $demo_project->url_project }}" class="btn btn-primary">Посмотреть демо</a> @else <button type="button" class="btn btn-secondary" disabled>Демо сайт отсутствует</button> @endif</div>
                                    @can('demo_project_crud')
                                    <div class="col-md-3"><a href="{{ route('demo_project.edit', $demo_project->id) }}" class="btn btn-warning">Редактировать</a></div>
                                    <form method="POST" action="{{ route('demo_project.destroy', $demo_project->id) }}">
                                        @csrf
                                        @method('DELETE')
                                    <div class="col-md-5"><button type="submit" class="btn btn-danger">Удалить</button></div>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection
