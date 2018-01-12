@extends('account.layout')

@section('pageTitle')
    {{ trans('home.account') }}
@endsection

@section('contentTitle')

@endsection

@section('contentSubtitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12">
            @include('account.partials.bannerGoPro')
            <?php $chunks = $courses->chunk(3); ?>
            @foreach  ($chunks as $coursesChunk)
                <div class="row">
                    @foreach ($coursesChunk as $course)
                        <div class="col-lg-4 col-md-4">
                            <div class="card">
                                @if ($course->isPublished())
                                    <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                        <img class="card-img-top" src="{{ $course->image }}">
                                    </a>
                                @else
                                    <img class="card-img-top" src="{{ $course->image }}">
                                @endif
                                <div class="card-header">
                                    <h1 class="card-title text-center">
                                        @if ($course->isPublished())
                                            <a href="{{ route('course', ['slug' => $course->slug]) }}">{{ $course->title }}</a>
                                        @else
                                            {{ $course->title }}
                                        @endif
                                    </h1>
                                    <small class="card-subtitle">
                                        @if ($course->difficulty == \App\Course::DIFFICULTY_BEGGINER)
                                            <?php $badgeClass = 'badge-success'; ?>
                                        @elseif ($course->difficulty == \App\Course::DIFFICULTY_INTERMEDIATE)
                                            <?php $badgeClass = 'badge-info'; ?>
                                        @else
                                            <?php $badgeClass = 'badge-danger'; ?>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ trans('public.' . $course->difficulty) }}
                                                </span>
                                            </div>
                                            <div class="col-lg-6">
                                                <span>
                                                    @if ($course->isPublished())
                                                        <strong>¡Ya está disponible!</strong>
                                                    @else
                                                        <strong>Próximamente</strong>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection