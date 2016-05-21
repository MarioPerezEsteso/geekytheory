@extends('themes.vortex.blog.layout')

@section('postTitle')
    {{ $post->title }}
@endsection

@section('content')
    @include('themes.vortex.blog.partials.articles.content')
@endsection