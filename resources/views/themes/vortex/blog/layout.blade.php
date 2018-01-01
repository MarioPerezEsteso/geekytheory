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

    <!-- Loading Bootstrap -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">

    <!-- Loading Flat UI -->
    <link href="/assets/vendor/flat-ui/dist/css/flat-ui.css" rel="stylesheet">
    <link href="{{ autoVersion('/assets/courses/css/app.css') }}" rel="stylesheet">
    <link href="{{ autoVersion('/assets/css/blog.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="/assets/vendor/flat-ui/img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="/assets/vendor/flat-ui/dist/js/vendor/html5shiv.js"></script>
    <script src="/assets/vendor/flat-ui/dist/js/vendor/respond.min.js"></script>
    <![endif]-->

    <link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>

    @if (!empty($siteMeta->analytics_script))
        {!! $siteMeta->analytics_script !!}
    @endif

    @include('courses.partials.cookies')

    @yield('custom-css')

    @if (!empty($siteMeta->analytics_script))
        {!! $siteMeta->analytics_script !!}
    @endif
</head>
<body>

@include('courses.partials.navbar')

@if (!isset($user))
    <div class="jumbotron jumbotron-home background-home center-flex">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 hidden-xs">
                    <h1 class="jumbotron-title">{{ trans('public.home_header') }}</h1>
                    <p>{{ trans('public.home_subheader') }}</p>
                </div>
                <div class="col-lg-5 col-lg-push-1 col-md-6">
                    @include('courses.partials.auth.register')
                </div>
            </div>
        </div>
    </div>
@endif

@yield('content')

@if (!isset($user) || (isset($user) && !$user['premium']))
    <section class="container-fluid section-pricing">
        @include('courses.partials.pricing')
    </section>
@endif

<!-- FOOTER -->
@include('courses.partials.footer')
<!-- /FOOTER -->

<!-- Javascript files -->
<script src="/themes/vortex/assets/js/jquery-2.1.3.min.js"></script>
<script src="/assets/js/bootstrap/bootstrap.min.js"></script>
<script src="/assets/vendor/fluidvids/fluidvids.min.js"></script>
<script>
    fluidvids.init({
        selector: ['iframe'],
        players: ['www.youtube.com', 'player.vimeo.com']
    });
</script>

@yield('custom-javascript')

</body>
</html>