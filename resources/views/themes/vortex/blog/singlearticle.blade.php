@extends('themes.vortex.blog.layout')

@section('postTitle')
    {{ $post->title }}
@endsection

@section('postDescriptionMeta')
    {{ $post->description }}
@endsection

@section('content')
    @include('themes.vortex.blog.partials.articles.content')
@endsection

@section('custom-css')
    {!! Html::style('assets/js/photo-swipe/photoswipe.css') !!}
    {!! Html::style('assets/js/photo-swipe/default-skin/default-skin.css') !!}
@endsection

@section('custom-javascript')
    {!! Html::script('themes/vortex/assets/js/app/comments.js') !!}
    {!! Html::script('themes/vortex/assets/js/app/social-share.js') !!}
    {!! Html::script('assets/js/photo-swipe/photoswipe.min.js') !!}
    {!! Html::script('assets/js/photo-swipe/photoswipe-ui-default.min.js') !!}
    {!! Html::script('assets/js/photo-swipe/app.js') !!}
@endsection