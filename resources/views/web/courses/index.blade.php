<!DOCTYPE html>
<html>
@include('web.layouts.head')
<body>
<!-- MAIN WRAPPER -->
<div class="body-wrap">
    <div id="st-container" class="st-container">
        <div class="st-pusher">
            <div class="st-content">
                <div class="st-content-inner">
                    <!-- Header -->
                    <div class="header">
                        <!-- Navbar -->
                        <nav class="navbar navbar-expand-lg navbar--bold  navbar-transparent navbar-inverse bg-dark ">
                            <div class="container navbar-container">
                                <!-- Brand/Logo -->
                                <a class="navbar-brand" href="https://preview.webpixels.io/boomerang-v3.6/index.html">
                                    <img src="../../assets/images/logo/logo-1-a.png" class="d-none d-lg-inline-block"
                                         alt="Boomerang">
                                    <img src="../../assets/images/logo/logo-1-a.png" class="d-lg-none" alt="Boomerang">
                                </a>

                                <div class="d-inline-block">
                                    <!-- Navbar toggler  -->
                                    <button class="navbar-toggler hamburger hamburger-js hamburger--spring"
                                            type="button" data-toggle="collapse" data-target="#navbar_main"
                                            aria-controls="navbarsExampleDefault" aria-expanded="false"
                                            aria-label="Toggle navigation">
                                        <span class="hamburger-box">
                                            <span class="hamburger-inner"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="collapse navbar-collapse align-items-center justify-content-end"
                                     id="navbar_main">
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="blog.html#" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">Home</a>

                                            <ul class="dropdown-menu">
                                                <li class="dropdown">
                                                    <a href="index.html" class="dropdown-item" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">Homepage</a>
                                                    <a href="homepage-video.html" class="dropdown-item"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">Homepage: Video</a>
                                                    <a href="homepage-image.html" class="dropdown-item"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">Homepage: Image</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a href="pricing.html" class="nav-link">Pricing</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a href="blog.html" class="nav-link">Blog</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a href="contact.html" class="nav-link">Contact</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="https://preview.webpixels.io/boomerang-v3.6/demos.html"
                                               class="nav-link">Demos</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="pl-4 d-none d-lg-inline-block">
                                    <a href="https://goo.gl/9BbH7R"
                                       class="btn btn-styled btn-sm btn-base-5 text-uppercase btn-circle">
                                        Purchase now
                                        <span class="badge badge-pill bg-base-1">$23 USD</span> </a>
                                </div>
                            </div>
                        </nav>
                    </div>

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
                                                        <div class="col-4">
                                                            <img src="https://d2eip9sf3oo6c2.cloudfront.net/tags/images/000/000/026/thumb/react.png"
                                                                 alt="icon for Test React Components with Enzyme and Jest"
                                                                 class="mr2" style="height: 24px; width: 24px;">
                                                        </div>
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
                    @include('web.partials.footer')
                </div>
            </div>
        </div><!-- END: st-pusher -->
    </div><!-- END: st-container -->
</div><!-- END: body-wrap -->

<!-- SCRIPTS -->
<a href="blog.html#" class="back-to-top btn-back-to-top"></a>

<!-- Core -->
<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/vendor/popper/popper.min.js"></script>
<script src="../../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../assets/js/slidebar/slidebar.js"></script>
<script src="../../assets/js/classie.js"></script>

<!-- Bootstrap Extensions -->
<script src="../../assets/vendor/bootstrap-notify/bootstrap-growl.min.js"></script>
<script src="../../assets/vendor/scrollpos-styler/scrollpos-styler.js"></script>

<!-- Plugins: Sorted A-Z -->
<script src="../../assets/vendor/adaptive-backgrounds/adaptive-backgrounds.js"></script>
<script src="../../assets/vendor/countdown/js/jquery.countdown.min.js"></script>
<script src="../../assets/vendor/dropzone/dropzone.min.js"></script>
<script src="../../assets/vendor/easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="../../assets/vendor/fancybox/js/jquery.fancybox.min.js"></script>
<script src="../../assets/vendor/flatpickr/flatpickr.min.js"></script>
<script src="../../assets/vendor/flip/flip.min.js"></script>
<script src="../../assets/vendor/footer-reveal/footer-reveal.min.js"></script>
<script src="../../assets/vendor/gradientify/jquery.gradientify.min.js"></script>
<script src="../../assets/vendor/headroom/headroom.min.js"></script>
<script src="../../assets/vendor/headroom/jquery.headroom.min.js"></script>
<script src="../../assets/vendor/input-mask/input-mask.min.js"></script>
<script src="../../assets/vendor/instafeed/instafeed.js"></script>
<script src="../../assets/vendor/milestone-counter/jquery.countTo.js"></script>
<script src="../../assets/vendor/nouislider/js/nouislider.min.js"></script>
<script src="../../assets/vendor/paraxify/paraxify.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.min.js"></script>
<script src="../../assets/vendor/sticky-kit/sticky-kit.min.js"></script>
<script src="../../assets/vendor/swiper/js/swiper.min.js"></script>
<script src="../../assets/vendor/textarea-autosize/autosize.min.js"></script>
<script src="../../assets/vendor/typeahead/typeahead.bundle.min.js"></script>
<script src="../../assets/vendor/typed/typed.min.js"></script>
<script src="../../assets/vendor/vide/vide.min.js"></script>
<script src="../../assets/vendor/viewport-checker/viewportchecker.min.js"></script>
<script src="../../assets/vendor/wow/wow.min.js"></script>

<!-- Isotope -->
<script src="../../assets/vendor/isotope/isotope.min.js"></script>
<script src="../../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->


<!-- App JS -->
<script src="../../assets/js/app.min.js"></script>

</body>
</html>
