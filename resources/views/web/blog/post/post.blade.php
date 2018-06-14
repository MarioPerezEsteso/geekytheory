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

                    <section class="slice--offset-top bg-base-2 holder-item holder-item-dark"></section>

                    <section class="parallax-section parallax-section-xl sct-color-3 has-bg-cover bg-size-cover"
                             style="background-image: url('{{ $post->image }}'); background-position: center center;">
                        <span class="mask mask-dark--style-4"></span>
                        <div class="container sct-inner">
                            <div class="">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h3 class="heading heading-1 strong-400 c-white">
                                            {{ $post->title }}
                                        </h3>
                                        <h4 class="heading heading-5 text-normal strong-300 c-white mt-4">
                                            {{ $post->description }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="slice-sm sct-color-1">
                        <div class="container container-xs">
                            <div class="block block-post">
                                <div class="block-body block-post-body">
                                    {!! $post->body !!}
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
<script src="../../assets/vendor/highlightjs/js/highlight.pack.js"></script>
<script src="../../assets/vendor/highlightjs/js/highlight-pre-blocks.js"></script>

<!-- Isotope -->
<script src="../../assets/vendor/isotope/isotope.min.js"></script>
<script src="../../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>

<!-- App JS -->
<script src="../../assets/js/app.min.js"></script>

</body>
</html>
