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

            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="alert-heading">¡Bien!</h4>
                    <p class="mb-0">{{ Session::get('success') }}</p>
                </div>
            @endif

            {!! Form::open(['url' => 'account/profile/password', 'class' => 'form', 'method' => 'POST']) !!}
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Cambiar contraseña</h2>
                    <small class="card-subtitle">
                        Introduce tu contraseña actual y la nueva contraseña para actualizarla.
                    </small>
                </div>

                <div class="card-block">
                    <div class="form-group form-group--float">
                        {!! Form::password('currentpassword', ['class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('currentpassword', trans('home.current_password'), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group form-group--float">
                        {!! Form::password('newpassword', ['class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('newpassword', trans('home.new_password'), ['class' => 'form-control-label']) !!}
                        <i class="form-group__bar"></i>
                    </div>

                </div>

                <div class="card-block">
                    {!! Form::button(trans('home.update'), ['class' => 'btn btn-primary waves-effect', 'type' => 'submit']) !!}
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection