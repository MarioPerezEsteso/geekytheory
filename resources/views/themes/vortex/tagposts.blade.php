@extends('themes.vortex.layout')

@section('content')

@include('themes.vortex.partials.index.tagpostshero', array('$tag', $tag))

@include('themes.vortex.partials.index.postlist')

@endsection