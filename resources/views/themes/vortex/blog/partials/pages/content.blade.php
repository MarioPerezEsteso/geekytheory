<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <article class="post post-single">
                    <div class="post-header">
                        <h1 class="post-title font-alt">
                            {{ $post->title }}
                        </h1>
                    </div>
                    <div class="post-entry">
                        {!! $post->body !!}
                    </div>
                    <div class="tags">
                        @foreach($post->tags as $tag)
                            @include('themes.vortex.partials.blog.tags')
                        @endforeach
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>