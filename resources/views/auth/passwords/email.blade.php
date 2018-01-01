@extends('auth.layout')

@section('content')
    <div class="container vertical-center">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="/images/geeky-theory-logo-32.png"/>

            @if (session('status'))
                <div class="alert alert-success">
                    <small>{{ trans(session('status')) }}</small>
                </div>
            @else
                <small>Por favor, introduce el email del cual quieres recordar la contraseña</small>
                <br><br>
            @endif


            {!! Form::open(['route' => 'password.email', 'class' => 'form-signin']) !!}
            {{ csrf_field() }}
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>

            @if ($errors->has('email'))
                <small class="has-error">
                    {{ $errors->first('email') }}
                </small>
            @endif

            {!! Form::submit("Recuperar contraseña", ['class' => 'btn btn-lg btn-primary btn-block btn-signin']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
