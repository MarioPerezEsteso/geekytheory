<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    {!! Html::style('assets/css/bootstrap/bootstrap.min.css') !!}
            <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    {!! Html::style('admin/assets/css/AdminLTE.min.css') !!}
    {!! Html::style('admin/assets/css/app.css') !!}
            <!-- AdminLTE Skin -->
    {!! Html::style('admin/assets/css/skins/skin-blue.min.css') !!}
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/home" class="logo">
            <span class="logo-mini">
                <i class="fa fa-tachometer" aria-hidden="true"></i>
            </span>
            <span class="logo-lg"><b>Admin</b>Panel</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ $user['avatar'] }}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ $user['name'] }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ $user['avatar'] }}" class="img-circle" alt="User Image">
                                <p>
                                    {{ $user['name'] }}
                                    @if (!empty($user['job']))
                                        - {{ $user['job'] }}
                                    @endif
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('home/profile') }}"
                                       class="btn btn-default btn-flat">{{ trans('home.user_profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('logout') }}"
                                       class="btn btn-default btn-flat">{{ trans('auth.logout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ $user['avatar'] }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{  $user['name'] }}</p>
                    <small>{{ $user['job'] }}</small>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="{{ classActiveRoute(array('home')) }}">
                    <a href="{{ url('home') }}">
                        <i class="fa fa-home"></i>
                        <span>{{ trans('home.home') }}</span>
                    </a>
                </li>
                <li class="{{ classActiveRoute(array('home/articles', 'home/articles/create', 'home/categories', 'home/tags')) }} treeview">
                    <a href="{{ url('home/articles') }}">
                        <i class="fa fa-book"></i>
                        <span>{{ trans('home.articles') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ classActiveRoute(array('home/articles')) }}">
                            <a href="{{ url('home/articles') }}">
                                {{ trans('home.all_articles') }}
                            </a>
                        </li>
                        <li class="{{ classActiveRoute(array('home/articles/create')) }}">
                            <a href="{{ url('home/articles/create') }}">
                                {{ trans('home.create_article') }}
                            </a>
                        </li>
                        <li class="{{ classActiveRoute(array('home/categories')) }}">
                            <a href="{{ url('home/categories') }}">
                                {{ trans('home.categories') }}
                            </a>
                        </li>
                        <li class="{{ classActiveRoute(array('home/tags')) }}">
                            <a href="{{ url('home/tags') }}">
                                {{ trans('home.tags') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ classActiveRoute(array('home/pages', 'home/pages/create')) }} treeview">
                    <a href="{{ url('home/pages') }}">
                        <i class="fa fa-book"></i>
                        <span>{{ trans('home.pages') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ classActiveRoute(array('home/articles')) }}">
                            <a href="{{ url('home/pages') }}">
                                {{ trans('home.all_pages') }}
                            </a>
                        </li>
                        <li class="{{ classActiveRoute(array('home/pages/create')) }}">
                            <a href="{{ url('home/pages/create') }}">
                                {{ trans('home.page_create') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ classActiveRoute(array('home/sitemeta', 'home/menu')) }} treeview">
                    <a href="{{ url('home/sitemeta') }}">
                        <i class="fa fa-cogs"></i>
                        <span>{{ trans('home.settings') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ classActiveRoute(array('home/sitemeta')) }}">
                            <a href="{{ url('home/sitemeta') }}">
                                <i class="fa fa-gear"></i>
                                <span>{{ trans('home.site_options') }}</span>
                            </a>
                        </li>
                        <li class="{{ classActiveRoute(array('home/menu')) }}">
                            <a href="{{ url('home/menu') }}">
                                <i class="fa fa-bars"></i>
                                <span>{{ trans('home.menu') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ classActiveRoute(array('home/profile')) }}">
                    <a href="{{ url('home/profile') }}">
                        <i class="fa fa-user"></i>
                        <span>{{ trans('home.user_profile') }}</span>
                    </a>
                </li>
                {{--<li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="#">Link in level 2</a></li>
                        <li><a href="#">Link in level 2</a></li>
                    </ul>
                </li>--}}
            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('pageTitle')
                <small>@yield('pageDescription')</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.1 -->
{!! Html::script('assets/js/jquery/jquery-2.2.1.min.js') !!}
        <!-- Bootstrap -->
{!! Html::script('assets/js/bootstrap/bootstrap.min.js') !!}
        <!-- AdminLTE App -->
{!! Html::script('admin/assets/js/app.min.js') !!}
        <!-- Custom Javascript -->
@yield('custom-javascript')
</body>
</html>
