@extends('courses.layouts.layout')

@section('title')
    {{ $course->title }} - {{ $siteMeta->title }}
@endsection

@section('description')
{{ $course->description }}
@endsection

@section('twitter_meta_tags')
    @include('courses.partials.twitterMetaTags')
@endsection

@section('content')

    @if(isset($errors) && $errors->has('subscription_error'))
        @include('courses.partials.lesson.headerGoPremium')
    @else
        @include('courses.partials.course.headerJoinCourse')
    @endif

    <section class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-sm-12">
                <div class="clearfix content-heading">
                    <img class="pull-left title-img-header" src="/assets/vendor/flat-ui/img/icons/svg/book.svg"/>
                    <h3>Contenido</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-sm-12">
                @include('courses.partials.courseContent')
            </div>
        </div>
    </section>

    @if (!isset($user) || (isset($user) && !$user['premium']))
        <section class="container-fluid section-pricing">
            @include('courses.partials.pricing')
        </section>
    @endif
@endsection