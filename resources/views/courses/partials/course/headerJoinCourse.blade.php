{{--<div class="jumbotron jumbotron-course center-flex gradient-blue-geeky">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <span class="btn btn-info">{{ trans('public.' . $course->difficulty) }}</span>
                <h1 class="jumbotron-title">{{ $course->title }}</h1>
                <p>{!! $course->description !!}</p>
                @if ($userHasJoinedCourse)
                    <span class="btn btn-info">Estás matriculado en este curso</span>
                @else
                    {!! Form::open(['url' => route('course.join.post', ['id' => $course->id])]) !!}
                    {!! Form::submit("Apuntarme" ,['class' => 'btn btn-primary btn-join-course']) !!}
                    {!! Form::close() !!}
                @endif
            </div>
            <div class="col-lg-5 col-lg-push-1 hidden-xs hidden-sm hidden-md">
                <img class="img-responsive" src="{{ $course->image_thumbnail }}">
            </div>
        </div>
    </div>
</div>--}}

<div class="jumbotron jumbotron-course center-flex gradient-blue-geeky">
    <div class="container">
        <div class="row">
            {{--<div class="col-lg-1">
                <img class="img-responsive" src="{{ $course->image_thumbnail }}">
            </div>--}}
            <div class="col-lg-12">
                <h1 class="jumbotron-title">{{ $course->title }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="embed-responsive embed-responsive-16by9">
                    {!! $course->chapters->first()->lessons->first()->video !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="row course-header-item">
                    <div class="col-lg-12">
                        <span class="fui-video course-header-item-icon"></span>
                        {{ $course->getTotalLessonsCount() }} {{ trans('public.lessons') }}

                    </div>
                </div>
                <div class="row course-header-item">
                    <div class="col-lg-12">
                        <span class="fui-time course-header-item-icon"></span>
                        {{ formatSecondsToHoursAndMinutes($course->duration) }}
                    </div>
                </div>
                <div class="row course-header-item">
                    <div class="col-lg-12">
                        <span class="fui-radio-checked course-header-item-icon"></span>
                        {{ trans('public.' . $course->difficulty) }}
                    </div>
                </div>
                <div class="row course-header-item">
                    <div class="col-lg-12">
                        <button class="btn btn-info course-header-item">
                            Comenzar curso <span class="fui-triangle-right-large course-header-item-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--{!!  $course->chapters->first()->lessons->first()->video !!}--}}