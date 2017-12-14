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
        <div class="col-lg-8">
            @include('account.partials.bannerGoPro')
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-lg-4">
                        <div class="card">
                            <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                <img class="card-img-top" src="{{ $course->image }}">
                            </a>
                            <div class="card-header">
                                <h2 class="card-title">
                                    <a href="{{ route('course', ['slug' => $course->slug]) }}">{{ $course->title }}</a>
                                </h2>
                                <small class="card-subtitle">
                                    @if ($course->difficulty == \App\Course::DIFFICULTY_BEGGINER)
                                        <?php $badgeClass = 'badge-success'; ?>
                                    @elseif ($course->difficulty == \App\Course::DIFFICULTY_INTERMEDIATE)
                                        <?php $badgeClass = 'badge-info'; ?>
                                    @else
                                        <?php $badgeClass = 'badge-danger'; ?>
                                    @endif
                                    <span class="badge {{ $badgeClass }}">
                                    {{ trans('public.' . $course->difficulty) }}
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection