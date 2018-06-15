@extends('web.layouts.layout')

@section('content')
    <section class="slice slice--offset-top bg-base-2 holder-item holder-item-dark">
        <div class="container container-sm d-flex align-items-center">
            <div class="col">
                <div class="row py-5 text-center justify-content-center">
                    <div class="col-12 col-md-10">
                        <h2 class="heading heading-2 c-white strong-600 mt-3 animated"
                            data-animation-in="fadeIn" data-animation-delay="400">
                            Cursos
                        </h2>
                        <span class="sd-1 sd-sm sd-thick-3px sd-center"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="slice-sm sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center">
                <h3 class="section-title-inner text-normal strong-500">
                    <span>Cursos Premium</span>
                </h3>
            </div>

            @foreach  ($premiumCourses->chunk(3) as $coursesChunk)
                <div class="row cols-md-space cols-sm-space cols-xs-space">
                    @foreach ($coursesChunk as $course)
                        <div class="col-lg-4">
                            <div class="card z-depth-2--hover">
                                <div class="card-image">
                                    <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                        <img src="{{ $course->image }}">
                                    </a>
                                </div>
                                <div class="progress" style="height: 2px;">
                                    <?php $percentageCompleted = $course->lessons_completed * 100 / $course->getTotalLessonsCount();?>
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ $percentageCompleted }}%;"
                                         aria-valuenow="{{ $percentageCompleted }}" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                            {{ $course->title }}
                                        </a>
                                    </h4>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <h6 class="heading heading-sm strong-400 text-muted mb-0">
                                                {{ formatSecondsToHoursAndMinutes($course->duration) }}
                                            </h6>
                                        </div>
                                        <div class="col-4 text-center">
                                            <i class="fa fa-lock text-muted" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-4 text-right">
                                            <h6 class="heading heading-sm strong-400 text-muted mb-0">
                                                @if (!is_null($course->lessons_completed) && $course->lessons_completed > 0)
                                                    {{ $course->lessons_completed }}
                                                    /{{ $course->getTotalLessonsCount() }} vistas
                                                @else
                                                    {{ $course->getTotalLessonsCount() }} lecciones
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <span class="space-xs-sm"></span>
            @endforeach
        </div>
    </section>

    <section class="slice-sm sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center">
                <h3 class="section-title-inner text-normal strong-500">
                    <span>Cursos gratuitos</span>
                </h3>
            </div>

            @foreach  ($freeCourses->chunk(3) as $coursesChunk)
                <div class="row cols-md-space cols-sm-space cols-xs-space">
                    @foreach ($coursesChunk as $course)
                        <div class="col-lg-4">
                            <div class="card z-depth-2--hover">
                                <div class="card-image">
                                    <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                        <img src="{{ $course->image }}">
                                    </a>
                                </div>
                                <div class="progress" style="height: 2px;">
                                    <?php $percentageCompleted = $course->lessons_completed * 100 / $course->getTotalLessonsCount();?>
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ $percentageCompleted }}%;"
                                         aria-valuenow="{{ $percentageCompleted }}" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                            {{ $course->title }}
                                        </a>
                                    </h4>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            {{ formatSecondsToHoursAndMinutes($course->duration) }}
                                        </div>
                                        <div class="col-4 text-center">
                                            <i class="fa fa-unlock text-muted" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-4 text-right">
                                            <h6 class="heading heading-sm strong-400 text-muted mb-0">
                                                @if (!is_null($course->lessons_completed) && $course->lessons_completed > 0)
                                                    {{ $course->lessons_completed }}
                                                    /{{ $course->getTotalLessonsCount() }} vistas
                                                @else
                                                    {{ $course->getTotalLessonsCount() }} lecciones
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <span class="space-xs-sm"></span>
            @endforeach
        </div>
    </section>

    <section class="slice-sm sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center">
                <h3 class="section-title-inner text-normal strong-500">
                    <span>Cursos que estamos preparando</span>
                </h3>
            </div>

            @foreach  ($scheduledCourses->chunk(3) as $coursesChunk)
                <div class="row cols-md-space cols-sm-space cols-xs-space">
                    @foreach ($coursesChunk as $course)
                        <div class="col-lg-4">
                            <div class="card z-depth-2--hover">
                                <div class="card-image">
                                    <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                        <img src="{{ $course->image }}">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                            {{ $course->title }}
                                        </a>
                                    </h4>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-4"></div>
                                        <div class="col-4 text-center">
                                            <i class="fa fa-lock text-muted" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <span class="space-xs-sm"></span>
            @endforeach
            <span class="space-xs-xl"></span>
        </div>
    </section>

    <section class="slice-xl sct-color-3" style="padding-top: 80px;">
        <div class="shape-container" data-shape-fill="sct-color-1" data-shape-style="opaque_waves_1"
             data-shape-position="top" style="height: 80px;">
            <svg class="shape-item" fill="#ffffff" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M 0 0 c 0 0 200 50 500 50 s 500 -50 500 -50 v 101 h -1000 v -100 z"></path>
            </svg>
        </div>

        <div class="container">
            <div class="cta-container cta-container-overlay">
                <div class="cta-block cta-block-overlay bg-base-1 z-depth-5 text-center">
                    <h2 class="heading heading-inverse heading-2 strong-500">
                        ¿Quieres aprender sin límites? Lo tuyo es Premium.
                    </h2>
                    <a href="#" class="btn btn-styled btn-lg btn-white btn-outline btn-circle mt-5">
                        Pásate a Premium
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection