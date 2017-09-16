<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('postTitle')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('postDescriptionMeta')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->description ?? $post->title }}">
    <meta name="twitter:image"
          content="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($post->image, false, true) }}">

    <!-- Favicons -->
    <link rel="shortcut icon"
          href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->favicon) }}">
    <link rel="apple-touch-icon"
          href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_57) }}">
    <link rel="apple-touch-icon" sizes="72x72"
          href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_72) }}">
    <link rel="apple-touch-icon" sizes="114x114"
          href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_114) }}">

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Plugins -->
    <link href="{{ autoVersion("/themes/vortex/assets/css/font-awesome.min.css") }}" rel="stylesheet">
    <link href="{{ autoVersion("/themes/vortex/assets/css/ionicons.min.css") }}" rel="stylesheet">
    <link href="{{ autoVersion("/themes/vortex/assets/css/simpletextrotator.css") }}" rel="stylesheet">
    <link href="{{ autoVersion("/themes/vortex/assets/css/magnific-popup.css") }}" rel="stylesheet">
    <link href="{{ autoVersion("/themes/vortex/assets/css/owl.carousel.css") }}" rel="stylesheet">
    <link href="{{ autoVersion("/themes/vortex/assets/css/superslides.css") }}" rel="stylesheet">
    <link href="{{ autoVersion("/themes/vortex/assets/css/vertical.css") }}" rel="stylesheet">
    <link href="{{ autoVersion("/themes/vortex/assets/css/animate.css") }}" rel="stylesheet">
    <link href="{{ autoVersion("/themes/vortex/assets/css/custom.css") }}" rel="stylesheet">

@yield('custom-css')

@include('themes.vortex.partials.cookies')

<!-- Template core CSS -->
    <link href="{{ autoVersion("/themes/vortex/assets/css/style.css") }}" rel="stylesheet">
    @if (!empty($siteMeta->analytics_script))
        {!! $siteMeta->analytics_script !!}
    @endif
</head>
<body>

<!-- OVERLAY MENU -->
@include('themes.vortex.partials.overlay-menu')
<!-- /OVERLAY MENU -->

<!-- WRAPPER -->
<div class="wrapper">

    <!-- NAVIGATION -->
@include('themes.vortex.partials.navigation')
<!-- /NAVIGATION -->

@include('themes.vortex.blog.partials.posthero')

@yield('content')

<!-- FOOTER -->
@include('themes.vortex.partials.footer')
<!-- /FOOTER -->

</div>
<!-- /WRAPPER -->

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

<!-- Javascript files -->
<script src="/themes/vortex/assets/js/jquery-2.1.3.min.js"></script>
<script src="/assets/js/bootstrap/bootstrap.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.superslides.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.mb.YTPlayer.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.magnific-popup.min.js"></script>
<script src="/themes/vortex/assets/js/owl.carousel.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.simple-text-rotator.min.js"></script>
<script src="/themes/vortex/assets/js/imagesloaded.pkgd.min.js"></script>
<script src="/themes/vortex/assets/js/isotope.pkgd.min.js"></script>
<script src="/themes/vortex/assets/js/packery-mode.pkgd.min.js"></script>
<script src="/themes/vortex/assets/js/appear.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.easing.1.3.min.js"></script>
<script src="/themes/vortex/assets/js/wow.min.js"></script>
<script src="/themes/vortex/assets/js/jqBootstrapValidation.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.fitvids.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.parallax-1.1.3.min.js"></script>
<script src="/themes/vortex/assets/js/smoothscroll.min.js"></script>
<script src="/themes/vortex/assets/js/custom.min.js"></script>

@yield('custom-javascript')

</body>
</html>