@extends('web.layouts.layout')

@section('content')
    <section class="slice--offset-top bg-base-2 holder-item holder-item-dark"></section>

    <section class="parallax-section parallax-section-xl sct-color-3 has-bg-cover bg-size-cover"
             style="background-image: url('{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($article->image, false, true) }}'); background-position: center center;">
        <span class="mask mask-dark--style-4"></span>
        <div class="container sct-inner">
            <div class="">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="heading heading-1 strong-400 c-white">
                            {{ $article->title }}
                        </h3>
                        <h4 class="heading heading-5 text-normal strong-300 c-white mt-4">
                            {{ $article->description }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="slice-sm sct-color-1">
        <div class="container container-xs">
            <div class="block block-post">
                <div class="block-body block-post-body">
                    {!! $article->body !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-css')
    <!-- Syntax highlighting -->
    <link rel="stylesheet" href="../../assets/vendor/highlightjs/css/styles/atom-one-dark.css" type="text/css">
@endsection

@section('custom-javascript')
    <script src="../../assets/vendor/highlightjs/js/highlight.pack.js"></script>
    <script src="../../assets/vendor/highlightjs/js/highlight-pre-blocks.js"></script>
@endsection