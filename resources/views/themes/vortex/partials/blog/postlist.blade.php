<section id="posts" class="module">
    <div class="container">
        <div class="row multi-columns-row">
            @foreach($posts as $post)
                <!-- POST -->
                <div class="col-sm-6 col-md-4 col-lg-4 m-b-60">
                    <div class="post">
                        <div class="post-media">
                            <a href="blog-single.html">
                                <img src="{{ \App\Http\Controllers\ImageManagerController::PATH_IMAGE_UPLOADS. '/' . $post->image }}" alt="">
                            </a>
                        </div>
                        <div class="post-meta font-alt">
                            Por <a href="blog-grid.html#">{{ $post->name }}</a>
                        </div>
                        <div class="post-header">
                            <h4 class="post-title font-alt">
                                <a href="{{ url($post->slug) }}">{{ $post->title }}</a>
                            </h4>
                        </div>
                        <div class="post-entry">
                            <p>{{ $post->description }}</p>
                        </div>
                        <div class="post-more-link font-alt">
                            <a href="blog-single.html">{{ trans('public.read_more') }}</a>
                        </div>
                    </div>
                </div>
                <!-- /POST -->
            @endforeach

        </div>
        <!-- PAGINATION -->
        <div class="row">

            <div class="col-sm-12 text-center m-t-60">
                <ul class="pagination font-alt">
                    <li><a href="blog-grid.html#"><i class="fa fa-angle-left"></i></a></li>
                    <li><a href="blog-grid.html#">1</a></li>
                    <li class="active"><a href="blog-grid.html#">2</a></li>
                    <li><a href="blog-grid.html#">3</a></li>
                    <li><a href="blog-grid.html#"><i class="fa fa-angle-right"></i></a></li>
                </ul>
            </div>

        </div>
        <!-- /PAGINATION -->

    </div>

</section>