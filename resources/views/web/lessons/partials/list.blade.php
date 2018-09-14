<div class="block block--style-3 list z-depth-2-top course-content-container">
    @foreach($course->chapters as $chapter)
        <div class="block-footer border-top">
            <div class="row h-100">
                <div class="col">
                    <h4 class="heading heading-md my-auto">{{ $chapter->title }}</h4>
                </div>
            </div>
        </div>
        <?php $lessonIndex = 1; ?>
        @foreach($chapter->lessons as $lesson)
            <div class="block-footer border-top">
                <div class="row h-100">
                    <div class="col-lg-9 col-md-10 col-sm-9 col-12">
                        <div class="row">
                            <div class="col-lg-1 col-md-2 col-3 my-auto">
                                @if (!empty($lesson->icon))
                                    <img class="lesson-icon" src="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($lesson->icon, false, true) }}"/>
                                    @if ($lesson->completed === true)
                                        <i class="lesson-completed-icon lesson-completed-icon-over-icon fa fa-check-circle"></i>
                                    @endif
                                @else
                                    @if ($lesson->completed === true)
                                        <i class="lesson-completed-icon fa fa-check-circle"></i>
                                    @endif
                                @endif
                            </div>
                            <div class="col-9 col-lg-11 my-auto">
                                <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug]) }}"
                                   class="lesson-link">
                                    {{ $chapter->order }}.{{ $lessonIndex++ }}. {{ $lesson->title }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-2 col-sm-3 d-none d-sm-block text-right my-auto">
                        <div class="lesson-info-time">
                            <i class="fa fa-clock-o"></i>
                            {{ formatSeconds($lesson->duration) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>