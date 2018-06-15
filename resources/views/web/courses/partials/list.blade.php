@foreach  ($courses->chunk(3) as $coursesChunk)
    <div class="row cols-md-space cols-sm-space cols-xs-space">
        @foreach ($coursesChunk as $course)
            <div class="col-lg-4">
                <div class="card z-depth-2--hover">
                    <div class="card-image">
                        <a href="{{ route('course', ['slug' => $course->slug]) }}">
                            <img src="{{ $course->image }}">
                        </a>
                    </div>
                    @if ($course->isPublished())
                        <div class="progress" style="height: 2px;">
                            <?php $percentageCompleted = $course->lessons_completed * 100 / $course->getTotalLessonsCount();?>
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ $percentageCompleted }}%;"
                                 aria-valuenow="{{ $percentageCompleted }}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">
                            @if ($course->isPublished())
                                <a href="{{ route('course', ['slug' => $course->slug]) }}">
                                    {{ $course->title }}
                                </a>
                            @else
                                {{ $course->title }}
                            @endif
                        </h4>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h6 class="heading heading-sm strong-400 text-muted mb-0">
                                    @if ($course->isPublished())
                                        {{ formatSecondsToHoursAndMinutes($course->duration) }}
                                    @endif
                                </h6>
                            </div>
                            <div class="col-4 text-center">
                                @if (($course->isPublished() && $course->isPremium()) || !$course->isPublished())
                                    <i class="fa fa-lock text-muted" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-unlock text-muted" aria-hidden="true"></i>
                                @endif
                            </div>
                            <div class="col-4 text-right">
                                <h6 class="heading heading-sm strong-400 text-muted mb-0">
                                    @if ($course->isPublished())
                                        @if (!is_null($course->lessons_completed) && $course->lessons_completed > 0)
                                            {{ $course->lessons_completed }}
                                            /{{ $course->getTotalLessonsCount() }} vistas
                                        @else
                                            {{ $course->getTotalLessonsCount() }} lecciones
                                        @endif
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <span class="space-xs-sm"></span>
@endforeach