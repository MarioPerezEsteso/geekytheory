<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Geeky Theory Cursos</title>
    <meta name="description" content="Geeky Theory Cursos"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Loading Bootstrap -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">

    <!-- Loading Flat UI -->
    <link href="/assets/vendor/flat-ui/dist/css/flat-ui.css" rel="stylesheet">
    <link href="{{ autoVersion('/assets/courses/css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="assets/vendor/flat-ui/img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="assets/vendor/flat-ui/dist/js/vendor/html5shiv.js"></script>
    <script src="assets/vendor/flat-ui/dist/js/vendor/respond.min.js"></script>
    <![endif]-->

    <link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>

    @if (!empty($siteMeta->analytics_script))
        {!! $siteMeta->analytics_script !!}
    @endif

    @include('courses.partials.cookies')
    @include('courses.partials.hotjar')
</head>
<body>

@include('courses.partials.navbar')

<div class="jumbotron jumbotron-home background-home center-flex">
    <div class="container">
        <div class="row">
            @if (!isset($user))
                <div class="col-lg-6 col-md-6 hidden-xs">
                    <h1 class="jumbotron-title">{{ trans('public.home_header') }}</h1>
                    <p>{{ trans('public.home_subheader') }}</p>
                </div>
                <div class="col-lg-5 col-lg-push-1 col-md-6">
                    @include('courses.partials.auth.register')
                </div>
            @else
                <div class="col-lg-6 col-md-6">
                    <h3 class="jumbotron-title">{{ trans('public.home_header') }}</h3>
                    <p>{{ trans('public.home_subheader') }}</p>
                </div>
                <div class="col-lg-5 col-lg-push-1 col-md-6 hidden-sm hidden-xs">
                    <img class="img-responsive" src="/images/terminal.png">
                </div>
            @endif
        </div>
    </div>
</div>

<section class="container-fluid section-gray">
    @include('courses.partials.courses')
</section>

@if (!isset($user) || (isset($user) && !$user['premium']))
    <section class="container-fluid section-pricing">
        @include('courses.partials.pricing')
    </section>
@endif

@include('courses.partials.footer')

<script src="/assets/vendor/flat-ui/dist/js/vendor/jquery.min.js"></script>
<script src="/assets/vendor/flat-ui/dist/js/vendor/video.js"></script>
<script src="/assets/vendor/flat-ui/dist/js/flat-ui.min.js"></script>
<script src="/assets/vendor/flat-ui/docs/assets/js/application.js"></script>
<script src="/assets/courses/js/drift.js" async></script>

</body>
</html>
