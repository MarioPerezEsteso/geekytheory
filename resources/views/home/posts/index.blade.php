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
            <h3 class="box-title">Data Table With Full Features</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="example1_length">
                            <label>
                                Show
                                <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                entries
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="example1_filter" class="dataTables_filter">
                            <label>
                                Search:
                                <input type="search" class="form-control input-sm" placeholder=""
                                       aria-controls="example1">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" style="width: 296px;">
                                    {{ trans('home.post_title') }}
                                </th>
                                <th class="sorting" style="width: 361px;">
                                    {{ trans('home.description') }}
                                </th>
                                <th class="sorting" style="width: 321px;">
                                    {{ trans('home.status') }}
                                </th>
                                <th class="sorting" style="width: 256px;">
                                    {{ trans('home.author') }}
                                </th>
                                <th class="sorting" style="width: 190px;">
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
                                        <td>{{ trans('home.status_' . $post->status) }}</td>
                                        <td>
                                            <a href="{{ url('home/posts/' . $post->user->username) }}">
                                                {{ $post->user->name }}
                                            </a>
                                        </td>
                                        <td>A</td>
                                    </tr>
                                @endforeach
                            @else
                                <td align="center" colspan="5">
                                    {{ trans('home.no_posts') }}
                                </td>
                            @endif


                            </tbody>
                            <tfoot>
                            <th class="sorting_asc" style="width: 296px;">
                                {{ trans('home.post_title') }}
                            </th>
                            <th class="sorting" style="width: 361px;">
                                {{ trans('home.description') }}
                            </th>
                            <th class="sorting" style="width: 321px;">
                                {{ trans('home.status') }}
                            </th>
                            <th class="sorting" style="width: 256px;">
                                {{ trans('home.author') }}
                            </th>
                            <th class="sorting" style="width: 190px;">
                                {{ trans('home.actions') }}
                            </th>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 25
                            of 57 entries
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                            {!! $posts !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

@endsection