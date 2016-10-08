<div class="comments comments-container">
    <h4 class="comment-title font-alt">{{ $commentCount }} {{ trans('public.comments') }}</h4>
    <hr class="divider m-b-30">

    {!! \App\Http\Controllers\CommentController::showCommentsOrdered($comments) !!}

</div>

<!-- COMMENT FORM -->
<div class="comment-form">
    <h4 class="comment-form-title font-alt">{{ trans('public.leave_comment') }}</h4>
    <hr class="divider m-b-30">
    <div class="alert alert-success comment-success-alert" style="display: none;">
        <i class="icon fa fa-check"></i>
        <span class="comment-success-message">{{ trans('public.success_creating_comment') }}</span>
    </div>
    <div class="alert alert-danger comment-error-alert" style="display: none;">
        <i class="icon fa fa-warning"></i>
        <span class="comment-error-message">{{ trans('public.error_creating_comment') }}</span>
    </div>
    <div class="alert alert-warning comment-spam-alert" style="display: none;">
        <i class="icon fa fa-info"></i>
        <span class="comment-spam-message">{{ trans('public.comment_pending_approval') }}</span>
    </div>
    <div class="row">
        @include('themes.vortex.partials.blog.commentForm')
    </div>
</div>
<!-- /COMMENT FORM -->