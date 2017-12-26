@extends('auth.layout')

@section('content')
    <div class="container vertical-center">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="/images/geeky-theory-logo-32.png"/>

            <small>Introduce tu email y la nueva contraseña</small><br><br>

            {!! Form::open(['route' => 'password.reset.post', 'class' => 'form-signin']) !!}

            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}"
                   placeholder="Email" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña" required>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                   placeholder="Repite la contraseña" required>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif

            {!! Form::submit("Reiniciar contraseña", ['class' => 'btn btn-lg btn-primary btn-block btn-signin']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
