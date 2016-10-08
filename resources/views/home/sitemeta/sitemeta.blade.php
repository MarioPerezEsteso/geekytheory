@extends('home.layout')

@section('title')
    {{ trans('home.site_options') }}
@endsection

@section('pageTitle')
    {{ trans('home.site_options') }}
@endsection

@section('pageDescription')
    {{ trans('home.site_options_page_description') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-sm-12 col-lg-6">
            @include('home.posts.partials.formMessages')
            {!! Form::model($siteMeta, ['url' => 'home/sitemeta/update', 'class' => 'form', 'files' => true]) !!}
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#options" data-toggle="tab" aria-expanded="true">{{ trans('home.options') }}</a>
                    </li>
                    <li class="">
                        <a href="#images" data-toggle="tab" aria-expanded="false">{{ trans('home.images') }}</a>
                    </li>
                    <li class="">
                        <a href="#social-networks" data-toggle="tab" aria-expanded="false">{{ trans('public.social-networks') }}</a>
                    </li>
                    <li class="">
                        <a href="#akismet" data-toggle="tab" aria-expanded="false">Akismet</a>
                    </li>
                    <li class="">
                        <a href="#analytics" data-toggle="tab" aria-expanded="false">Analytics</a>
                    </li>
                    <li class="">
                        <a href="#adsense-code" data-toggle="tab" aria-expanded="false">Adsense</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="options">
                        @include('home.sitemeta.tab-options')
                    </div>
                    <div class="tab-pane" id="images">
                        @include('home.sitemeta.tab-images')
                    </div>
                    <div class="tab-pane" id="social-networks">
                        @include('home.sitemeta.tab-socialnetworks')
                    </div>
                    <div class="tab-pane" id="akismet">
                        @include('home.sitemeta.tab-akismet')
                    </div>
                    <div class="tab-pane" id="analytics">
                        @include('home.sitemeta.tab-analytics')
                    </div>
                    <div class="tab-pane" id="adsense-code">
                        @include('home.sitemeta.tab-adsense')
                    </div>
                </div>
            </div>
            <div>
                {!! Form::submit(trans('home.save'),['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('custom-javascript')
    {!! Html::script('admin/assets/js/sitemeta.js') !!}
@endsection