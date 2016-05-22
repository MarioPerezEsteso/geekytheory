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
        <div class="box">
            <div class="box-body">
                <div class="col-md-offset-4 col-md-8">
                    @include('home.menu.menuitems')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
    {!! Html::style('admin/assets/js/nested-sortable/stylesheet.css') !!}
@endsection

@section('custom-javascript')
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    {!! Html::script('admin/assets/js/nested-sortable/jquery.mjs.nestedSortable.js') !!}
    {!! Html::script('admin/assets/js/menu.js') !!}
@endsection