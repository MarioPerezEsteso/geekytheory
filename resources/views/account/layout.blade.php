<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/account/vendor/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="/account/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="/account/vendor/jquery.scrollbar/jquery.scrollbar.css">
    <link rel="stylesheet" href="/account/vendor/fullcalendar/dist/fullcalendar.min.css">

    <!-- App styles -->
    <link rel="stylesheet" href="/account/css/app.min.css">
    <link rel="stylesheet" href="/account/css/custom.css">
</head>

<body data-ma-theme="green">
<main class="main">
    <div class="page-loader">
        <div class="page-loader__spinner">
            <svg viewBox="25 25 50 50">
                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
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
            <h1><a href="/">Geeky Theory</a></h1>
        </div>

        <ul class="top-nav">
            <li class="hidden-xl-up"><a href="" data-ma-action="search-open"><i class="zmdi zmdi-search"></i></a></li>

            <li class="dropdown">
                <a href="" data-toggle="dropdown"><i class="zmdi zmdi-email"></i></a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                    <div class="listview listview--hover">
                        <div class="listview__header">
                            Messages

                            <div class="actions">
                                <a href="messages.html" class="actions__item zmdi zmdi-plus"></a>
                            </div>
                        </div>

                        <a href="" class="listview__item">
                            <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">
                                    David Belle <small>12:01 PM</small>
                                </div>
                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                            </div>
                        </a>

                        <a href="" class="listview__item">
                            <img src="demo/img/profile-pics/2.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">
                                    Jonathan Morris
                                    <small>02:45 PM</small>
                                </div>
                                <p>Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</p>
                            </div>
                        </a>

                        <a href="" class="listview__item">
                            <img src="demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">
                                    Fredric Mitchell Jr.
                                    <small>08:21 PM</small>
                                </div>
                                <p>Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</p>
                            </div>
                        </a>

                        <a href="" class="listview__item">
                            <img src="demo/img/profile-pics/4.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">
                                    Glenn Jecobs
                                    <small>08:43 PM</small>
                                </div>
                                <p>Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</p>
                            </div>
                        </a>

                        <a href="" class="listview__item">
                            <img src="demo/img/profile-pics/5.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">
                                    Bill Phillips
                                    <small>11:32 PM</small>
                                </div>
                                <p>Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</p>
                            </div>
                        </a>

                        <a href="" class="view-more">View all messages</a>
                    </div>
                </div>
            </li>

            <li class="dropdown top-nav__notifications">
                <a href="" data-toggle="dropdown" class="top-nav__notify">
                    <i class="zmdi zmdi-notifications"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                    <div class="listview listview--hover">
                        <div class="listview__header">
                            Notifications

                            <div class="actions">
                                <a href="" class="actions__item zmdi zmdi-check-all" data-ma-action="notifications-clear"></a>
                            </div>
                        </div>

                        <div class="listview__scroll scrollbar-inner">
                            <a href="" class="listview__item">
                                <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                                <div class="listview__content">
                                    <div class="listview__heading">David Belle</div>
                                    <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                </div>
                            </a>

                            <a href="" class="listview__item">
                                <img src="demo/img/profile-pics/2.jpg" class="listview__img" alt="">

                                <div class="listview__content">
                                    <div class="listview__heading">Jonathan Morris</div>
                                    <p>Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</p>
                                </div>
                            </a>

                            <a href="" class="listview__item">
                                <img src="demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                                <div class="listview__content">
                                    <div class="listview__heading">Fredric Mitchell Jr.</div>
                                    <p>Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</p>
                                </div>
                            </a>

                            <a href="" class="listview__item">
                                <img src="demo/img/profile-pics/4.jpg" class="listview__img" alt="">

                                <div class="listview__content">
                                    <div class="listview__heading">Glenn Jecobs</div>
                                    <p>Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</p>
                                </div>
                            </a>

                            <a href="" class="listview__item">
                                <img src="demo/img/profile-pics/5.jpg" class="listview__img" alt="">

                                <div class="listview__content">
                                    <div class="listview__heading">Bill Phillips</div>
                                    <p>Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</p>
                                </div>
                            </a>

                            <a href="" class="listview__item">
                                <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                                <div class="listview__content">
                                    <div class="listview__heading">David Belle</div>
                                    <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                </div>
                            </a>

                            <a href="" class="listview__item">
                                <img src="demo/img/profile-pics/2.jpg" class="listview__img" alt="">

                                <div class="listview__content">
                                    <div class="listview__heading">Jonathan Morris</div>
                                    <p>Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</p>
                                </div>
                            </a>

                            <a href="" class="listview__item">
                                <img src="demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                                <div class="listview__content">
                                    <div class="listview__heading">Fredric Mitchell Jr.</div>
                                    <p>Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</p>
                                </div>
                            </a>
                        </div>

                        <div class="p-1"></div>
                    </div>
                </div>
            </li>

            <li class="dropdown hidden-xs-down">
                <a href="" data-toggle="dropdown"><i class="zmdi zmdi-check-circle"></i></a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                    <div class="listview listview--hover">
                        <div class="listview__header">Tasks</div>

                        <a href="" class="listview__item">
                            <div class="listview__content">
                                <div class="listview__heading">HTML5 Validation Report</div>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="listview__item">
                            <div class="listview__content">
                                <div class="listview__heading">Google Chrome Extension</div>

                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="listview__item">
                            <div class="listview__content">
                                <div class="listview__heading">Social Intranet Projects</div>

                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="listview__item">
                            <div class="listview__content">
                                <div class="listview__heading">Bootstrap Admin Template</div>

                                <div class="progress">
                                    <div class="progress-bar bg-info" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="listview__item">
                            <div class="listview__content">
                                <div class="listview__heading">Youtube Client App</div>

                                <div class="progress">
                                    <div class="progress-bar bg-danger" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="view-more">View all tasks</a>
                    </div>
                </div>
            </li>

            <li class="dropdown hidden-xs-down">
                <a href="" data-toggle="dropdown"><i class="zmdi zmdi-apps"></i></a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                    <div class="row app-shortcuts">
                        <a class="col-4 app-shortcuts__item" href="">
                            <i class="zmdi zmdi-calendar bg-red"></i>
                            <small class="">Calendar</small>
                        </a>
                        <a class="col-4 app-shortcuts__item" href="">
                            <i class="zmdi zmdi-file-text bg-blue"></i>
                            <small class="">Files</small>
                        </a>
                        <a class="col-4 app-shortcuts__item" href="">
                            <i class="zmdi zmdi-email bg-teal"></i>
                            <small class="">Email</small>
                        </a>
                        <a class="col-4 app-shortcuts__item" href="">
                            <i class="zmdi zmdi-trending-up bg-blue-grey"></i>
                            <small class="">Reports</small>
                        </a>
                        <a class="col-4 app-shortcuts__item" href="">
                            <i class="zmdi zmdi-view-headline bg-orange"></i>
                            <small class="">News</small>
                        </a>
                        <a class="col-4 app-shortcuts__item" href="">
                            <i class="zmdi zmdi-image bg-light-green"></i>
                            <small class="">Gallery</small>
                        </a>
                    </div>
                </div>
            </li>

            <li class="dropdown hidden-xs-down">
                <a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-item theme-switch">
                        Theme Switch

                        <div class="btn-group btn-group--colors mt-2" data-toggle="buttons">
                            <label class="btn bg-green active"><input type="radio" value="green" autocomplete="off" checked></label>
                            <label class="btn bg-blue"><input type="radio" value="blue" autocomplete="off"></label>
                            <label class="btn bg-red"><input type="radio" value="red" autocomplete="off"></label>
                            <label class="btn bg-orange"><input type="radio" value="orange" autocomplete="off"></label>
                            <label class="btn bg-teal"><input type="radio" value="teal" autocomplete="off"></label>

                            <br>

                            <label class="btn bg-cyan"><input type="radio" value="cyan" autocomplete="off"></label>
                            <label class="btn bg-blue-grey"><input type="radio" value="blue-grey" autocomplete="off"></label>
                            <label class="btn bg-purple"><input type="radio" value="purple" autocomplete="off"></label>
                            <label class="btn bg-indigo"><input type="radio" value="indigo" autocomplete="off"></label>
                            <label class="btn bg-lime"><input type="radio" value="lime" autocomplete="off"></label>
                        </div>
                    </div>
                    <a href="" class="dropdown-item">Fullscreen</a>
                    <a href="" class="dropdown-item">Clear Local Storage</a>
                </div>
            </li>

            <li class="hidden-xs-down">
                <a href="" data-ma-action="aside-open" data-ma-target=".chat" class="top-nav__notify">
                    <i class="zmdi zmdi-comment-alt-text"></i>
                </a>
            </li>
        </ul>
    </header>

    <aside class="sidebar">
        <div class="scrollbar-inner">
            <div class="user">
                <div class="user__info" data-toggle="dropdown">
                    <img class="user__img" src="{{ getGravatar($user['email']) }}" alt="">
                    <div>
                        <div class="user__name">{{ $user['name'] }}</div>
                        <div class="user__email">{{ $user['email'] }}</div>
                    </div>
                </div>

                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('logout') }}">Salir</a>
                </div>
            </div>

            <ul class="navigation">
                <li class="{{ isRoute('account') ? 'navigation__active' : '' }}"><a href="{{ route('account') }}"><i class="zmdi zmdi-home"></i> Inicio</a></li>
                <li class="navigation__sub {{ isRoute('account.profile') || isRoute('account.profile.password') ? 'navigation__sub--active' : '' }}">
                    <a href=""><i class="zmdi zmdi-account zmdi-hc-fw"></i> Perfil de usuario</a>
                    <ul>
                        <li class="{{ isRoute('account.profile') ? 'navigation__active' : '' }}"><a href="{{ route('account.profile') }}">Datos de usuario</a></li>
                        <li class="{{ isRoute('account.profile.password') ? 'navigation__active' : '' }}"><a href="{{ route('account.profile.password') }}">Cambio de contraseña</a></li>
                    </ul>
                </li>
                <li class="navigation__sub {{ isRoute('account.subscription') || isRoute('account.subscription.payment-method') ? 'navigation__sub--active' : '' }}">
                    <a href=""><i class="zmdi zmdi-ticket-star zmdi-hc-fw"></i> Suscripción</a>
                    <ul>
                        <li class="{{ isRoute('account.subscription') ? 'navigation__active' : '' }}">
                            <a href="{{ route('account.subscription') }}">Mi suscripción</a>
                        </li>
                        <li class="{{ isRoute('account.subscription.payment-method') ? 'navigation__active' : '' }}">
                            <a href="{{ route('account.subscription.payment-method') }}"><i class="zmdi zmdi-card zmdi-hc-fw"></i>Método de pago</a>
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

        <footer class="footer hidden-xs-down">
            <p>Geeky Theory. Todos los derechos reservados.</p>

            <ul class="nav footer__nav">
                <a class="nav-link" href="">Inicio</a>
                <a class="nav-link" href="">Cursos</a>
                <a class="nav-link" href="">Blog</a>
                <a class="nav-link" href="">Sobre nosotros</a>
                <a class="nav-link" href="">Soporte</a>
            </ul>
        </footer>
    </section>
</main>

<!-- Older IE warning message -->
<!--[if IE]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade to any of the following web browsers to access this website.</p>

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
<script src="/account/vendor/flot/jquery.flot.js"></script>
<script src="/account/vendor/flot/jquery.flot.resize.js"></script>
<script src="/account/vendor/flot.curvedlines/curvedLines.js"></script>
<script src="/account/vendor/jqvmap/dist/jquery.vmap.min.js"></script>
<script src="/account/vendor/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="/account/vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="/account/vendor/salvattore/dist/salvattore.min.js"></script>
<script src="/account/vendor/jquery.sparkline/jquery.sparkline.min.js"></script>
<script src="/account/vendor/moment/min/moment.min.js"></script>
<script src="/account/vendor/fullcalendar/dist/fullcalendar.min.js"></script>

<!-- App functions and actions -->
<script src="/account/js/app.min.js"></script>

@yield('customJavascript')

</body>
</html>