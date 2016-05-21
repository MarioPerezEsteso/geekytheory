@extends('home.layout')

@section('title')
    {{ trans('home.edit_post') }}
@endsection

@section('pageTitle')
    {{ trans('home.edit_post') }}
@endsection

@section('pageDescription')
    {{ trans('home.edit_post_page_description') }}
@endsection

@section('content')
    @include('home.posts.partials.formArticle')
@endsection

@section('custom-javascript')
    {!! Html::script('admin/assets/js/tinymce/tinymce.min.js') !!}
    {!! Html::script('admin/assets/js/post.js') !!}
@endsection