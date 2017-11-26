<div class="jumbotron jumbotron-course center-flex gradient-blue-geeky">
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
            <div class="col-lg-5 col-lg-push-1">
                <img class="img-responsive" src="{{ $course->image_thumbnail }}">
            </div>
        </div>
    </div>
</div>