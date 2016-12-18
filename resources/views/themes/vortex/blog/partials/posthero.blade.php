<!-- HERO -->
<section class="module module-parallax bg-light-30"
         style="background-image: url('{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($post->image) }}');">
    <!-- HERO TEXT -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                @if ($post->show_title)
                    <h1 class="mh-line-size-3 font-alt m-b-20">{{ $post->title }}</h1>
                @endif
                @if ($post->show_description)
                    <h5 class="mh-line-size-4 font-alt">{{ $post->description }}</h5>
                @endif
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    @include('themes.vortex.partials.blog.social-share')
                </div>
            </div>
        </div>
    </div>
    <!-- /HERO TEXT -->
</section>
<!-- /HERO -->