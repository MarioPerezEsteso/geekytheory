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

    @include('web.partials.gopremiumsquare')

@endsection