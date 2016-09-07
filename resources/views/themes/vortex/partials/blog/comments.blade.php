<div class="comments">
    <h4 class="comment-title font-alt">{{ $commentCount }} comments</h4>
    <hr class="divider m-b-30">

    {!! \App\Http\Controllers\CommentController::showCommentsOrdered($comments) !!}

</div>

@include('themes.vortex.partials.blog.commentForm')
