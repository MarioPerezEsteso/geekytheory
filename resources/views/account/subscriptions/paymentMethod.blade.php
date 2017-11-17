@extends('account.layout')

@section('pageTitle')
    {{ trans('home.payment_method') }}
@endsection

@section('contentTitle')
    {{ trans('home.payment_method') }}
@endsection

@section('contentSubtitle')
    {{ trans('home.payment_method_page_description') }}
@endsection

@section('customJavascript')
    <script type="text/javascript">
        window.stripePublicKey = '{{ config('services.stripe.public') }}'
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="/account/js/subscription/updateCardFormHandler.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12">

            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="alert-heading">{{ trans('home.nice') }}</h4>
                    <p class="mb-0">{{ Session::get('success') }}</p>
                </div>
            @endif

            @if (isset($errors) && !$errors->isEmpty())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="alert-heading">Ups!</h4>
                    @foreach($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Hidden form to create subscription with Stripe token --}}
            {!! Form::open(['url' => route('account.subscription.card.post'), 'method' => 'POST', 'id' => 'update-card-form']) !!}
            {!! Form::close() !!}

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Método de pago actual</h2>
                    <small class="card-subtitle">
                        Tu suscripción Premium está utilizando una tarjeta con estos datos.
                    </small>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-5">
                            <p class="btn btn-outline-primary waves-effect">{{ $loggedUser->card_brand }}</p>
                        </div>
                        <div class="col-lg-9 col-md-7 col-sm-7 col-xs-7">
                            <p class="subscription-current-card"><strong>···· ···· ···· {{ $loggedUser->card_last_four }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Datos de pago</h2>
                    <small class="card-subtitle">
                        Introduce la tarjeta que utilizarás a partir de ahora. No te cobraremos dos veces.
                    </small>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-8 col-sm-12">
                            <div class="form-group form-group--float">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'credit-card-name',]) !!}
                                {!! Form::label('name', trans('home.credit_card_name'), ['class' => 'form-control-label']) !!}
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group form-group--float">
                                {!! Form::text('postal_code', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'postal-code',]) !!}
                                {!! Form::label('postal_code', trans('home.postal_code'), ['class' => 'form-control-label']) !!}
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-group--float">
                                {!! Form::text('credit_card_number', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'credit-card-number',]) !!}
                                {!! Form::label('credit_card_number', trans('home.credit_card_number'), ['class' => 'form-control-label']) !!}
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group form-group--float">
                                {!! Form::text('credit_card_expiration_month', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'credit-card-expiration-month',]) !!}
                                {!! Form::label('credit_card_expiration_month', trans('home.credit_card_expiration_month'), ['class' => 'form-control-label']) !!}
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group form-group--float">
                                {!! Form::text('credit_card_expiration_year', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'credit-card-expiration-year',]) !!}
                                {!! Form::label('credit_card_expiration_year', trans('home.credit_card_expiration_year'), ['class' => 'form-control-label']) !!}
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group form-group--float">
                                {!! Form::text('credit_card_cvv', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'credit-card-cvv',]) !!}
                                {!! Form::label('credit_card_cvv', trans('home.credit_card_cvv'), ['class' => 'form-control-label']) !!}
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <p id="error-message" class="text-danger" style="display: none">
                                Ha habido un error en la comunicación con Stripe. Por favor, inténtalo de nuevo.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-block">
                    {!! Form::button(trans('home.update_card'), ['class' => 'btn btn-primary waves-effect', 'id' => 'btn-update-card']) !!}
                </div>
            </div>
        </div>
    </div>
@endsection