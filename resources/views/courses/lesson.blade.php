<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Geeky Theory Cursos</title>
    <meta name="description" content="Geeky Theory Cursos"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Loading Bootstrap -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">

    <!-- Loading Flat UI -->
    <link href="/assets/vendor/flat-ui/dist/css/flat-ui.css" rel="stylesheet">
    <link href="{{ autoVersion('/assets/courses/css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="/assets/vendor/flat-ui/img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="/assets/vendor/flat-ui/dist/js/vendor/html5shiv.js"></script>
    <script src="/assets/vendor/flat-ui/dist/js/vendor/respond.min.js"></script>
    <![endif]-->

    <link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
</head>
<body>

@include('courses.partials.navbar')

<div class="jumbotron jumbotron-post">
    <div class="container container-post">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="embed-responsive embed-responsive-16by9">
                    {!! $lesson->video !!}
                </div>
            </div>
        </div>
    </div>
</div>

<section class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-sm-12">
                    <div class="clearfix content-heading">
                        <h3>{{ $lesson->title }}</h3>
                    </div>
                </div>
            </div>
            <div class="lesson-content">
                {!! $lesson->content !!}
            </div>
        </div>
        <div class="col-lg-5 col-lg-offset-1 col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="clearfix content-heading">
                        <img class="pull-left title-img-header" src="/assets/vendor/flat-ui/img/icons/svg/book.svg"/>
                        <h3>Contenido</h3>
                    </div>
                </div>
            </div>
            @include('courses.partials.courseContent')
        </div>
    </div>
</section>

<section class="container-fluid section-pricing">
    @include('courses.partials.pricing')
</section>

@include('courses.partials.footer')

<script src="/assets/vendor/flat-ui/dist/js/vendor/jquery.min.js"></script>
<script src="/assets/vendor/flat-ui/dist/js/vendor/video.js"></script>
<script src="/assets/vendor/flat-ui/dist/js/flat-ui.min.js"></script>
<script src="/assets/vendor/flat-ui/docs/assets/js/application.js"></script>

</body>
</html>
