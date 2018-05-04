@extends('themes.vortex.blog.layout')

@section('postTitle')
    {{ $post->title }}
@endsection

@section('postDescriptionMeta')
    {{ $post->description }}
@endsection

@section('content')
    <div class="container post-container">

        @if (showBanner($user, $siteMeta))
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    {!! $siteMeta->adsense_script !!}
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <article class="post post-single">
                    <div class="post-meta font-alt">
                        {{ trans('public.by') }}
                        <a href="{{ url('/user/' . $post->user->username) }}">{{ $post->user->name }}</a>

                        @if(count($post->categories) > 0)
                            {{ trans('public.in') }}
                        @endif

                        @if(count($post->categories) > 0)
                            <?php $catLinks = []; ?>
                            @foreach($post->categories as $category)
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

                </article>

                {{--<div class="tags">
                    @foreach($post->tags as $tag)
                        @include('themes.vortex.partials.blog.tags')
                    @endforeach
                </div>--}}

                {{--<div class="row">
                    <div class="col-sm-12 text-center">
                        @include('themes.vortex.partials.blog.social-share')
                    </div>
                </div>--}}

                {{--@include('themes.vortex.partials.blog.author')--}}
            </div>
        </div>

        @if (showBanner($user, $siteMeta))
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    {!! $siteMeta->adsense_script !!}
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="alert alert-telegram">
                        <div class="row">
                            <div class="col-sm-1">
                                <a href="https://goo.gl/eyS32z" target="_blank">
                                    <img src="/images/telegram.png" class="img-responsive">
                                </a>
                            </div>
                            <div class="col-sm-11">
                                <a href="https://goo.gl/eyS32z" target="_blank">
                                    ¿Quieres estar al día de lo que pasa en Geeky Theory? ¡Únete a nuestro canal de
                                    Telegram
                                    aquí!
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--@if($post->allow_comments)
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    @include('themes.vortex.partials.blog.comments')
                </div>
            </div>
        @endif--}}
    </div>

    <section class="container-fluid section-gray section-courses">
        @include('courses.partials.courses')
    </section>
@endsection

@section('custom-javascript')
    {!! Html::script('themes/vortex/assets/js/app/comments.min.js') !!}
    {!! Html::script('themes/vortex/assets/js/app/social-share.min.js') !!}
@endsection
