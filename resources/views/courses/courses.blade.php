@extends('courses.layouts.layout')

@section('title')
    {{ $siteMeta->title }} - Cursos online de programación
@endsection

@section('description')
    {{ $siteMeta->description }}
@endsection

@section('twitter_meta_tags')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $siteMeta->title }}">
    <meta name="twitter:description" content="{{ $siteMeta->description }}">
    <meta name="twitter:image" content="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl('images/geekytheory-twitter.jpg', false, true) }}">
@endsection

@section('content')
    <section class="container-fluid section-gray section-courses">
        @include('courses.partials.courses')
    </section>
@endsection
