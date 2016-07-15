@extends('home.layout')

@section('title')
    {{ trans('home.tags') }}
@endsection

@section('pageTitle')
    {{ trans('home.tags') }}
@endsection

@section('pageDescription')
    {{ trans('home.tags_page_description') }}
@endsection

@section('content')
    <div class="col-md-6">

        @include('home.posts.partials.formMessages')

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    @if (empty($tag))
                        {{ trans('home.tag_add') }}
                    @else
                        {{ trans('home.tag_edit') }}
                    @endif
                </h3>
            </div>
            <div class="box-body">
                @if (!empty($tag))
                    {!! Form::model($tag, ['url' => 'home/tags/update/' . $tag->id, 'class' => 'form']) !!}
                @else
                    {!! Form::open(['url' => 'home/tags/store', 'class' => 'form']) !!}
                @endif
                <div class="form-group">
                    {!! Form::label('tag', trans('home.tag_min')) !!}
                    {!! Form::text('tag', null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('slug', trans('home.slug')) !!}
                    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
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
                <h3 class="box-title">{{ trans('home.tags') }}</h3>
            </div>
            <div class="box-body no-padding">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>{{ trans('home.tag_min') }}</th>
                        <th>{{ trans('home.slug') }}</th>
                        <th style="width: 150px">{{ trans('home.actions') }}</th>
                    </tr>
                    @if(count($tags) > 0)
                        <?php $index = 1; ?>
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $index++ }}.</td>
                                <td>{{ $tag->tag }}</td>
                                <td>{{ $tag->slug }}</td>
                                <td>
                                    <a href="{{ url('home/tags/delete/' . $tag->id) }}" class="label bg-red margin-r-5">
                                        {{ trans('home.delete') }}
                                    </a>
                                    <a href="{{ url('home/tags/edit/' . $tag->id) }}" class="label bg-blue margin-r-5">
                                        {{ trans('home.edit') }}
                                    </a>
                                    <a href="{{ url('/tag/' . $tag->slug) }}" class="label bg-green">
                                        {{ trans('home.view') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="4">{{ trans('home.no_tags') }}</td>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    {!! $tags !!}
                </div>
            </div>
        </div>
    </div>
@endsection