<div id="overlay-menu" class="overlay-menu">
    <a href="#" id="overlay-menu-hide" class="navigation-hide"><i class="ion-close-round"></i></a>
    <div class="overlay-menu-inner">
        <nav class="overlay-menu-nav">
            <ul id="nav">
                @foreach(json_decode($siteMeta->menu, true) as $menuItem)
                    <li>
                        <a href="{{ $menuItem['link'] }}" title="{{ $menuItem['text'] }}">{{ $menuItem['text'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    <div class="overlay-navigation-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p class="copyright font-alt m-b-0">
                        <!-- Copyright text -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>