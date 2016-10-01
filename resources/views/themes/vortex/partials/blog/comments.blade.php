<div class="comments comments-container">
    <h4 class="comment-title font-alt">{{ $commentCount }} {{ trans('public.comments') }}</h4>
    <hr class="divider m-b-30">

    {!! \App\Http\Controllers\CommentController::showCommentsOrdered($comments) !!}

</div>

<!-- COMMENT FORM -->
<div class="comment-form">
    <h4 class="comment-form-title font-alt">{{ trans('public.leave_comment') }}</h4>
    <hr class="divider m-b-30">
    <div class="row">
        @include('themes.vortex.partials.blog.commentForm')
    </div>
</div>
<!-- /COMMENT FORM -->