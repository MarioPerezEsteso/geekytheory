<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="https://geekytheory.com">
                <img class="img-responsive" src="https://geekytheory.com/uploads/2017/05/logo%2032.png">
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                @foreach(json_decode($siteMeta->menu, true) as $menuItem)
                    <?php $hasSubmenu = ($menuItem['submenu'] !== null); ?>
                    @if (!$hasSubmenu)
                        <li>
                            <a href="{{ $menuItem['link'] }}"
                               title="{{ $menuItem['text'] }}">{{ $menuItem['text'] }}</a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ $menuItem['text'] }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @foreach($menuItem['submenu'] as $submenuItem)
                                    <li>
                                        <a href="{{ $submenuItem['link'] }}"
                                           title="{{ $submenuItem['text'] }}">{{ $submenuItem['text'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
</nav>
