@extends('web.layouts.layout')

@section('custom-css')
    <link type="text/css" href="/assets/css/lesson.min.css" rel="stylesheet">
@endsection

@section('custom-javascript')
<script src="/assets/vendor/disqus/js/disqus.js"></script>
<script src="/assets/vendor/highlightjs/js/highlight.pack.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('pre').each(function (i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>
@endsection

@section('content')

<section class="slice--offset-top bg-base-2 holder-item holder-item-dark"></section>

@if($showHeaderTemplate == \App\Http\Controllers\LessonController::TEMPLATE_HEADER_VIDEO)
    @include('web.lessons.partials.video')
@elseif($showHeaderTemplate == \App\Http\Controllers\LessonController::TEMPLATE_HEADER_REGISTER)
    @include('web.lessons.partials.onlyForMembers')
@endif

<section class="container-fluid" style="padding-top: 50px;">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="clearfix">
                        <h1>{{ $lesson->title }}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tabs tabs--style-2" role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tab-theory" aria-controls="home" role="tab" data-toggle="tab" class="nav-link active text-center text-normal strong-600">
                                    <i class="fa fa-book" aria-hidden="true"></i> Teoría
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tab-comments" aria-controls="profile" role="tab" data-toggle="tab" class="nav-link text-center text-normal strong-600">
                                    <i class="fa fa-comments" aria-hidden="true"></i> Comentarios
                                </a>
                            </li>
                        </ul>
                    
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab-theory">
                                <div class="tab-body">
                                    @if (!isset($user) || (isset($user) && !$user['premium']))
                                        <div class="cta-block cta-block-overlay bg-base-1 z-depth-5 text-center">
                                            <h2 class="heading heading-inverse heading-2 strong-500">
                                                ¿Quieres aprender sin límites? Lo tuyo es Premium.
                                            </h2>
                                            <a href="{{ route('pricing') }}" class="btn btn-styled btn-lg btn-white btn-outline btn-circle mt-5">
                                                Pásate a Premium
                                            </a>
                                        </div>
                                    @else
                                        {!! $lesson->content !!}
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab-comments">
                                <div class="tab-body">
                                    <div id="disqus_thread"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1"></div>
        <div class="col-3">
            <div class="row">
                <div class="col-12">
                    @include('web.lessons.partials.list')
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
