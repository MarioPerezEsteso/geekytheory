@extends('home.layout')

@section('title')
    {{ trans('home.new_post') }}
@endsection

@section('pageTitle')
    {{ trans('home.new_post') }}
@endsection

@section('pageDescription')
    {{ trans('home.new_post_page_description') }}
@endsection

@section('content')
    @if (!empty($post))
        {!! Form::model($post, ['url' => 'home/posts/update/' . $post->id, 'files' => true, 'class' => 'form']) !!}
    @else
        {!! Form::open(['url' => 'home/posts/store', 'files' => true, 'class' => 'form']) !!}
    @endif
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
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3', 'id' => 'post-description']) !!}
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
                            <button class="btn btn-primary">
                                <i class="glyphicon glyphicon-floppy-disk"></i>
                                {{ trans('home.save_draft') }}
                            </button>
                        @endif
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('home.status') }}</label>
                            <select name='status' class="form-control">
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
                            <a href="/home/posts" class="btn btn-danger">
                                <i class="glyphicon glyphicon-trash"></i>
                                {{ trans('home.move_to_trash') }}
                            </a>
                        @endif
                    </div>
                    <div class="col-md-5 col-md-offset-2">
                        @if(empty($post))
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="glyphicon glyphicon-bullhorn"></i>
                                {{ trans('home.publish') }}
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary btn-block">
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
    </div>
    {!! Form::close() !!}
@endsection

@section('custom-javascript')
    {!! Html::script('assets/js/tinymce/tinymce.min.js') !!}
    {!! Html::script('admin/assets/js/post.js') !!}
@endsection