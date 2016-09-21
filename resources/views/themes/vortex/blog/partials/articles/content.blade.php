<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <article class="post post-single">
                    <div class="post-meta font-alt">
                        @if ($siteMeta->show_author_post)
                            {{ trans('public.by') }}
                            <a href="{{ url('/user/' . $post->user->username) }}">{{ $post->user->name }}</a>

                            {{ trans('public.in') }}
                        @endif
                        <?php $categories = $post->categories; ?>
                        @if(count($categories) > 0)
                            <?php $catLinks = []; ?>
                            @foreach($categories as $category)
                                <?php $catLinks[] = "<a href='/category/" . $category->slug . "'>" . $category->category . "</a>"; ?>
                            @endforeach
                            {!! implode(', ', $catLinks) !!}
                        @endif
                    </div>
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