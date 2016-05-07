<footer class="module bg-light">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="social-text-links font-alt text-center m-b-20">
                    @foreach(\App\Http\Controllers\Controller::$socialNetworks as $socialNetwork)
                        @if(!empty($siteMeta->$socialNetwork))
                            <li>
                                <a href="{{ $siteMeta->socialNetwork }}">{{ trans('public.' . $socialNetwork) }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p class="copyright text-center m-b-0">© 2015 <a href="index.html#">Vortex</a>, All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>