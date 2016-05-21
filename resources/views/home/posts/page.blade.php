@extends('home.layout')

@section('title')
    {{ trans('home.edit_page') }}
@endsection

@section('pageTitle')
    {{ trans('home.edit_page') }}
@endsection

@section('pageDescription')
    {{ trans('home.edit_page_page_description') }}
@endsection

@section('content')
    @include('home.posts.partials.formPage')
@endsection

@section('custom-javascript')
    {!! Html::script('admin/assets/js/tinymce/tinymce.min.js') !!}
    {!! Html::script('admin/assets/js/post.js') !!}
@endsection