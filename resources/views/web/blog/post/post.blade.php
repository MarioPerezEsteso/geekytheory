@extends('web.layouts.layout')

@section('content')
    <section class="slice--offset-top bg-base-2 holder-item holder-item-dark"></section>

    <section class="parallax-section parallax-section-xl sct-color-3 has-bg-cover bg-size-cover"
             style="background-image: url('{{ $post->image }}'); background-position: center center;">
        <span class="mask mask-dark--style-4"></span>
        <div class="container sct-inner">
            <div class="">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="heading heading-1 strong-400 c-white">
                            {{ $post->title }}
                        </h3>
                        <h4 class="heading heading-5 text-normal strong-300 c-white mt-4">
                            {{ $post->description }}
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
                    {!! $post->body !!}
                </div>
            </div>
        </div>
    </section>
@endsection