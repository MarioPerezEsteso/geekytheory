<div class="hero-section"
     style="background-image: url('{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->image) }}');background-size:cover;background-repeat:no-repeat; background-position: center center; ">
    <div class="container nopadding">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">
                <div class="hero-content">
                    <h1 class="wow fadeInDown" data-wow-delay="0.1s"
                        style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">{{ trans('public.we_are_creating') }}
                        <span class="text-hero-geeky">{{ trans('public.cool_things') }}</span>
                    </h1>
                    <p class="wow fadeInDown" data-wow-delay="0.2s"
                       style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        {{ trans('public.do_you_want_to_know_more') }}
                        <strong>{{ trans('public.join_our_newsletter') }}</strong>
                        {{ trans('public.with_more_than_number_people', ['number' => 3000]) }}
                    </p>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="input-group wow fadeInUp">
                                <input type="text" class="form-control form-control-hero" placeholder="Email">
                                <span class="input-group-btn">
                                <button class="btn btn-g btn-action-form-control" type="button">¡Únete!</button>
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>