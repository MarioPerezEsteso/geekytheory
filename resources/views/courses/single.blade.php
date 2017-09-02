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

<div class="jumbotron jumbotron-post center-flex">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <span class="btn btn-info">{{ trans('public.' . $course->difficulty) }}</span>
                <h1 class="jumbotron-title">{{ $course->title }}</h1>
                <p>{!! $course->description !!}</p>
                <a class="btn btn-primary btn-join-course">Apuntarme</a>
            </div>
            <div class="col-lg-5 col-lg-push-1">
                <img class="img-responsive" src="{{ $course->image_thumbnail }}">
            </div>
        </div>
    </div>
</div>

<section class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-sm-12">
            <div class="clearfix content-heading">
                <img class="pull-left title-img-header" src="/assets/vendor/flat-ui/img/icons/svg/book.svg"/>
                <h3>Contenido</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-sm-12">
            <div class="course-content">
                @foreach($course->chapters as $chapter)
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                {{ $chapter->order }}. {{ $chapter->title }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach($chapter->lessons as $lesson)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                {{ $chapter->order }}.{{ $lesson->order }}. {{ $lesson->title }}
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="pull-right">
                                                    <div class="lesson-info-item lesson-info-free">
                                                        Gratis
                                                    </div>
                                                    <div class="lesson-info-item lesson-info-time">
                                                        {{ formatSeconds($lesson->duration) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
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
