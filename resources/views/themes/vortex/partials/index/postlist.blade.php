<section id="posts" class="module">
    <div class="container adsense-banner">
        @if ($siteMeta->adsense_enabled)
            {!! $siteMeta->adsense_script !!}
        @endif
    </div>
    <div class="container">
        <div class="row multi-columns-row">
            <?php $counter = 0; ?>
            <?php $adsensePosition = rand(1, count($posts) - 2); ?>
            @foreach($posts as $post)
                @if ($counter == $adsensePosition && $siteMeta->adsense_postlist_enabled) 
                    <div class="col-sm-6 col-md-4 col-lg-4 m-b-60">
                        <div class="post">
                            {!! $siteMeta->adsense_postlist_script !!}
                        </div>
                    </div>
                @endif
                @include('themes.vortex.partials.index.postitem')
                <?php $counter++; ?>
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