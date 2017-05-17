<nav class="navbar navbar-custom navbar-transparent navbar-custom navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <img src="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->logo) }}"
                     class="navbar-logo" alt="">
            </a>
        </div>
        <!-- ICONS NAVBAR -->
        <ul id="icons-navbar" class="nav navbar-nav navbar-right visible-xs">
            <li>
                <a href="#" id="toggle-menu" class="show-overlay" title="Menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </li>
        </ul>
        <!-- /ICONS NAVBAR -->
        <ul class="extra-navbar nav navbar-nav navbar-right clearfix-menu menu">
            @foreach(json_decode($siteMeta->menu, true) as $menuItem)
                <?php $hasSubmenu = ($menuItem['submenu'] !== null); ?>
                <li>
                    <a href="{{ $menuItem['link'] }}" title="{{ $menuItem['text'] }}">
                        {{ $menuItem['text'] }}
                        @if ($hasSubmenu)
                            <i class="glyphicon glyphicon-chevron-down"></i>
                        @endif
                    </a>
                    @if ($hasSubmenu)
                        <ul class="sub-menu">
                            @foreach($menuItem['submenu'] as $submenuItem)
                                <li>
                                    <a href="{{ $submenuItem['link'] }}"
                                       title="{{ $submenuItem['text'] }}" class="color-darkblue">{{ $submenuItem['text'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
        {{--<ul class="nav navbar-right hidden-xs">
            <li>
                <form action="" class="search-form">
                    <div class="form-group has-feedback search-form-hero">
                        <input type="text" class="form-control" name="search" id="search" placeholder="{{ trans('public.search') }}">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </form>
            </li>
        </ul>--}}
    </div>
</nav>