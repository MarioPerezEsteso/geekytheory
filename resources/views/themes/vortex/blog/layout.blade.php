<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('postTitle')</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->favicon) }}">
    <link rel="apple-touch-icon" href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_57) }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_72) }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_114) }}">

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Plugins -->
    <link href="/themes/vortex/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/themes/vortex/assets/css/ionicons.min.css" rel="stylesheet">
    <link href="/themes/vortex/assets/css/simpletextrotator.css" rel="stylesheet">
    <link href="/themes/vortex/assets/css/magnific-popup.css" rel="stylesheet">
    <link href="/themes/vortex/assets/css/owl.carousel.css" rel="stylesheet">
    <link href="/themes/vortex/assets/css/superslides.css" rel="stylesheet">
    <link href="/themes/vortex/assets/css/vertical.css" rel="stylesheet">
    <link href="/themes/vortex/assets/css/animate.css" rel="stylesheet">

    <!-- Template core CSS -->
    <link href="/themes/vortex/assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- PRELOADER -->
<div class="page-loader">
    <div class="loader">Loading...</div>
</div>
<!-- /PRELOADER -->

<!-- OVERLAY MENU -->
@include('themes.vortex.partials.overlay-menu')
<!-- /OVERLAY MENU -->

<!-- WRAPPER -->
<div class="wrapper">

    <!-- NAVIGATION -->
    @include('themes.vortex.partials.navigation')
    <!-- /NAVIGATION -->

    <!-- HERO -->
    <section class="module module-parallax bg-light-30" data-background="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($post->image) }}" style="background-image: url('{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($post->image) }}');">
        <!-- HERO TEXT -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1 class="mh-line-size-3 font-alt m-b-20">{{ $post->title }}</h1>
                    <h5 class="mh-line-size-4 font-alt">{{ $post->description }}</h5>
                </div>
            </div>
        </div>
        <!-- /HERO TEXT -->
    </section>
    <!-- /HERO -->

    <!-- SINGLE POST -->
    <section class="module">
        <div class="container">
            <div class="row">
                <!-- CONTENT -->
                <div class="col-sm-10 col-sm-offset-1">
                    <article class="post post-single">
                        <!-- META -->
                        <div class="post-meta font-alt">
                            {{ trans('public.by') }} <a href="{{ url('/user/' . $post->user->username) }}">{{ $post->user->name }}</a>
                        </div>
                        <!-- /META -->
                        <!-- HEADER -->
                        <div class="post-header">
                            <h1 class="post-title font-alt">
                                {{ $post->title }}
                            </h1>
                        </div>
                        <!-- /HEADER -->
                        <!-- POST CONTENT -->
                        <div class="post-entry">
                            {!! $post->body !!}
                        </div>
                        <!-- /POST CONTENT -->

                        <!-- TAGS -->
                        <div class="tags">
                            @foreach($post->tags as $tag)
                                @include('themes.vortex.partials.blog.tags')
                            @endforeach
                        </div>
                        <!-- /TAGS -->

                    </article>

                    <!-- AUTHOR -->
                    @include('themes.vortex.partials.blog.author')
                    <!-- /AUTHOR -->

                </div>
                <!-- /CONTENT -->

            </div>

        </div>

    </section>
    <!-- /SINGLE POST -->

    <!-- FOOTER -->
    @include('themes.vortex.partials.footer')
    <!-- /FOOTER -->

</div>
<!-- /WRAPPER -->

<!-- SCROLLTOP -->
<div class="scroll-up">
    <a href="blog-single.html#totop"><i class="fa fa-angle-double-up"></i></a>
</div>

<!-- Javascript files -->
<script src="/themes/vortex/assets/js/jquery-2.1.3.min.js"></script>
<script src="/assets/js/bootstrap/bootstrap.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.superslides.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.mb.YTPlayer.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.magnific-popup.min.js"></script>
<script src="/themes/vortex/assets/js/owl.carousel.min.js"></script>
<script src="/themes/vortex/assets/js/jquery.simple-text-rotator.min.js"></script>
<script src="/themes/vortex/assets/js/imagesloaded.pkgd.js"></script>
<script src="/themes/vortex/assets/js/isotope.pkgd.min.js"></script>
<script src="/themes/vortex/assets/js/packery-mode.pkgd.min.js"></script>
<script src="/themes/vortex/assets/js/appear.js"></script>
<script src="/themes/vortex/assets/js/jquery.easing.1.3.js"></script>
<script src="/themes/vortex/assets/js/wow.min.js"></script>
<script src="/themes/vortex/assets/js/jqBootstrapValidation.js"></script>
<script src="/themes/vortex/assets/js/jquery.fitvids.js"></script>
<script src="/themes/vortex/assets/js/jquery.parallax-1.1.3.js"></script>
<script src="/themes/vortex/assets/js/smoothscroll.js"></script>
<script src="/themes/vortex/assets/js/contact.js"></script>
<script src="/themes/vortex/assets/js/custom.js"></script>
</body>
</html>