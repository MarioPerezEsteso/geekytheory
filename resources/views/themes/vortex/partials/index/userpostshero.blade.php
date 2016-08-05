<section class="module module-parallax bg-light-30" style="background-image: url('{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->image) }}')">
    <!-- HERO TEXT -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img class="img-circle img-responsive center-block m-b-40" src="{{ \App\Http\Controllers\UserController::getGravatar($author->email) }}" alt="" />
                <h1 class="mh-line-size-3 font-alt m-b-20">{{ $author->name }}</h1>
                <h5 class="mh-line-size-4 font-alt">{{ $author->job }}</h5>
            </div>
        </div>
    </div>
    <!-- /HERO TEXT -->
</section>