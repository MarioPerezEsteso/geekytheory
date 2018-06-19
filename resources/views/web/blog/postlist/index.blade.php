@extends('web.layouts.layout')

@section('content')
    @if ($articles->currentPage() == 1)
        <section class="slice slice--offset-top bg-base-2 holder-item holder-item-dark">
            <div class="container container-sm d-flex align-items-center">
                <div class="col">
                    <div class="row py-5 text-center justify-content-center">
                        <div class="col-12 col-md-10">
                            <h2 class="heading heading-2 c-white strong-600 mt-3 animated"
                                data-animation-in="fadeIn" data-animation-delay="400">
                                Nuestras últimas publicaciones
                            </h2>
                            <span class="sd-1 sd-sm sd-thick-3px sd-center"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="slice--offset-top bg-base-2 holder-item holder-item-dark"></section>
    @endif

    <section class="slice sct-color-1" id="sct_scroll_to">
        <div class="container container-lg">
            <div class="row-wrapper">
                @for ($row = 0; $row < 4; $row++)
                    <div class="row cols-xs-space cols-sm-space cols-md-space">
                        @if ($row === 0)
                            @for($index = 0; $index < 3; $index++)
                                <?php $article = $articles->get($index); ?>
                                <div class="col-lg-4">
                                    @if ($index === 0 && !is_null($article))
                                        @include('web.blog.postlist.partials.card-white', ['article' => $article])
                                    @elseif($index === 1 && !is_null($article))
                                        @include('web.blog.postlist.partials.card-colored', ['article' => $article])
                                    @elseif($index === 2 && !is_null($article))
                                        @include('web.blog.postlist.partials.card-image', ['article' => $article])
                                    @endif
                                </div>
                            @endfor
                        @elseif ($row === 1)
                            @if (!is_null($articles->get(3)))
                                <div class="col-lg-8">
                                    @include('web.blog.postlist.partials.card-unfold-img-left', ['article' => $articles->get(3)])
                                </div>
                            @endif
                            @if (!is_null($articles->get(4)))
                                <div class="col-lg-4">
                                    @include('web.blog.postlist.partials.card-image', ['article' => $articles->get(4)])
                                </div>
                            @endif
                        @elseif ($row === 2)
                            @if (!is_null($articles->get(5)))
                                <div class="col-lg-4">
                                    @include('web.blog.postlist.partials.card-image', ['article' => $articles->get(5)])
                                </div>
                            @endif
                            @if (!is_null($articles->get(6)))
                                <div class="col-lg-8">
                                    @include('web.blog.postlist.partials.card-unfold-img-right', ['article' => $articles->get(6)])
                                </div>
                            @endif
                        @else
                            @if (!is_null($articles->get(7)))
                                <div class="col-lg-4">
                                    @include('web.blog.postlist.partials.card-white', ['article' => $articles->get(7)])
                                </div>
                            @endif
                            @if (!is_null($articles->get(8)))
                                <div class="col-lg-4">
                                    @include('web.blog.postlist.partials.card-colored', ['article' => $articles->get(8)])
                                </div>
                            @endif
                            @if (!is_null($articles->get(9)))
                                <div class="col-lg-4">
                                    @include('web.blog.postlist.partials.card-image', ['article' => $articles->get(9)])
                                </div>
                            @endif
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- PAGINATION -->
    <section class="slice sct-color-1" id="sct_scroll_to">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-md-12">
                <nav>
                    <?php
                    // config
                    $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
                    ?>

                    @if ($articles->lastPage() > 1)
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ ($articles->currentPage() == 1) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $articles->url(1) }}">Primera</a>
                            </li>
                            @for ($i = 1; $i <= $articles->lastPage(); $i++)
                                <?php
                                $half_total_links = floor($link_limit / 2);
                                $from = $articles->currentPage() - $half_total_links;
                                $to = $articles->currentPage() + $half_total_links;
                                if ($articles->currentPage() < $half_total_links) {
                                    $to += $half_total_links - $articles->currentPage();
                                }
                                if ($articles->lastPage() - $articles->currentPage() < $half_total_links) {
                                    $from -= $half_total_links - ($articles->lastPage() - $articles->currentPage()) - 1;
                                }
                                ?>
                                @if ($from < $i && $i < $to)
                                    <li class="page-item {{ ($articles->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link"
                                           href="{{ $articles->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor
                            <li class="page-item {{ ($articles->currentPage() == $articles->lastPage()) ? ' disabled' : '' }}">
                                <a class="page-link"
                                   href="{{ $articles->url($articles->lastPage()) }}">Última</a>
                            </li>
                        </ul>
                    @endif
                </nav>
            </div>
        </div>
    </section>
    <!-- /PAGINATION -->
@endsection