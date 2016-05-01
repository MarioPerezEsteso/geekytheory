@extends('home.layout')

@section('title')
    {{ trans('home.user_profile') }}
@endsection

@section('pageTitle')
    {{ trans('home.user_profile') }}
@endsection

@section('pageDescription')
    {{ trans('home.user_profile_page_description') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">

            @include('home.posts.partials.formMessages')

            {!! Form::model($userProfile, ['url' => 'home/profile/update/' . $userProfile->id, 'class' => 'form']) !!}

            <div class="form-group">
                {!! Form::label('name', trans('auth.name')) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', trans('auth.email')) !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('biography', trans('auth.biography')) !!}
                {!! Form::textarea('biography', null, ['class' => 'form-control', 'rows' => '4']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('job', trans('auth.job_position')) !!}
                {!! Form::text('job', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('instagram', trans('public.instagram')) !!}
                {!! Form::text('instagram', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('twitter', trans('public.twitter')) !!}
                {!! Form::text('twitter', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('facebook', trans('public.facebook')) !!}
                {!! Form::text('facebook', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('github', trans('public.github')) !!}
                {!! Form::text('github', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('youtube', trans('public.dribble')) !!}
                {!! Form::text('youtube', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('googleplus', trans('public.googleplus')) !!}
                {!! Form::text('googleplus', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('stackoverflow', trans('public.stackoverflow')) !!}
                {!! Form::text('stackoverflow', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('flickr', trans('public.flickr')) !!}
                {!! Form::text('flickr', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('bitbucket', trans('public.bitbucket')) !!}
                {!! Form::text('bitbucket', null, ['class' => 'form-control']) !!}
            </div>

            <div>
                {!! Form::submit(trans('home.save'),['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection