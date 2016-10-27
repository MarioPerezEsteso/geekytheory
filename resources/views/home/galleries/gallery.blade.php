@extends('home.layout')

@section('title')
    {{ trans('home.new_gallery') }}
@endsection

@section('pageTitle')
    {{ trans('home.new_gallery') }}
@endsection

@section('pageDescription')
    {{ trans('home.new_gallery_page_description') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-10">
            @include('home.posts.partials.formMessages')
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.create_your_gallery') }}</h3>
                </div>
                {!! Form::model($siteMeta, ['url' => 'home/gallery/create', 'class' => 'form', 'files' => true]) !!}
                <div class="box-body">
                    <div class="form-group">
                        <label for="title">{{ trans('home.title') }}</label>
                        <input type="text" class="form-control" id="title"
                               placeholder="{{ trans('home.gallery_title') }}">
                    </div>
                    <div class="row top15" id="gallery-images-container">
                    </div>
                </div>
                <div class="box-footer">
                        <span class="btn btn-primary btn-file">
                            Subir imágenes
                            <input id="image-file-input" class="js-file-input" data-image="image" name="images[]"
                                   type="file" multiple>
                        </span>
                    {!! Form::submit(trans('home.save'),['class' => 'btn btn-primary pull-right']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('custom-javascript')
    {!! Html::script('admin/assets/js/galleries.js') !!}
@endsection
