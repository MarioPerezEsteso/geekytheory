<section id="hero" class="module-hero module-parallax module-full-height bg-light-30" data-background="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->image) }}" style="background-image: url('{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->image) }}')">
    <div class="hero-caption">
        <div class="hero-text">
            <h1 class="mh-line-size-1 font-alt m-b-50">{{ $siteMeta->title }}</h1>
            <h5 class="mh-line-size-4 font-alt">{{ $siteMeta->subtitle }}</h5>
        </div>
    </div>
</section>