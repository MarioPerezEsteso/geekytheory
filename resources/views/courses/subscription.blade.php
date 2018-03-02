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
        <div class="row">
            <div class="col-lg-3 col-lg-push-1 col-md-4 col-lg-offset-2">
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
                        <p><strong>15 € por mes</strong></p>
                        Puedes cancelar cuando quieras.
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="container-fluid section-faq">
        @include('courses.partials.pricing.faq')
    </section>
@endsection