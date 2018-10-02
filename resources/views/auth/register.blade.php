@extends('web.layouts.layout')

@section('content')
<section class="slice-lg">
    <div class="container">
        <div class="row justify-content-center cols-xs-space">
            <div class="col-lg-6">
                <div class="form-card form-card--style-2 z-depth-2-top">
                    <div class="form-header text-center">
                        <div class="form-header-icon">
                            <i class="icon ion-log-in"></i>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="text-center px-2">
                            <h4 class="heading heading-4 strong-400 mb-4">Crea tu cuenta</h4>
                        </div>
                        
                        {!! Form::open(['url' => route('auth.register.post'), 'method' => 'POST', 'class' => 'form-default mt-4']) !!}
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input name="name" type="text" class="form-control form-control-lg" required>
                                        @if (isset($errors) && $errors->has('name'))
                                            <p>
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input name="email" type="email" class="form-control form-control-lg" required>
                                        @if (isset($errors) && $errors->has('email'))
                                            <p>
                                                <small class="text-danger">{{ $errors->first('email') }}</small>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input name="password" type="password" class="form-control form-control-lg" required>
                                        @if (isset($errors) && $errors->has('password'))
                                            <p>
                                                <small class="text-danger">{{ $errors->first('password') }}</small>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-1 ">
                                <small class="">Al hacer click en "Registrarme" aceptas nuestros términos y condiciones de uso.</small>
                            </div>

                            <button type="submit" class="btn btn-styled  btn-base-1 mt-4">
                                Registrarme
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
