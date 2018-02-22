<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>{{ $course->title }} - {{ $lesson->title }}</title>
    <meta name="description" content="{{ $course->description }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $course->title }}: {{ $lesson->title}}">
    <meta name="twitter:description" content="{{ $course->description }}">
    <meta name="twitter:image"
          content="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($course->image, false, true) }}">

    <link rel="canonical" href="{{ URL::current() }}"/>

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

    <link rel="stylesheet" href="/assets/vendor/highlight/css/hightlight.min.css">

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
    @include('courses.partials.hotjar')
</head>
<body data-lesson-id="{{ $lesson->id }}">

@include('courses.partials.navbar')

@if($showHeaderTemplate == \App\Http\Controllers\LessonController::TEMPLATE_HEADER_VIDEO)
    @include('courses.partials.lesson.video')
@elseif($showHeaderTemplate == \App\Http\Controllers\LessonController::TEMPLATE_HEADER_REGISTER)
    @include('courses.partials.lesson.headerRegister')
@else
    @include('courses.partials.lesson.headerGoPremium')
@endif

<section class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-sm-12">
                    <div class="clearfix content-heading">
                        <h3>{{ $lesson->title }}</h3>
                    </div>
                </div>
                <div class="lesson-content">
                    @if (!isset($user) || (isset($user) && !$user['premium']))
                        <div class="alert alert-info">
                            Solo los usuarios Premium pueden ver este contenido.
                        </div>
                    @else
                        {!! $lesson->content !!}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h4>Comentarios</h4>
                    <div id="disqus_thread"></div>
                </div>
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
@if (!empty($lesson->video))
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="/assets/courses/js/video.js"></script>
@endif
<script src="/assets/courses/js/disqus.js"></script>
<script src="/assets/courses/js/drift.js" async></script>
<script src="/assets/vendor/highlight/js/highlight.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('pre').each(function (i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>
</body>
</html>
