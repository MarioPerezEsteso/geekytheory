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

            <h3>{{ trans('public.social-networks') }}</h3>

            @foreach(\App\Http\Controllers\UserController::$socialNetworks as $socialNetwork)
                <div class="form-group">
                    {!! Form::label($socialNetwork, trans('public.' . $socialNetwork)) !!}
                    {!! Form::text($socialNetwork, null, ['class' => 'form-control']) !!}
                </div>
            @endforeach

            <div>
                {!! Form::submit(trans('home.save'),['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection