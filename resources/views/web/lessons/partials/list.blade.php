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
            <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $lesson->slug]) }}"
               class="lesson-link">
                <div class="block-footer border-top">
                    <div class="row h-100">
                        <div class="col-1 my-auto">
                            {{ $chapter->order }}.{{ $lessonIndex++ }}
                        </div>
                        <div class="col-1 my-auto">
                            @if ($lesson->completed === true)
                                <i class="lesson-completed-icon fa fa-check-circle"></i>
                            @else
                                <i id="lesson-completed-icon-{{ $lesson->id }}" class="lesson-completed-icon fa fa-check-circle d-none"></i>
                                @if (!empty($lesson->icon))
                                    <img id="lesson-technology-img-{{ $lesson->id }}" class="lesson-technology-img"
                                         src="{{ \App\Http\Controllers\ImageManagerController::getPublicImageUrl($lesson->icon, false, true) }}"/>
                                @endif
                            @endif
                        </div>
                        <div class="col-9 my-auto">
                            <div class="row">
                                <div class="col-12">
                                    {{ $lesson->title }}
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
            </a>
        @endforeach
    @endforeach
</div>