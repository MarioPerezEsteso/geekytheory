@extends('auth.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('auth.login') }}</div>
                    <div class="panel-body">
                        {!! Form::open(['route' => 'login', 'class' => 'form']) !!}

                        <div class="form-group">
                            <label>{{ trans('auth.email') }}</label>
                            {!! Form::email('email', '', ['class'=> 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label>{{ trans('auth.password') }}</label>
                            {!! Form::password('password', ['class'=> 'form-control']) !!}
                        </div>

                        <div class="checkbox">
                            <label><input name="remember" type="checkbox"> {{ trans('auth.remember-me') }}</label>
                        </div>

                        <div>
                            {!! Form::submit(trans('auth.login') ,['class' => 'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection