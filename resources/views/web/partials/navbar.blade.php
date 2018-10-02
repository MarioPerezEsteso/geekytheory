<nav class="navbar navbar-expand-lg navbar--bold navbar-inverse bg-base-2">
    <div class="container navbar-container">
        <!-- Brand/Logo -->
        <a class="navbar-brand" href="{{ config('app.url') }}">
            <img src="/assets/images/logo/logo-geeky-theory.png" class="d-none d-lg-inline-block" alt="Geeky Theory">
            <img src="/assets/images/logo/logo-geeky-theory.png" class="d-lg-none" alt="Boomerang">
        </a>

        <div class="d-inline-block">
            <!-- Navbar toggler  -->
            <button class="navbar-toggler hamburger hamburger-js hamburger--spring" type="button" data-toggle="collapse" data-target="#navbar_main">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>

        <div class="collapse navbar-collapse align-items-center justify-content-end" id="navbar_main">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="{{ route('courses') }}" class="nav-link">Cursos</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                </li>
                @if(!isset($user))
                    <li class="nav-item dropdown">
                        <a href="{{ route('login') }}" class="nav-link">Iniciar sesión</a>
                    </li>
                @endif
            </ul>
        </div>

        @if(!isset($user) || (isset($user) && !$user['premium']))
            <div class="pl-4 d-none d-lg-inline-block">
                <a href="{{ route('pricing') }}" class="btn btn-styled btn-sm btn-base-5 text-uppercase btn-circle">
                    Comenzar ahora
                </a>
            </div>
        @endif
    </div>
</nav>