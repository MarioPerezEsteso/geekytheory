@extends('auth.layout')

@section('content')
    <div class="container vertical-center">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="/images/geeky-theory-logo-32.png"/>

            {!! Form::open(['route' => 'login', 'class' => 'form-signin']) !!}
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
            <div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> {{ trans('auth.remember-me') }}
                </label>
            </div>
            {!! Form::submit(trans('auth.login'), ['class' => 'btn btn-lg btn-primary btn-block btn-signin']) !!}
            <a href="{{ route('password.reset') }}">
                <small>He olvidado mi contraseña</small>
            </a>
            <br>
            <small>
                ¿Aún no tienes cuenta?
                <a href="{{ route('auth.register.get') }}">
                    <strong>Regístrate aquí</strong>
                </a>
            </small>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('customJavascript')
    {!! Html::script('/assets/js/jquery-md5/jquery-md5.js') !!}
    {!! Html::script('/assets/courses/js/auth.js') !!}
@endsection