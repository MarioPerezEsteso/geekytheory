<div class="course-content">
    @foreach($course->chapters as $chapter)
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {{ $chapter->order }}. {{ $chapter->title }}
                </h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    @foreach($chapter->lessons as $lesson)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-1 col-xs-1">
                                    @if ($lesson->completed === true)
                                        <span class="lesson-completed-icon fui-check-circle"></span>
                                    @endif
                                </div>
                                <div class="col-sm-7 col-xs-6">
                                    <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug]) }}">
                                        {{ $chapter->order }}.{{ $lesson->order }}. {{ $lesson->title }}
                                    </a>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <div class="pull-right">
                                        @if(!Auth::user())
                                            @if($course->free || $lesson->free)
                                                <div class="lesson-info-item lesson-info-free">
                                                    Gratis
                                                </div>
                                            @else
                                                <div class="lesson-info-item">
                                                    <span class="fui-lock"></span>
                                                </div>
                                            @endif
                                        @endif
                                        <div class="lesson-info-item lesson-info-time">
                                            {{ formatSeconds($lesson->duration) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>