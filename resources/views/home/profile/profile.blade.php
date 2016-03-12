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
            @if (count($errors))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
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

            <div>
                {!! Form::submit(trans('home.save'),['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection