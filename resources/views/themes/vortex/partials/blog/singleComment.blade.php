<div class="comment clearfix">
    <div class="comment-avatar">
        <img src="{{ \App\Http\Controllers\CommentController::getAuthorAvatar($comment) }}" alt="">
    </div>
    <div class="comment-content clearfix">
        <h5 class="comment-author font-alt">
            <a href="#">{{ $comment->author_name }}</a>
        </h5>
        <div class="comment-body">
            <p>
                {{ $comment->body }}
            </p>
        </div>
        <div class="comment-meta font-alt">
            Today, 14:55 - <a href="#">{{ trans('public.reply') }}</a>
        </div>
    </div>
</div>
@if (count($comment->children) > 0)
    <div class="comment clearfix">
        {!! \App\Http\Controllers\CommentController::showCommentsOrdered($comment->children) !!}
    </div>
@endif