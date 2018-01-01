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
        <div class="col-lg-5 col-md-6">

            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="alert-heading">¡Bien!</h4>
                    <p class="mb-0">{{ Session::get('success') }}</p>
                </div>
            @endif

            {!! Form::open(['url' => 'account/profile', 'class' => 'form', 'method' => 'POST']) !!}
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Sobre tí</h2>
                    <small class="card-subtitle">
                        Información sobre tu nombre de pila y nombre de usuario, correo electrónico y biografía.
                    </small>
                </div>

                <div class="card-block">
                    <div class="form-group form-group--float {{ (isset($errors) && $errors->has('name')) ? ' has-danger' : ''}}">
                        {!! Form::text('user[name]', $userProfile->name, ['class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('name', trans('auth.name') . ((isset($errors) && $errors->has('name')) ? '. ' . $errors->first('name') : ''), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group form-group--float {{ (isset($errors) && $errors->has('email')) ? ' has-danger' : ''}}">
                        {!! Form::email('user[email]', $userProfile->email, ['class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('email', trans('auth.email') . ((isset($errors) && $errors->has('email')) ? '. ' . $errors->first('email') : ''), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group form-group--float {{ (isset($errors) && $errors->has('username')) ? ' has-danger' : ''}}">
                        {!! Form::text('user[username]', $userProfile->username, ['class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('username', trans('auth.username') . ((isset($errors) && $errors->has('username')) ? '. ' . $errors->first('username') : ''), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group {{ (isset($errors) && $errors->has('biography')) ? ' has-danger' : ''}}">
                        {!! Form::label('biography', trans('auth.biography') . ((isset($errors) && $errors->has('biography')) ? '. ' . $errors->first('biography') : ''), ['class' => 'form-control-label']) !!}
                        {!! Form::textarea('usermeta[biography]', $userProfile->userMeta->biography ?? '', ['class' => 'form-control', 'rows' => '4']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group form-group--float {{ (isset($errors) && $errors->has('job')) ? ' has-danger' : ''}}">
                        {!! Form::text('usermeta[job]', $userProfile->userMeta->job ?? '', ['class' => 'form-control']) !!}
                        {!! Form::label('job', trans('auth.job_position') . ((isset($errors) && $errors->has('job')) ? '. ' . $errors->first('job') : ''), ['class' => 'form-control-label']) !!}
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
                        ¿Qué redes sociales utilizas?
                    </small>
                </div>

                <div class="card-block">
                    @foreach(\App\UserMeta::$socialNetworks as $socialNetwork)
                        <div class="form-group form-group--float {{ (isset($errors) && $errors->has($socialNetwork)) ? ' has-danger' : ''}}">
                            {!! Form::text("usermeta[$socialNetwork]", $userProfile->userMeta->$socialNetwork ?? '', ['class' => 'form-control']) !!}
                            {!! Form::label($socialNetwork, trans('public.' . $socialNetwork) . ' URL' . ((isset($errors) && $errors->has($socialNetwork)) ? '. ' . $errors->first($socialNetwork) : '') , ['class' => 'form-control-label']) !!}
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