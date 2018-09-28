<section class="slice-xs">
    <span class="mask mask-dark--style-1"></span>
    <div class="container relative">
        <div class="row cols-xs-space cols-sm-space cols-md-space align-items-center text-left">
            <div class="col-12 ml-lg-auto">
                <div id="lesson-video" data-lesson-id="{{ $lesson->id }}" class="lesson-video embed-responsive embed-responsive-16by9">
                    {!! $lesson->video !!}
                    @if (!is_null($previousLesson))
                        <div class="lesson-navigation-button previous">
                            <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $previousLesson->slug]) }}">
                                <span class="fa fa-chevron-left"></span>
                                <div class="lesson-navigation-title lesson-navigation-previous">
                                    {{ $previousLesson->title }}
                                </div>
                            </a>
                        </div>
                    @endif
                    @if(!is_null($nextLesson))
                        <div class="lesson-navigation-button next">
                            <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $nextLesson->slug]) }}">
                                <div class="lesson-navigation-title lesson-navigation-next">
                                    {{ $nextLesson->title }}
                                </div>
                                <span class="fa fa-chevron-right"></span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>