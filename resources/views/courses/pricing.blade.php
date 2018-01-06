@extends('courses.layouts.layout')

@section('title')
    Planes - {{ $siteMeta->title }}
@endsection

@section('description')
{{ trans('public.pricing_description') }}
@endsection

@section('content')
    <section class="container-fluid section-pricing section-pricing-mt-53">
        @include('courses.partials.pricing')
    </section>

    <section class="container-fluid section-testimonials">
        @include('courses.partials.pricing.testimonials')
    </section>

    <section class="container-fluid section-faq">
        @include('courses.partials.pricing.faq')
    </section>
@endsection