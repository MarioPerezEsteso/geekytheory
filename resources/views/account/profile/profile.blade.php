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
            
            {!! Form::open(['url' => 'home/profile/update/' . $userProfile->id, 'class' => 'form']) !!}

            <div class="form-group">
                {!! Form::label('name', trans('auth.name')) !!}
                {!! Form::text('user[name]', $userProfile->name, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', trans('auth.email')) !!}
                {!! Form::email('user[email]', $userProfile->email, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('username', trans('auth.username')) !!}
                {!! Form::text('user[username]', $userProfile->username, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('biography', trans('auth.biography')) !!}
                {!! Form::textarea('usermeta[biography]', $userProfile->userMeta->biography, ['class' => 'form-control', 'rows' => '4']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('job', trans('auth.job_position')) !!}
                {!! Form::text('usermeta[job]', $userProfile->userMeta->job, ['class' => 'form-control']) !!}
            </div>

            <h3>{{ trans('public.social-networks') }}</h3>

            @foreach(\App\UserMeta::$socialNetworks as $socialNetwork)
                <div class="form-group">
                    {!! Form::label($socialNetwork, trans('public.' . $socialNetwork)) !!}
                    {!! Form::text("usermeta[$socialNetwork]", $userProfile->userMeta->$socialNetwork, ['class' => 'form-control', 'placeholder' => trans('public.' . $socialNetwork . '.placeholder')]) !!}
                </div>
            @endforeach

            <div>
                {!! Form::submit(trans('home.save'),['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection