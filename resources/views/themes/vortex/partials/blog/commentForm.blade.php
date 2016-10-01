{!! Form::open(['class' => 'form form-new-comment', 'data-postid' => $post->id, 'data-parent' => isset($commentParent) ? $commentParent : '']) !!}
<div class="form-group">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::text('author_name', '', ['class' => 'form-control', 'placeholder' => trans('public.name')]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::email('author_email', '', ['class' => 'form-control', 'placeholder' => trans('public.email')]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::text('author_url', '', ['class' => 'form-control', 'placeholder' => trans('public.website')]) !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => '6', 'id' => 'message']) !!}
        </div>
    </div>
    <div class="col-md-12">
        {!! Form::submit(trans('public.post_comment') ,['class' => 'btn btn-round btn-g']) !!}
    </div>
</div>
{!! Form::close() !!}
