@extends('courses.layouts.layout')

@section('customCSS')
    <link href="{{ autoVersion('/assets/courses/css/subscription.css') }}" rel="stylesheet">
@endsection

@section('title')
    Suscripción - {{ $siteMeta->title }}
@endsection

@section('description')
    {{ trans('public.pricing_description') }}
@endsection

@section('content')
    <section class="container-fluid section-gray" style="padding-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <article class="panel panel-subscription panel-subscription-premium">
                                <div class="panel-heading"></div>
                                <div class="panel-body">
                                    <h3>
                                        Empezar con Geeky Theory Premium
                                    </h3>
                                    <ul class="list-unstyled list-perks list-perks-premium">
                                        <li>
                                            Acceso a todos los cursos
                                        </li>
                                        <li>
                                            Certificado de finalización
                                        </li>
                                        <li>
                                            Soporte a las 24 horas
                                        </li>
                                    </ul>

                                </div>
                                <hr>
                                <div class="panel-footer">
                                    <p><strong>{{ \App\Subscription::PLAN_MONTHLY_PRICE_EUR }} € por mes</strong></p>
                                    Puedes cancelar cuando quieras.
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        @if (isset($errors) && !$errors->isEmpty())
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="alert-heading">Ups!</h4>
                                        @foreach($errors->all() as $error)
                                            <p class="mb-0">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <article class="panel panel-subscription panel-subscription-premium">
                                    <div class="panel-heading"></div>
                                    <div class="panel-body">
                                        {!! Form::open(['url' => 'account/subscription', 'method' => 'POST', 'id' => 'subscription-form']) !!}
                                        {!! Form::close() !!}
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h3>
                                                    Datos de pago
                                                </h3>
                                                <div class="form-group">
                                                    <label for="cardnumber">
                                                        <span id="trans-cardnumber">Número de tarjeta</span>
                                                        <img src="/public/images/cards.png" class="img-cards">
                                                    </label>
                                                    <a href="#" class="pull-right" data-toggle="tooltip"
                                                       title="Las transacciones están cifradas y son seguras">
                                                        <span class="fui-lock tooltip-icon"></span>
                                                    </a>
                                                    <input type="text" class="form-control" id="credit-card-number"
                                                           placeholder="1111 2222 3333 4444">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label id="trans-expiration_date" for="expiration_date">
                                                        Fecha de caducidad
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <select id="credit-card-expiration-month"
                                                                    class="form-control">
                                                                <option id="trans-label_month" value=""
                                                                        default="default"
                                                                        selected="selected">Mes
                                                                </option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                                <option value="5">05</option>
                                                                <option value="6">06</option>
                                                                <option value="7">07</option>
                                                                <option value="8">08</option>
                                                                <option value="9">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <select id="credit-card-expiration-year"
                                                                    class="form-control">
                                                                <option id="trans-label_year" value="" default=""
                                                                        selected="selected">Año
                                                                </option>
                                                                <option value="2018">18</option>
                                                                <option value="2019">19</option>
                                                                <option value="2020">20</option>
                                                                <option value="2021">21</option>
                                                                <option value="2022">22</option>
                                                                <option value="2023">23</option>
                                                                <option value="2024">24</option>
                                                                <option value="2025">25</option>
                                                                <option value="2026">26</option>
                                                                <option value="2027">27</option>
                                                                <option value="2028">28</option>
                                                                <option value="2029">29</option>
                                                                <option value="2030">30</option>
                                                                <option value="2031">31</option>
                                                                <option value="2032">32</option>
                                                                <option value="2033">33</option>
                                                                <option value="2034">34</option>
                                                                <option value="2035">35</option>
                                                                <option value="2036">36</option>
                                                                <option value="2037">37</option>
                                                                <option value="2038">38</option>
                                                                <option value="2039">39</option>
                                                                <option value="2040">40</option>
                                                                <option value="2041">41</option>
                                                                <option value="2042">42</option>
                                                                <option value="2043">43</option>
                                                                <option value="2044">44</option>
                                                                <option value="2045">45</option>
                                                                <option value="2046">46</option>
                                                                <option value="2047">47</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label for="security-code">
                                                        Código de seguridad
                                                    </label>
                                                    <a href="#" class="pull-right" data-toggle="tooltip"
                                                       title="Código de 3 dígitos en la parte posterior de la tarjeta">
                                                        <span class="fui-info-circle tooltip-icon"></span>
                                                    </a>
                                                    <input id="credit-card-cvv" autocomplete="off" pattern="[0-9]*"
                                                           placeholder="CVC / CVV2" class="form-control" type="tel">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="panel-footer">
                                        <button id="btn-add-credit-card" class="btn btn-primary">
                                            <strong>COMENZAR CON GEEKY THEORY PREMIUM</strong>
                                        </button>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid section-faq">
        @include('courses.partials.pricing.faq')
    </section>
@endsection

@section('customJavascript')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({
                placement: 'bottom'
            });
            $(".tooltip.fade.top").remove();
        });
        window.stripePublicKey = '{{ config('services.stripe.public') }}'
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="/account/js/subscription/payMethodFormHandler.js"></script>
@endsection