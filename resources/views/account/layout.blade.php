<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('pageTitle')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->favicon) }}">
    <link rel="apple-touch-icon" href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_57) }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_72) }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo_114) }}">

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/account/vendor/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="/account/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="/account/vendor/jquery.scrollbar/jquery.scrollbar.css">
    <link rel="stylesheet" href="/account/vendor/fullcalendar/dist/fullcalendar.min.css">

    <!-- App styles -->
    <link rel="stylesheet" href="{{ autoVersion("/account/css/app.min.css") }}">
    <link rel="stylesheet" href="{{ autoVersion("/account/css/custom.css") }}">

    @if (!empty($siteMeta->analytics_script))
        {!! $siteMeta->analytics_script !!}
    @endif
    @include('courses.partials.hotjar')
</head>

<body data-ma-theme="dark-blue">
<main class="main">
    <div class="page-loader">
        <div class="page-loader__spinner">
            <svg viewBox="25 25 50 50">
                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
            </svg>
        </div>
    </div>

    <header class="header">
        <div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
            <div class="navigation-trigger__inner">
                <i class="navigation-trigger__line"></i>
                <i class="navigation-trigger__line"></i>
                <i class="navigation-trigger__line"></i>
            </div>
        </div>

        <div class="header__logo hidden-sm-down">
            <a href="{{ $siteMeta->url }}">
                <img class="img-responsive" src="/assets/images/logo/logo-geeky-theory.png" alt="GeekyTheory.com"/>
            </a>
        </div>

        <ul class="top-nav">
            <li class="dropdown">
                <a href="" data-toggle="dropdown">
                    <img class="img-account-avatar img-responsive" src="{{ $user['avatar'] }}"
                         alt="{{ $user['name'] }}"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                    <div class="listview listview--hover">
                        <div class="listview__header">
                            {{ $user['name'] }}
                            <div class="actions">
                                <img class="img-account-avatar img-responsive" src="{{ $user['avatar'] }}"
                                     alt="GeekyTheory.com"/>
                            </div>
                        </div>
                        <a href="{{ route('logout') }}" class="view-more">Cerrar sesión</a>
                    </div>
                </div>
            </li>
        </ul>
    </header>

    <aside class="sidebar">
        <div class="scrollbar-inner">
            <ul class="navigation">
                <li class="{{ isRoute('account') ? 'navigation__active' : '' }}"><a href="{{ route('account') }}"><i
                                class="zmdi zmdi-home"></i> Inicio</a></li>
                <li class="navigation__sub {{ isRoute('account.profile') || isRoute('account.profile.password') ? 'navigation__sub--active' : '' }}">
                    <a href=""><i class="zmdi zmdi-account zmdi-hc-fw"></i> Perfil de usuario</a>
                    <ul>
                        <li class="{{ isRoute('account.profile') ? 'navigation__active' : '' }}"><a
                                    href="{{ route('account.profile') }}">Datos de usuario</a></li>
                        <li class="{{ isRoute('account.profile.password') ? 'navigation__active' : '' }}"><a
                                    href="{{ route('account.profile.password') }}">Cambio de contraseña</a></li>
                    </ul>
                </li>
                <li class="navigation__sub {{ isRoute('account.subscription') || isRoute('account.subscription.payment-method') ? 'navigation__sub--active' : '' }}">
                    <a href=""><i class="zmdi zmdi-ticket-star zmdi-hc-fw"></i> Suscripción</a>
                    <ul>
                        <li class="{{ isRoute('account.subscription') ? 'navigation__active' : '' }}">
                            <a href="{{ route('account.subscription') }}">Mi suscripción</a>
                        </li>
                        <li class="{{ isRoute('account.subscription.payment-method') ? 'navigation__active' : '' }}">
                            <a href="{{ route('account.subscription.payment-method') }}">Método de pago</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>

    <section class="content">
        <header class="content__title">
            <h1>@yield('contentTitle')</h1>
            <small>@yield('contentSubtitle')</small>
        </header>

        @yield('content')

    </section>
</main>

<!-- Older IE warning message -->
<!--[if IE]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade to any of the following web browsers to
        access this website.</p>

    <div class="ie-warning__downloads">
        <a href="http://www.google.com/chrome">
            <img src="img/browsers/chrome.png" alt="">
        </a>

        <a href="https://www.mozilla.org/en-US/firefox/new">
            <img src="img/browsers/firefox.png" alt="">
        </a>

        <a href="http://www.opera.com">
            <img src="img/browsers/opera.png" alt="">
        </a>

        <a href="https://support.apple.com/downloads/safari">
            <img src="img/browsers/safari.png" alt="">
        </a>

        <a href="https://www.microsoft.com/en-us/windows/microsoft-edge">
            <img src="img/browsers/edge.png" alt="">
        </a>

        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
            <img src="img/browsers/ie.png" alt="">
        </a>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->

<!-- Javascript -->
<!-- Vendors -->
<script src="/account/vendor/jquery/dist/jquery.min.js"></script>
<script src="/account/vendor/tether/dist/js/tether.min.js"></script>
<script src="/account/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/account/vendor/Waves/dist/waves.min.js"></script>
<script src="/account/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
<script src="/account/vendor/jquery-scrollLock/jquery-scrollLock.min.js"></script>
<script src="/account/vendor/Waves/dist/waves.min.js"></script>

<!-- App functions and actions -->
<script src="/account/js/app.min.js"></script>

@yield('customJavascript')

</body>
</html>