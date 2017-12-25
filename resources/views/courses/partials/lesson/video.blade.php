<div class="jumbotron jumbotron-post">
    <div class="container container-post">
        <div class="row">
            <div class="col-lg-push-1 col-lg-10 col-md-12 col-sm-12 col-xs-12">
                <div class="lesson-video embed-responsive embed-responsive-16by9">
                    {!! $lesson->video !!}
                    @if (!is_null($previousLesson))
                        <div class="lesson-navigation-button previous">
                            <a href="{{ route('course.lesson', ['courseSlug' => $course->slug, 'lessonSlug' => $previousLesson->slug]) }}">
                                <span class="fui-arrow-left"></span>
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
                                <span class="fui-arrow-right"></span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>