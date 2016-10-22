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

@section('custom-javascript')
    {!! Html::script('themes/vortex/assets/js/app/comments.js') !!}
@endsection