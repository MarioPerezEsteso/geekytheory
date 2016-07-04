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
                    {!! Form::label('image','home.upload_image') !!}
                    {!! Form::file('image') !!}
                </div>

                <div>
                    {!! Form::submit(trans('home.save'),['class' => 'btn btn-primary']) !!}
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