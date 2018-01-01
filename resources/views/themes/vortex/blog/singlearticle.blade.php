@extends('themes.vortex.blog.layout')

@section('postTitle')
    {{ $post->title }}
@endsection

@section('postDescriptionMeta')
    {{ $post->description }}
@endsection

@section('content')
    <div class="container post-container">
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
        {{--@if($post->allow_comments)
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    @include('themes.vortex.partials.blog.comments')
                </div>
            </div>
        @endif--}}
    </div>
@endsection

@section('custom-javascript')
    {!! Html::script('themes/vortex/assets/js/app/comments.min.js') !!}
    {!! Html::script('themes/vortex/assets/js/app/social-share.min.js') !!}
@endsection
