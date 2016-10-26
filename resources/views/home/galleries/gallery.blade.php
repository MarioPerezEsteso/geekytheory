@extends('home.layout')

@section('title')
    {{ trans('home.new_gallery') }}
@endsection

@section('pageTitle')
    {{ trans('home.new_gallery') }}
@endsection

@section('pageDescription')
    {{ trans('home.new_gallery_page_description') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-sm-12 col-lg-6">
            @include('home.posts.partials.formMessages')
            {!! Form::model($siteMeta, ['url' => 'home/sitemeta/update', 'class' => 'form', 'files' => true]) !!}
            <div>
                {!! Form::submit(trans('home.save'),['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('custom-javascript')
@endsection