<section id="posts" class="module">
    <div class="container adsense-banner">
        @if ($siteMeta->adsense_enabled)
            {!! $siteMeta->adsense_script !!}
        @endif
    </div>
    <div class="container">
        <div class="row multi-columns-row">
            @foreach($posts as $post)
                @include('themes.vortex.partials.index.postitem')
            @endforeach
        </div>
        <div class="adsense-banner">
            @if ($siteMeta->adsense_enabled)
                {!! $siteMeta->adsense_script !!}
            @endif
        </div>
        <!-- PAGINATION -->
        <div class="row">
            <div class="col-sm-12 text-center m-t-60">
                {!! $posts !!}
            </div>
        </div>
        <!-- /PAGINATION -->
    </div>
</section>