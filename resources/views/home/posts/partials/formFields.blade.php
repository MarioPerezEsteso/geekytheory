<div class="col-md-9">
    @include('home.posts.partials.formMessages')
    <div class="form-group">
        {!! Form::text('title', null, ['class' => 'form-control post-edit-title', 'required' => 'required', 'placeholder' => trans('home.post_title')]) !!}
    </div>
    <div class="form-group">
        {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => '20', 'id' => 'post-body']) !!}
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title margin-r-5">{{ trans('home.description') }}</h3>
            <?php $length = 0; ?>
            @if (!empty($post))
                <?php $length = strlen($post->description); ?>
            @endif
            <label id="post-description-length">
                ({{ $length }}/170)
            </label>
        </div>
        <div class="box-body">
            <div class="form-group">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3', 'required' => true, 'id' => 'post-description']) !!}
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('home.actions') }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @if(empty($post) || (!empty($post) && $post->status == \App\Http\Controllers\PostController::POST_STATUS_DRAFT))
                        <button type="submit" class="btn btn-primary margin-r-5" name="action" value="{{ \App\Http\Controllers\PostController::POST_ACTION_UPDATE }}">
                            <i class="glyphicon glyphicon-floppy-disk"></i>
                            {{ trans('home.save_draft') }}
                        </button>
                    @endif
                    @if(!empty($post) && $post->status != \App\Http\Controllers\PostController::POST_STATUS_DELETED)
                        <?php $viewButtonHref = url(\App\Http\Controllers\PostController::getPostDashboardUrlByType($post) . 'preview/' . $post->slug); ?>
                        <?php $viewButtonText = trans('home.preview'); ?>
                        @if($post->status == \App\Http\Controllers\PostController::POST_STATUS_PUBLISHED)
                            <?php //$viewButtonHref = $siteMeta->url . '/' . $post->slug; ?>
                            <?php $viewButtonHref = \App\Http\Controllers\PostController::getPostPublicUrlByType($post); ?>
                            <?php $viewButtonText = trans('home.view'); ?>
                        @endif
                        <a target="_blank" class="btn btn-default" href="{{ $viewButtonHref }}">
                            <i class="glyphicon glyphicon-eye-open"></i>
                            {{ $viewButtonText }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('home.status') }}</label>
                        <select name='status' class="form-control">
                            @if(!empty($post) && $post->status == \App\Http\Controllers\PostController::POST_STATUS_PUBLISHED)
                                <option value="{{ \App\Http\Controllers\PostController::POST_STATUS_PUBLISHED }}">
                                    {{ trans('home.status_published') }}
                                </option>
                            @endif
                            <option value="{{ \App\Http\Controllers\PostController::POST_STATUS_DRAFT }}">
                                {{ trans('home.status_draft') }}
                            </option>
                            <option value="{{ \App\Http\Controllers\PostController::POST_STATUS_PENDING }}">
                                {{ trans('home.status_pending') }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-5">
                    @if(empty($post))
                        <a href="/home/posts" class="btn btn-danger">
                            <i class="glyphicon glyphicon-trash"></i>
                            {{ trans('home.move_to_trash') }}
                        </a>
                    @else
                        <a href="/home/posts/delete/{{ $post->id }}" class="btn btn-danger">
                            <i class="glyphicon glyphicon-trash"></i>
                            {{ trans('home.move_to_trash') }}
                        </a>
                    @endif
                </div>
                <div class="col-md-5 col-md-offset-2">
                    @if(empty($post) || (!empty($post) && $post->status == \App\Http\Controllers\PostController::POST_STATUS_DRAFT))
                        <button type="submit" class="btn btn-primary btn-block" name="action" value="{{ \App\Http\Controllers\PostController::POST_ACTION_PUBLISH }}">
                            <i class="glyphicon glyphicon-bullhorn"></i>
                            {{ trans('home.publish') }}
                        </button>
                    @else
                        <button type="submit" class="btn btn-primary btn-block" name="action" value="{{ \App\Http\Controllers\PostController::POST_ACTION_UPDATE }}">
                            <i class="glyphicon glyphicon-refresh"></i>
                            {{ trans('home.update') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('home.categories') }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @if(empty($categories))
                        {{ trans('home.create_categories') }}
                    @else
                        <div class="scrollable-box">
                            @if(!empty($post))
                                @foreach($post->categories as $category)
                                    <? /** @var $category \App\Category */?>
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" checked/> {{ $category->category }} <br/>
                                @endforeach
                            @endif
                            @foreach($categories as $category)
                                <? /** @var $category \App\Category */?>
                                @if(empty($post) || (!empty($post) && !$post->categories->contains($category)))
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"/> {{ $category->category }} <br/>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('home.post_image') }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?php $imgSrc = ""; ?>
                    <?php $postId = ""; ?>
                    @if(!empty($post))
                        <?php $postId = $post->id; ?>
                        @if(!empty($post->image))
                            <?php $imgSrc = \App\Http\Controllers\ImageManagerController::getPublicImageUrl($post->image); ?>
                        @endif
                    @endif
                    <img id="post-image" data-post-id="{{ $postId }}" class="img-responsive" src="{{ $imgSrc }}"/>
                </div>
            </div>
            <div class="row top15">
                <div class="col-md-12">
                        <span class="btn btn-primary btn-file">
                            {{ trans('home.browse') }}
                            {!! Form::file('image', array('id' => 'post-image-file-input')) !!}
                        </span>
                    <button id="delete-post-image" class="btn btn-danger {{ (!empty($imgSrc)) ? '' : ' hidden ' }}"><i class="glyphicon glyphicon-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('home.options') }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                            <input name="show_title" type="checkbox" {{ (empty($post) || !empty($post) && $post->show_title) ? 'checked' : '' }}> {{ trans('home.show_post_title') }}
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="show_description" type="checkbox" {{ (empty($post) || !empty($post) && $post->show_description) ? 'checked' : '' }}> {{ trans('home.show_post_description') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>