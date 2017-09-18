@extends('account.layout')

@section('pageTitle')
    {{ trans('home.user_profile') }}
@endsection

@section('contentTitle')
    {{ trans('home.user_profile') }}
@endsection

@section('contentSubtitle')
    {{ trans('home.user_profile_page_description') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            {!! Form::open(['url' => 'account/profile', 'class' => 'form', 'method' => 'POST']) !!}
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Sobre tí</h2>
                    <small class="card-subtitle">
                        Información sobre tu nombre de pila y nombre de usuario, correo electrónico y biografía.
                    </small>
                </div>

                <div class="card-block">
                    <div class="form-group form-group--float {{ $errors->has('name') ? ' has-danger' : ''}}">
                        {!! Form::text('user[name]', $userProfile->name, ['class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('name', trans('auth.name') . ($errors->has('name') ? '. ' . $errors->first('name') : ''), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group form-group--float {{ $errors->has('email') ? ' has-danger' : ''}}">
                        {!! Form::email('user[email]', $userProfile->email, ['class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('email', trans('auth.email') . ($errors->has('email') ? '. ' . $errors->first('email') : ''), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group form-group--float {{ $errors->has('username') ? ' has-danger' : ''}}">
                        {!! Form::text('user[username]', $userProfile->username, ['class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('username', trans('auth.username') . ($errors->has('username') ? '. ' . $errors->first('username') : ''), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group {{ $errors->has('biography') ? ' has-danger' : ''}}">
                        {!! Form::label('biography', trans('auth.biography') . ($errors->has('biography') ? '. ' . $errors->first('biography') : ''), ['class' => 'form-control-label']) !!}
                        {!! Form::textarea('usermeta[biography]', $userProfile->userMeta->biography ?? '', ['class' => 'form-control', 'rows' => '4']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group form-group--float {{ $errors->has('job') ? ' has-danger' : ''}}">
                        {!! Form::text('usermeta[job]', $userProfile->userMeta->job ?? '', ['class' => 'form-control']) !!}
                        {!! Form::label('job', trans('auth.job_position') . ($errors->has('job') ? '. ' . $errors->first('job') : ''), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>
                </div>

                <div class="card-block">
                    {!! Form::button(trans('home.save'), ['class' => 'btn btn-primary waves-effect', 'type' => 'submit']) !!}
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ trans('public.social-networks') }}</h2>
                    <small class="card-subtitle">
                        ¿En qué redes sociales publicas contenido?
                    </small>
                </div>

                <div class="card-block">
                    @foreach(\App\UserMeta::$socialNetworks as $socialNetwork)
                        <div class="form-group form-group--float {{ $errors->has($socialNetwork) ? ' has-danger' : ''}}">
                            {!! Form::text("usermeta[$socialNetwork]", $userProfile->userMeta->$socialNetwork ?? '', ['class' => 'form-control']) !!}
                            {!! Form::label($socialNetwork, trans('public.' . $socialNetwork) . ' URL' . ($errors->has($socialNetwork) ? '. ' . $errors->first($socialNetwork) : '') , ['class' => 'form-control-label']) !!}
                            <i class="form-group__bar"></i>
                        </div>
                    @endforeach
                </div>

                <div class="card-block">
                    {!! Form::button(trans('home.save'), ['class' => 'btn btn-primary waves-effect', 'type' => 'submit']) !!}
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection