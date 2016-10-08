<section class="module">
    <div class="container adsense-banner">
        @if ($siteMeta->adsense_enabled)
            {!! $siteMeta->adsense_script !!}
        @endif
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                @include('themes.vortex.partials.blog.article')

                @if ($siteMeta->show_author_post)
                    @include('themes.vortex.partials.blog.author')
                @endif
            </div>
        </div>
        @if($post->allow_comments)
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    @include('themes.vortex.partials.blog.comments')
                </div>
            </div>
        @endif
    </div>
</section>