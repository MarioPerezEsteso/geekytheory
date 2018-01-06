@extends('courses.layouts.layout')

@section('title')
{{ $siteMeta->title }} - Cursos online de programación
@endsection

@section('description')
{{ $siteMeta->description }}
@endsection

@section('content')
    <div class="jumbotron jumbotron-home background-home center-flex">
        <div class="container">
            <div class="row">
                @if (!isset($user))
                    <div class="col-lg-6 col-md-6 hidden-xs">
                        <h1 class="jumbotron-title">{{ trans('public.home_header') }}</h1>
                        <p>{{ trans('public.home_subheader') }}</p>
                    </div>
                    <div class="col-lg-5 col-lg-push-1 col-md-6">
                        @include('courses.partials.auth.register')
                    </div>
                @else
                    <div class="col-lg-6 col-md-6">
                        <h3 class="jumbotron-title">{{ trans('public.home_header') }}</h3>
                        <p>{{ trans('public.home_subheader') }}</p>
                    </div>
                    <div class="col-lg-5 col-lg-push-1 col-md-6 hidden-sm hidden-xs">
                        <img class="img-responsive" src="/images/terminal.png">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <section class="container-fluid section-gray">
        @include('courses.partials.courses')
    </section>

    @if (!isset($user) || (isset($user) && !$user['premium']))
        <section class="container-fluid section-pricing">
            @include('courses.partials.pricing')
        </section>
    @endif
@endsection
