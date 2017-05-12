@extends('themes.vortex.layout')

@section('title')
{{ $siteMeta->title }}
@endsection

@section('siteDescriptionMeta')
{{ $siteMeta->description }}
@endsection


@section('content')
    @include('themes.vortex.partials.hero-newsletter')
    @include('themes.vortex.partials.index.postlist')
@endsection