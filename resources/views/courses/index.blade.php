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
</head>
<body>

@include('courses.partials.navbar')

<div class="jumbotron jumbotron-home center-flex">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="jumbotron-title">Aprende programación, desarrollo web y mucho más</h1>
                <p>Geeky Theory ofrece un período de prueba de 7 días para que puedas probar todos los cursos del
                    catálogo. Desde Javascript a Laravel, pasando por SQL y muchas tecnologías más. ¿Quieres convertirte
                    en un desarrollador experto? ¡Apúntate!</p>
            </div>
            <div class="col-lg-5 col-lg-push-1">
                <div class="login-jumbotron">
                    <div class="login-jumbotron-trial-banner">
                        <p>Pruébalo gratis durante 7 días</p>
                    </div>
                    <div class="login-form">
                        <div class="form-group">
                            <input type="text" class="form-control login-field" value=""
                                   placeholder="Introduce tu nombre"
                                   id="login-name">
                            <label class="login-field-icon fui-user" for="login-name"></label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control login-field" value=""
                                   placeholder="Introduce tu email"
                                   id="login-name">
                            <label class="login-field-icon fui-mail" for="login-name"></label>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control login-field" value="" placeholder="Contraseña"
                                   id="login-pass">
                            <label class="login-field-icon fui-lock" for="login-pass"></label>
                        </div>

                        <a class="btn btn-primary btn-lg btn-block" href="#">Obtener 7 días gratis</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="container-fluid section-gray">
    @include('courses.partials.courses')
</section>

<section class="container-fluid section-pricing">
    @include('courses.partials.pricing')
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-7">
                <h3 class="footer-title">Subscribe</h3>
                <p>Do you like this freebie? Want to get more stuff like this?<br/>
                    Subscribe to designmodo news and updates to stay tuned on great designs.<br/>
                    Go to: <a href="http://designmodo.com/flat-free" target="_blank">designmodo.com/flat-free</a>
                </p>

                <p class="pvl">
                    <a href="https://twitter.com/share" class="twitter-share-button"
                       data-url="http://designmodo.com/flat-free/"
                       data-text="Flat UI Free - PSD&amp;amp;HTML User Interface Kit" data-via="designmodo">Tweet</a>
                    <script>!function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0],
                                p = /^http:/.test(d.location) ? 'http' : 'https';
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = p + '://platform.twitter.com/widgets.js';
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, 'script', 'twitter-wjs');</script>
                    <iframe src="http://ghbtns.com/github-btn.html?user=designmodo&repo=Flat-UI&type=watch&count=true"
                            height="20" width="107" frameborder="0" scrolling="0" style="width:105px; height: 20px;"
                            allowTransparency="true"></iframe>
                    <iframe src="http://ghbtns.com/github-btn.html?user=designmodo&repo=Flat-UI&type=fork&count=true"
                            height="20" width="107" frameborder="0" scrolling="0" style="width:105px; height: 20px;"
                            allowTransparency="true"></iframe>
                    <iframe src="http://ghbtns.com/github-btn.html?user=designmodo&type=follow&count=true" height="20"
                            width="195" frameborder="0" scrolling="0" style="width:195px; height: 20px;"
                            allowTransparency="true"></iframe>
                </p>

                <a class="footer-brand" href="http://designmodo.com" target="_blank">
                    <img src="docs/assets/img/footer/logo.png" alt="Designmodo.com"/>
                </a>
            </div> <!-- /col-xs-7 -->

            <div class="col-xs-5">
                <div class="footer-banner">
                    <h3 class="footer-title">Get Flat UI Pro</h3>
                    <ul>
                        <li>Tons of Basic and Custom UI Elements</li>
                        <li>A Lot of Useful Samples</li>
                        <li>More Vector Icons and Glyphs</li>
                        <li>Pro Color Swatches</li>
                        <li>Bootstrap Based HTML/CSS/JS Layout</li>
                    </ul>
                    Go to: <a href="http://designmodo.com/flat" target="_blank">designmodo.com/flat</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="assets/vendor/flat-ui/dist/js/vendor/jquery.min.js"></script>
<script src="assets/vendor/flat-ui/dist/js/vendor/video.js"></script>
<script src="assets/vendor/flat-ui/dist/js/flat-ui.min.js"></script>
<script src="assets/vendor/flat-ui/docs/assets/js/application.js"></script>

</body>
</html>
