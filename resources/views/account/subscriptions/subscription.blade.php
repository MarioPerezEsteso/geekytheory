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

@section('customJavascript')
    <script type="text/javascript">
        window.stripePublicKey = '{{ config('services.stripe.public') }}'
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="/account/js/subscription/payMethodFormHandler.js"></script>
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

            @if (is_null($subscription) || !$subscription->active())
                {{-- Hidden form to create subscription with Stripe token --}}
                {!! Form::open(['url' => 'account/subscription', 'method' => 'POST', 'id' => 'subscription-form']) !!}
                {!! Form::close() !!}

                <div class="row price-table price-table--highlight">
                    <div class="col-md-6">
                        <div class="price-table__item">
                            <header class="price-table__header bg-teal">
                                <div class="price-table__title">Plan Gratuito</div>
                            </header>
                            <div class="price-table__price color-teal">
                                0 €/
                                <small>mes</small>
                            </div>
                            <ul class="price-table__info">
                                <li>In dapibus ipsum sit amet leo</li>
                                <li>Vestibulum ut mauris tellus donec</li>
                                <li>Purna lectus venenatis felis nonsemper</li>
                                <li>Aliquam erat volutpat hasellus ultri</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="price-table__item price-table__item--popular">
                            <header class="price-table__header bg-blue">
                                <div class="price-table__title">Plan Premium</div>
                            </header>
                            <div class="price-table__price color-blue">
                                {{ \App\Subscription::PLAN_MONTHLY_PRICE_EUR }} €/
                                <small>mes</small>
                            </div>
                            <ul class="price-table__info">
                                <li>Morbi leo risus porta acconseetur</li>
                                <li>Nullam quis risus eget urna mollis ornare</li>
                                <li>Purna lectus venenatis felis nonsemper</li>
                                <li>Aenean ellentesque ornare sem lacinia</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Datos de pago</h2>
                        <small class="card-subtitle">
                            Introduce los datos de tu tarjeta para suscribirte a nuestro plan Premium.
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
                        {!! Form::button(trans('home.go_premium'), ['class' => 'btn btn-primary waves-effect', 'id' => 'btn-add-credit-card']) !!}
                    </div>
                </div>

            @else
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Suscripción</h2>
                        <small class="card-subtitle">
                            Estos son los datos de tu suscripción Premium.
                        </small>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-12">
                                @if (!is_null($subscription) && !is_null($subscription->ends_at))
                                    Tienes activa una suscripción Premium mensual en Geeky Theory
                                    por {{ \App\Subscription::PLAN_MONTHLY_PRICE_EUR }} €/mes pero la has cancelado.
                                    Tu suscripción acabará {{ $subscription->ends_at->diffForHumans() }}.
                                @else
                                    Tienes activa una suscripción Premium mensual en Geeky Theory
                                    por {{ \App\Subscription::PLAN_MONTHLY_PRICE_EUR }} €/mes.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if (!is_null($subscription) && is_null($subscription->ends_at))
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Zona peligrosa</h2>
                            <div class="actions">
                                <a data-toggle="collapse" href="#collapse-panel" class="actions__item zmdi zmdi-chevron-down zmdi-hc-fw"></a>
                            </div>
                        </div>
                        <div id="collapse-panel" class="panel-collapse collapse">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-lg-12">
                                        Si cancelas tu suscripción, perderás el acceso a todo el contenido Premium que
                                        ofrece
                                        Geeky Theory. <a href="https://www.youtube.com/watch?v=8TGb2fjT6I0">¿Realmente
                                            quieres
                                            marcharte?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-lg-12">
                                        Debes introducir tu contraseña para poder cancelar tu suscripción.
                                    </div>
                                </div>
                                {!! Form::open(['url' => route('account.subscription.cancel'), 'method' => 'POST', 'id' => 'subscription-cancel-form']) !!}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-group--float">
                                            {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
                                            {!! Form::label('password', 'Contraseña', ['class' => 'form-control-label']) !!}
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! Form::button('Cancelar suscripción', ['class' => 'btn btn-danger waves-effect', 'type' => 'submit']) !!}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection