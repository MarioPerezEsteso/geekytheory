<section id="posts" class="module">
    <div class="container">
        <div class="row multi-columns-row">
            @foreach($posts as $post)
                @include('themes.vortex.partials.index.postitem')
            @endforeach
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