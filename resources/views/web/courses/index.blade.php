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

            @include('web.courses.partials.list', ['courses' => $premiumCourses])

        </div>
    </section>

    <section class="slice-sm sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center">
                <h3 class="section-title-inner text-normal strong-500">
                    <span>Cursos gratuitos</span>
                </h3>
            </div>

            @include('web.courses.partials.list', ['courses' => $freeCourses])

        </div>
    </section>

    <section class="slice-sm sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center">
                <h3 class="section-title-inner text-normal strong-500">
                    <span>Cursos que estamos preparando</span>
                </h3>
            </div>

            @include('web.courses.partials.list', ['courses' => $scheduledCourses])

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