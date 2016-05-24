@extends('home.layout')

@section('title')
    {{ trans('home.menu') }}
@endsection

@section('pageTitle')
    {{ trans('home.menu') }}
@endsection

@section('pageDescription')
    {{ trans('home.menu_page_description') }}
@endsection

@section('content')
    <section class="content">
        <div class="col-md-8 col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add menu item</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="text">Text</label>
                            <input class="form-control" name="new-menu-item-text" type="text">
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input class="form-control" name="new-menu-item-link" type="url">
                        </div>
                        <button class="btn btn-primary pull-right">Add new item</button>
                    </div>
                    <div class="col-md-offset-1 col-md-6">
                        @include('home.menu.menuitems')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"/>
    {!! Html::style('admin/assets/js/nested-sortable/stylesheet.css') !!}
@endsection

@section('custom-javascript')
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    {!! Html::script('admin/assets/js/nested-sortable/jquery.mjs.nestedSortable.js') !!}
    {!! Html::script('admin/assets/js/menu.js') !!}
@endsection