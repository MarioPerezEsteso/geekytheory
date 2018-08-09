@extends('web.layouts.layout')

@section('content')
    <section class="slice--offset-top bg-base-2 holder-item holder-item-dark"></section>

    <section class="slice-lg slice--offset-top">
        <span class="mask"></span>
        <div class="container d-flex align-items-center">
            <div class="row cols-xs-space cols-sm-space cols-md-space align-items-center">
                <div class="col-lg-5 ml-lg-auto order-lg-2 text-center text-lg-left">
                    <h2 class="heading heading-1 strong-400 animated animation-ended" data-animation-in="fadeInUp"
                        data-animation-delay="200">
                        {{ $course->title }}
                    </h2>
                    <p class="lead mt-4 animated animation-ended" data-animation-in="fadeInUp"
                       data-animation-delay="600">
                        {{ $course->description }}
                    </p>
                    <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $course->chapters->first()->lessons->first()->slug]) }}"
                       class="btn btn-styled btn-mint btn-circle mt-4 animated animation-ended"
                       data-animation-in="fadeInUp" data-animation-delay="1200">
                        Ir al primer video
                    </a>
                </div>

                <div class="col-lg-6 order-lg-1">
                    <div class="block block-image-holder z-depth-3 animated animation-ended" data-animation-in="fadeIn"
                         data-animation-delay="200">
                        <div class="block-image">
                            <img src="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($course->image) }}"
                                 class="img-center">
                            <a href="https://vimeo.com/274365088" data-fancybox="">
                                {{--<a href="{{ $course->video_presentation }}" data-fancybox="">--}}
                                <span class="play-video play-video-sm play-video-top-left">
                                    <i class="fa fa-play"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container h-100">
        <div class="row">
            <div class="col-lg-12">
                <div class="block block--style-3 list z-depth-2-top course-content-container">
                    @foreach($course->chapters as $chapter)
                        <div class="block-footer border-top">
                            <div class="row h-100">
                                <div class="col">
                                    <h4 class="heading heading-md my-auto">{{ $chapter->title }}</h4>
                                </div>
                            </div>
                        </div>
                        <?php $lessonIndex = 1; ?>
                        @foreach($chapter->lessons as $lesson)
                            <div class="block-footer border-top">
                                <div class="row h-100">
                                    <div class="col-lg-9 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-1 col-sm-2 my-auto">
                                                @if (!is_null($lesson->icon))
                                                    <img src="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($lesson->icon, false, true) }}"/>
                                                    @if ($lesson->completed === true)
                                                        <i class="lesson-completed-icon lesson-completed-icon-over-icon fa fa-check-circle"></i>
                                                    @endif
                                                @else
                                                    @if ($lesson->completed === true)
                                                        <i class="lesson-completed-icon fa fa-check-circle"></i>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-lg-11 col-sm-10 my-auto">
                                                <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug]) }}"
                                                   class="lesson-link">
                                                    {{ $chapter->order }}.{{ $lessonIndex++ }}. {{ $lesson->title }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 d-none d-sm-block text-right my-auto">
                                        <div class="lesson-info-time">
                                            <i class="fa fa-clock-o"></i>
                                            {{ formatSeconds($lesson->duration) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-css')
@endsection

@section('custom-javascript')
@endsection