@extends('themes.vortex.layout')

@section('title')
    {{ $siteMeta->title }}
@endsection

@section('content')
    @include('themes.vortex.partials.hero')
    @include('themes.vortex.partials.index.postlist')
@endsection