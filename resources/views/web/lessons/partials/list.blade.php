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
                    <div class="col-lg-1 col-md-2 col-2 my-auto">
                        {{ $chapter->order }}.{{ $lessonIndex++ }}
                    </div>
                    <div class="col-lg-1 col-md-2 col-2 my-auto">
                        @if ($lesson->completed === true)
                            <i class="lesson-completed-icon fa fa-check-circle"></i>
                        @elseif (!empty($lesson->icon))
                            <img class="lesson-technology-img" src="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($lesson->icon, false, true) }}"/>
                        @endif
                    </div>
                    <div class="col-8 col-lg-10 my-auto">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug]) }}" class="lesson-link">
                                    {{ $lesson->title }}
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="lesson-info-time">
                                    <i class="fa fa-clock-o"></i> {{ formatSeconds($lesson->duration) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>