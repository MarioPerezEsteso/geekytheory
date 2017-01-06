<div class="comment clearfix" data-parent="{{ $comment->parent }}" xmlns="http://www.w3.org/1999/html">
    <div class="comment-avatar">
        <img src="{{ \App\Http\Controllers\CommentController::getAuthorAvatar($comment) }}" alt="">
    </div>
    <div class="comment-content clearfix">
        <h5 class="comment-author font-alt">
            <a href="#{{ trans('public.comment') . '-' . $comment->id }}" name="{{ trans('public.comment') . '-' . $comment->id }}">{{ $comment->author_name }}</a>
            <span class="comment-date">
                · {{ \App\Http\Controllers\CommentController::getDateFormatted($comment->created_at) }}
            </span>
        </h5>
        <div class="comment-body">
            <p>
                {{ $comment->body }}
            </p>
        </div>
        <div class="reply-container">
            <div class="comment-meta font-alt">
                <a href="#" class="reply-comment-button" data-in-reply-to="{{ $comment->id }}">
                    {{ trans('public.reply') }}
                </a>
            </div>
            <div data-in-reply-to="{{ $comment->id }}" class="reply-comment-form"></div>
        </div>
    </div>
</div>
<div class="comment clearfix comment-reply-container" data-comment="{{ $comment->id }}"></div>
@if (count($comment->children) > 0)
    <div class="comment clearfix">
        {!! \App\Http\Controllers\CommentController::showCommentsOrdered($comment->children) !!}
    </div>
@endif