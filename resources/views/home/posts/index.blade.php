@extends('home.layout')

@section('title')
    {{ trans('home.posts') }}
@endsection

@section('pageTitle')
    {{ trans('home.posts') }}
@endsection

@section('pageDescription')
    {{ trans('home.posts_page_description') }}
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" style="width: 20%;">
                                    {{ trans('home.post_title') }}
                                </th>
                                <th class="sorting" style="width: 50%;">
                                    {{ trans('home.description') }}
                                </th>
                                <th class="sorting" style="width: 5%;">
                                    {{ trans('home.status') }}
                                </th>
                                <th class="sorting hidden-xs" style="width: 15%;">
                                    {{ trans('home.author') }}
                                </th>
                                <th class="sorting" style="width: 10%;">
                                    {{ trans('home.actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($posts) > 0)
                                @foreach($posts as $post)
                                    <tr role="row" class="odd">
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->description }}</td>
                                        <td>
                                            <span class="label {{ getStatusLabelClass($post->status) }}">
                                                {{ trans('home.status_' . $post->status) }}
                                            </span>
                                        </td>
                                        <td class="hidden-xs">
                                            <a href="{{ url('home/posts/' . $post->user->username) }}">
                                                {{ $post->user->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($post->status != 'deleted')
                                                <a href="{{ url('home/posts/edit/' . $post->id) }}" class="margin">
                                                    <span class="label bg-blue">
                                                         {{ trans('home.edit') }}
                                                    </span>
                                                </a>
                                                <a href="{{ url('home/posts/delete/' . $post->id) }}">
                                                    <span class="label bg-red">
                                                         {{ trans('home.delete') }}
                                                    </span>
                                                </a>
                                            @else
                                                <a href="{{ url('home/posts/restore/' . $post->id) }}" class="margin">
                                                    <span class="label bg-purple">
                                                         {{ trans('home.restore') }}
                                                    </span>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td align="center" colspan="5">
                                    {{ trans('home.no_posts') }}
                                </td>
                            @endif


                            </tbody>
                            <tfoot>
                            <th class="sorting_asc" style="width: 20%;">
                                {{ trans('home.post_title') }}
                            </th>
                            <th class="sorting" style="width: 50%;">
                                {{ trans('home.description') }}
                            </th>
                            <th class="sorting" style="width: 5%;">
                                {{ trans('home.status') }}
                            </th>
                            <th class="sorting hidden-xs" style="width: 15%;">
                                {{ trans('home.author') }}
                            </th>
                            <th class="sorting" style="width: 10%;">
                                {{ trans('home.actions') }}
                            </th>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @if (count($posts) > 0)
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                {{ getPaginationText($posts) }}
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers pull-right">
                                {!! $posts !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- /.box-body -->
    </div>

@endsection