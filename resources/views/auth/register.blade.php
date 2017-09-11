@extends('auth.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('auth.register') }}</div>

                    <div class="panel-body">
                        {!! Form::open(['route' => 'auth.register.post', 'class' => 'form']) !!}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label>{{ trans('auth.name') }}</label>
                            {!! Form::input('text', 'name', '', ['class'=> 'form-control']) !!}
                            @if ($errors->has('name'))
                                <p>
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                </p>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label>{{ trans('auth.email') }}</label>
                            {!! Form::email('email', '', ['class'=> 'form-control']) !!}
                            @if ($errors->has('email'))
                                <p>
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                </p>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label>{{ trans('auth.password') }}</label>
                            {!! Form::password('password', ['class'=> 'form-control']) !!}
                            @if ($errors->has('password'))
                                <p>
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                </p>
                            @endif
                        </div>

                        {{--<div class="form-group">
                            <label>{{ trans('auth.password-confirmation') }}</label>
                            {!! Form::password('password_confirmation', ['class'=> 'form-control']) !!}
                        </div>--}}

                        <div>
                            {!! Form::submit(trans('auth.send'),['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection