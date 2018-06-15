<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="index, follow">
    <meta name="description"
          content="Boomerang is a responsive website template based on the well known Bootstrap framework. It's very well structured with lots of features and demos ready to be used.">
    <meta name="keywords"
          content="bootstrap, responsive, template, website, html, theme, ux, ui, web, design, developer, support, business, corporate, real estate, education, medical, school, education, demo, css, framework">
    <meta name="author" content="Webpixels">

    <title>Boomerang - Multipurpose Bootstrap Theme</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css" type="text/css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800|Roboto:400,500,700" rel="stylesheet">

    <!-- Plugins -->
    <link rel="stylesheet" href="../../assets/vendor/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="../../assets/vendor/hamburgers/hamburgers.min.css" type="text/css">
    <link rel="stylesheet" href="../../assets/vendor/animate/animate.min.css" type="text/css">
    <link rel="stylesheet" href="../../assets/vendor/fancybox/css/jquery.fancybox.min.css">

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/fonts/font-awesome/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../../assets/fonts/ionicons/css/ionicons.min.css" type="text/css">
    <link rel="stylesheet" href="../../assets/fonts/line-icons/line-icons.css" type="text/css">
    <link rel="stylesheet" href="../../assets/fonts/line-icons-pro/line-icons-pro.css" type="text/css">

    <!-- Linea Icons -->
    <link rel="stylesheet" href="../../assets/fonts/linea/arrows/linea-icons.css" type="text/css">
    <link rel="stylesheet" href="../../assets/fonts/linea/basic/linea-icons.css" type="text/css">
    <link rel="stylesheet" href="../../assets/fonts/linea/ecommerce/linea-icons.css" type="text/css">
    <link rel="stylesheet" href="../../assets/fonts/linea/software/linea-icons.css" type="text/css">

    <!-- Global style (main) -->
    <link id="stylesheet" type="text/css" href="../../assets/css/app.min.css" rel="stylesheet" media="screen">

    <!-- Custom style - Remove if not necessary -->
    <link type="text/css" href="../../assets/css/custom-style.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="https://preview.webpixels.io/boomerang-v3.6/assets/images/favicon.png" rel="icon" type="image/png">


    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Syntax highlighting -->
    <link rel="stylesheet" href="../../assets/vendor/highlightjs/css/styles/atom-one-dark.css" type="text/css">
</head>
<body>
<!-- MAIN WRAPPER -->
<div class="body-wrap">
    <div id="st-container" class="st-container">
        <div class="st-pusher">
            <div class="st-content">
                <div class="st-content-inner">
                    <!-- Header -->
                    <div class="header">
                        @include('web.partials.navbar')
                    </div>

                    @yield('content')

                    @include('web.partials.footer')

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
