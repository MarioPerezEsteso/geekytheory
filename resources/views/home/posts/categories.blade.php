@extends('home.layout')

@section('title')
    {{ trans('home.categories') }}
@endsection

@section('pageTitle')
    {{ trans('home.categories') }}
@endsection

@section('pageDescription')
    {{ trans('home.categories_page_description') }}
@endsection

@section('content')
    <div class="col-md-6">

        @include('home.posts.partials.formMessages')

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    @if (empty($category))
                        {{ trans('home.category_add') }}
                    @else
                        {{ trans('home.category_edit') }}
                    @endif
                </h3>
            </div>
            <div class="box-body">
                @if (!empty($category))
                    {!! Form::model($category, ['url' => 'home/categories/update/' . $category->id, 'files' => true, 'class' => 'form']) !!}
                @else
                    {!! Form::open(['url' => 'home/categories/store', 'files' => true, 'class' => 'form']) !!}
                @endif
                <div class="form-group">
                    {!! Form::label('category', trans('home.category_min')) !!}
                    {!! Form::text('category', null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('slug', trans('home.slug')) !!}
                    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::label('image', trans('home.upload_image')) !!}
                            <?php $imgSrc = ""; ?>
                            <?php $categoryId = ""; ?>
                            @if(!empty($category))
                                <?php $categoryId = $category->id; ?>
                                @if(!empty($category->image))
                                    <?php $imgSrc = \App\Http\Controllers\ImageManagerController::getPublicImageUrl($category->image); ?>
                                @endif
                            @endif
                            <img id="post-image" data-post-id="{{ $categoryId }}" class="img-responsive" src="{{ $imgSrc }}"/>
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

                <div class="pull-right">
                    {!! Form::submit(trans('home.category_save'),['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('home.categories') }}</h3>
            </div>
            <div class="box-body no-padding">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>{{ trans('home.category_min') }}</th>
                        <th>{{ trans('home.slug') }}</th>
                        <th style="width: 100px">{{ trans('home.actions') }}</th>
                    </tr>
                    @if(count($categories) > 0)
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}.</td>
                                <td>{{ $category->category }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <a href="{{ url('home/categories/edit/' . $category->id) }}" class="label bg-blue margin-r-5">
                                        {{ trans('home.edit') }}
                                    </a>
                                    <a href="{{ url('/category/' . $category->slug) }}" class="label bg-green">
                                        {{ trans('home.view') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="4" align="center">
                            {{ trans('home.no_categories') }}
                        </td>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    {!! $categories !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-javascript')
    {!! Html::script('admin/assets/js/categories.js') !!}
@endsection