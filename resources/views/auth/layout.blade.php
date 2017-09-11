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
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><i class="glyphicon glyphicon-home"></i></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{route('login')}}">{{ trans('auth.login') }}</a></li>
                    @if ($siteMeta->allow_register)
                        <li><a href="{{route('auth.register.get')}}">{{ trans('auth.register') }}</a></li>
                    @endif
                @else
                    <li>
                        <a href="#">{{ Auth::user()->name }}</a>
                    </li>
                    <li><a href="{{route('auth/logout')}}">{{ trans('auth.logout') }}</a></li>

                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')
            <!-- Scripts -->
    {!! Html::script('assets/js/bootstrap/bootstrap.min.js') !!}
</body>
</html>