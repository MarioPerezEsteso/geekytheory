<!DOCTYPE html>
<html>
@include('web.layouts.head')
<body>

<!-- MAIN WRAPPER -->
<div class="body-wrap">
    <div id="st-container" class="st-container">

        <nav class="st-menu st-effect-1" id="menu-1">
            <div class="st-profile">
                <div class="st-profile-user-wrapper">
                    <div class="profile-user-image">
                        <img src="../../assets/images/prv/people/person-1.jpg" class="img-circle"/>
                    </div>
                    <div class="profile-user-info">
                        <span class="profile-user-name">Bertram Ozzie</span>
                        <span class="profile-user-email">username@example.com</span>
                    </div>
                </div>
            </div>

            <div class="st-menu-list mt-2">
                <ul>
                    <li>
                        <a href="blog.html#">
                            <i class="ion-ios-bookmarks-outline"></i> Theme documentation
                        </a>
                    </li>
                    <li>
                        <a href="blog.html#">
                            <i class="ion-ios-cart-outline"></i> Purchase Tribus
                        </a>
                    </li>
                </ul>
            </div>

            <h3 class="st-menu-title">Account</h3>
            <div class="st-menu-list">
                <ul>
                    <li>
                        <a href="blog.html#">
                            <i class="ion-ios-person-outline"></i> User profile
                        </a>
                    </li>
                    <li>
                        <a href="blog.html#">
                            <i class="ion-ios-location-outline"></i> My addresses
                        </a>
                    </li>
                    <li>
                        <a href="blog.html#">
                            <i class="ion-card"></i> My cards
                        </a>
                    </li>
                    <li>
                        <a href="blog.html#">
                            <i class="ion-ios-unlocked-outline"></i> Password update
                        </a>
                    </li>
                </ul>
            </div>

            <h3 class="st-menu-title">Support center</h3>
            <div class="st-menu-list">
                <ul>
                    <li>
                        <a href="blog.html#">
                            <i class="ion-ios-information-outline"></i> About Tribus
                        </a>
                    </li>
                    <li>
                        <a href="blog.html#">
                            <i class="ion-ios-email-outline"></i> Contact &amp; support
                        </a>
                    </li>
                    <li>
                        <a href="blog.html#">
                            <i class="fa fa-camera"></i> Getting started
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="st-pusher">
            <div class="st-content">
                <div class="st-content-inner">
                    <!-- Header -->
                    <div class="header">
                        <!-- Top Bar -->

                        <!-- Global Search -->
                        <section id="sctGlobalSearch" class="global-search global-search-overlay">
                            <div class="container">
                                <div class="global-search-backdrop mask-dark--style-2"></div>

                                <!-- Search form -->
                                <form class="form-horizontal form-global-search z-depth-2-top" role="form">
                                    <div class="px-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" class="search-input"
                                                       placeholder="Type and hit enter ...">
                                            </div>
                                        </div>
                                    </div>
                                    <a href="blog.html#" class="close-search" data-toggle="global-search"
                                       title="Close search bar"></a>
                                </form>
                            </div>
                        </section>

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

                    @if ($articles->currentPage() == 1)
                        <section class="slice slice--offset-top bg-base-2 holder-item holder-item-dark">
                            <div class="container container-sm d-flex align-items-center">
                                <div class="col">
                                    <div class="row py-5 text-center justify-content-center">
                                        <div class="col-12 col-md-10">
                                            <h2 class="heading heading-2 c-white strong-600 mt-3 animated"
                                                data-animation-in="fadeIn" data-animation-delay="400">
                                                Nuestras últimas publicaciones
                                            </h2>
                                            <span class="sd-1 sd-sm sd-thick-3px sd-center"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @else
                        <section class="slice--offset-top bg-base-2 holder-item holder-item-dark"></section>
                    @endif

                    <section class="slice sct-color-1" id="sct_scroll_to">
                        <div class="container container-lg">
                            <div class="row-wrapper">
                                @for ($row = 0; $row < 4; $row++)
                                    <div class="row cols-xs-space cols-sm-space cols-md-space">
                                        @if ($row === 0)
                                            @for($index = 0; $index < 3; $index++)
                                                <?php $article = $articles->get($index); ?>
                                                <div class="col-lg-4">
                                                    @if ($index === 0 && !is_null($article))
                                                        @include('web.blog.postlist.partials.card-white', ['article' => $article])
                                                    @elseif($index === 1 && !is_null($article))
                                                        @include('web.blog.postlist.partials.card-colored', ['article' => $article])
                                                    @elseif($index === 2 && !is_null($article))
                                                        @include('web.blog.postlist.partials.card-image', ['article' => $article])
                                                    @endif
                                                </div>
                                            @endfor
                                        @elseif ($row === 1)
                                            @if (!is_null($articles->get(3)))
                                                <div class="col-lg-8">
                                                    @include('web.blog.postlist.partials.card-unfold-img-left', ['article' => $articles->get(3)])
                                                </div>
                                            @endif
                                            @if (!is_null($articles->get(4)))
                                                <div class="col-lg-4">
                                                    @include('web.blog.postlist.partials.card-image', ['article' => $articles->get(4)])
                                                </div>
                                            @endif
                                        @elseif ($row === 2)
                                            @if (!is_null($articles->get(5)))
                                                <div class="col-lg-4">
                                                    @include('web.blog.postlist.partials.card-image', ['article' => $articles->get(5)])
                                                </div>
                                            @endif
                                            @if (!is_null($articles->get(6)))
                                                <div class="col-lg-8">
                                                    @include('web.blog.postlist.partials.card-unfold-img-right', ['article' => $articles->get(6)])
                                                </div>
                                            @endif
                                        @else
                                            @if (!is_null($articles->get(7)))
                                                <div class="col-lg-4">
                                                    @include('web.blog.postlist.partials.card-white', ['article' => $articles->get(7)])
                                                </div>
                                            @endif
                                            @if (!is_null($articles->get(8)))
                                                <div class="col-lg-4">
                                                    @include('web.blog.postlist.partials.card-colored', ['article' => $articles->get(8)])
                                                </div>
                                            @endif
                                            @if (!is_null($articles->get(9)))
                                                <div class="col-lg-4">
                                                    @include('web.blog.postlist.partials.card-image', ['article' => $articles->get(9)])
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </section>
                    <!-- PAGINATION -->
                    <section class="slice sct-color-1" id="sct_scroll_to">

                        <div class="row cols-xs-space cols-sm-space cols-md-space">
                            <div class="col-md-12">
                                <nav>
                                    <?php
                                    // config
                                    $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
                                    ?>

                                    @if ($articles->lastPage() > 1)
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item {{ ($articles->currentPage() == 1) ? ' disabled' : '' }}">
                                                <a class="page-link" href="{{ $articles->url(1) }}">Primera</a>
                                            </li>
                                            @for ($i = 1; $i <= $articles->lastPage(); $i++)
                                                <?php
                                                $half_total_links = floor($link_limit / 2);
                                                $from = $articles->currentPage() - $half_total_links;
                                                $to = $articles->currentPage() + $half_total_links;
                                                if ($articles->currentPage() < $half_total_links) {
                                                    $to += $half_total_links - $articles->currentPage();
                                                }
                                                if ($articles->lastPage() - $articles->currentPage() < $half_total_links) {
                                                    $from -= $half_total_links - ($articles->lastPage() - $articles->currentPage()) - 1;
                                                }
                                                ?>
                                                @if ($from < $i && $i < $to)
                                                    <li class="page-item {{ ($articles->currentPage() == $i) ? ' active' : '' }}">
                                                        <a class="page-link" href="{{ $articles->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endif
                                            @endfor
                                            <li class="page-item {{ ($articles->currentPage() == $articles->lastPage()) ? ' disabled' : '' }}">
                                                <a class="page-link"
                                                   href="{{ $articles->url($articles->lastPage()) }}">Última</a>
                                            </li>
                                        </ul>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </section>
                    <!-- /PAGINATION -->

                    <!-- FOOTER -->
                    <footer id="footer" class="footer sct-color-3">
                        <div class="footer-top">
                            <div class="container">
                                <div class="row cols-xs-space cols-sm-space cols-md-space">
                                    <div class="col-lg-5">
                                        <div class="col">
                                            <img src="../../assets/images/logo/logo-1-c.png">
                                            <span class="clearfix"></span>
                                            <span class="heading heading-sm c-gray-light strong-400">One template. Infinite solutions.</span>
                                            <p class="mt-3">
                                                All the components included in Boomerang are built to the same level of
                                                quality as Bootstrap and highlighted with several example pages.
                                            </p>

                                            <div class="copyright mt-4">
                                                <p>
                                                    Copyright &copy; 2018 <a href="https://webpixels.io"
                                                                             target="_blank">
                                                        <strong>Webpixels</strong>
                                                    </a> -
                                                    All rights reserved
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="col">
                                            <h4 class="heading heading-xs strong-600 text-uppercase mb-1">
                                                Support
                                            </h4>

                                            <ul class="footer-links">
                                                <li><a href="blog.html#" title="Help center">Help center</a></li>
                                                <li><a href="blog.html#" title="Discussions">Discussions</a></li>
                                                <li><a href="blog.html#" title="Contact support">Contact</a></li>
                                                <li><a href="blog.html#" title="Blog">Blog</a></li>
                                                <li><a href="blog.html#" title="Jobs">FAQ</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="col">
                                            <h4 class="heading heading-xs strong-600 text-uppercase mb-1">
                                                Company
                                            </h4>

                                            <ul class="footer-links">
                                                <li>
                                                    <a href="blog.html#" title="Home">
                                                        Home
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="blog.html#" title="About us">
                                                        About us
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="blog.html#" title="Services">
                                                        Services
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="blog.html#" title="Blog">
                                                        Blog
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="blog.html#" title="Contact">
                                                        Contact
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="col">
                                            <h4 class="heading heading-xs strong-600 text-uppercase mb-1">
                                                Get in touch
                                            </h4>

                                            <ul class="social-media social-media--style-1-v4">
                                                <li>
                                                    <a href="blog.html#" class="facebook" target="_blank"
                                                       data-toggle="tooltip" data-original-title="Facebook">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="blog.html#" class="instagram" target="_blank"
                                                       data-toggle="tooltip" data-original-title="Instagram">
                                                        <i class="fa fa-instagram"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="blog.html#" class="dribbble" target="_blank"
                                                       data-toggle="tooltip" data-original-title="Dribbble">
                                                        <i class="fa fa-dribbble"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="blog.html#" class="dribbble" target="_blank"
                                                       data-toggle="tooltip" data-original-title="Github">
                                                        <i class="fa fa-github"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
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
