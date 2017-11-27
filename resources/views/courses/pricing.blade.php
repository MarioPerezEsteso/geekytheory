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
    <link href="assets/vendor/flat-ui/dist/css/flat-ui.css" rel="stylesheet">
    <link href="{{ autoVersion('assets/courses/css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="assets/vendor/flat-ui/img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="assets/vendor/flat-ui/dist/js/vendor/html5shiv.js"></script>
    <script src="assets/vendor/flat-ui/dist/js/vendor/respond.min.js"></script>
    <![endif]-->

    <link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>

    @include('courses.partials.cookies')
</head>
<body>

@include('courses.partials.navbar')

<section class="container-fluid section-pricing section-pricing-mt-53">
    @include('courses.partials.pricing')
</section>

<section class="container-fluid section-testimonials">
    <div class="container testimonials-content">
        <div class="row">
            <div class="col-md-4">
                <div class="testimonials">
                    <div class="active item">
                        <blockquote><p>Denim you probably haven't heard of. Lorem ipsum dolor met consectetur
                                adipisicing sit amet, consectetur adipisicing elit...</p></blockquote>
                        <div class="carousel-info">
                            <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
                            <div class="pull-left">
                                <span class="testimonials-name">Lina Mars</span>
                                <span class="testimonials-post">Commercial Director</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonials">
                    <div class="active item">
                        <blockquote><p>consectetur adipisicing elit, of them jean shorts sed magna
                                aliqua. Lorem ipsum dolor met. lorem ipsum</p></blockquote>
                        <div class="carousel-info">
                            <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
                            <div class="pull-left">
                                <span class="testimonials-name">Lina Mars</span>
                                <span class="testimonials-post">Commercial Director</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonials">
                    <div class="active item">
                        <blockquote><p>Denim you probably haven't heard of. Lorem ipsum dolor met consectetur
                                adipisicing sit amet, consectetur adipisicing elit</p></blockquote>
                        <div class="carousel-info">
                            <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
                            <div class="pull-left">
                                <span class="testimonials-name">Lina Mars</span>
                                <span class="testimonials-post">Commercial Director</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('courses.partials.footer')

<script src="assets/vendor/flat-ui/dist/js/vendor/jquery.min.js"></script>
<script src="assets/vendor/flat-ui/dist/js/vendor/video.js"></script>
<script src="assets/vendor/flat-ui/dist/js/flat-ui.min.js"></script>
<script src="assets/vendor/flat-ui/docs/assets/js/application.js"></script>

</body>
</html>
