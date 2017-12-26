@extends('auth.layout')

@section('content')
    <div class="container vertical-center">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="/images/geeky-theory-logo-32.png"/>

            {!! Form::open(['route' => 'auth.register.post', 'class' => 'form-signin']) !!}
            <input type="text" id="name" name="name" class="form-control" placeholder="Nombre" required autofocus>
            @if ($errors->has('name'))
                <p>
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                </p>
            @endif
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
            @if ($errors->has('email'))
                <p>
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                </p>
            @endif

            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
            @if ($errors->has('password'))
                <p>
                    <small class="text-danger">{{ $errors->first('password') }}</small>
                </p>
            @endif

            {!! Form::submit('Crear cuenta', ['class' => 'btn btn-lg btn-primary btn-block btn-signin']) !!}
            <br>
            <small>
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}">
                    <strong>Accede desde aquí</strong>
                </a>
            </small>
            {!! Form::close() !!}
        </div>
    </div>
@endsection