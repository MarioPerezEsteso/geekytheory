@extends('web.layouts.layout')

@section('content')
    <section class="bg-base-2 holder-item holder-item-dark">
        <div class="container container-sm d-flex align-items-center">
            <div class="col">
                <div class="row py-5 text-center justify-content-center">
                    <div class="col-12 col-md-10">
                        <h1 class="heading heading-2 c-white strong-600 mt-3 animated" data-animation-in="fadeIn"
                            data-animation-delay="400">
                            Aprende a programar como si tu carrera dependiese de ello
                        </h1>
                        <span class="sd-1 sd-sm sd-thick-3px sd-center"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="slice-lg sct-color-1">
        <div class="container">
            <div class="row cols-xs-space cols-md-space cols-lg-space">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="card z-depth-2-top z-depth-3--hover">
                        <div class="card-body text-center">
                            <div class="icon-block--style-1-v5">
                                <div class="block-icon">
                                    <i class=" icon-finance-147"></i>
                                </div>
                            </div>
                            <div class="block-content">
                                <h3 class="heading heading-5 strong-600">
                                    7 días de prueba gratuita
                                </h3>
                                <p>
                                    Puedes guardar el dinero en tu cerdito. No te cobraremos nada hasta que pase el periodo de prueba.
                                </p>
                            </div>
                            <div class="block-content">
                                <p>Y después...</p>
                                <span class="price-tag price-tag--1 mt-3">
                                    <sup>€</sup>
                                    <span class="strong-700">15</span>
                                    <span class="price-type">/mes</span>
                                </span>

                                @if (!isset($user))
                                    <a href="{{ route('auth.register.subscription.get') }}" class="btn btn-styled btn-mint btn-circle btn-shadow text-uppercase strong-600 mt-3 px-5">
                                        <i class="fa fa-bolt" aria-hidden="true" style="color:#ffc107;"></i>
                                        Comenzar ahora
                                    </a>
                                @elseif(isset($user) && !$user['premium'])
                                    <a href="{{ route('account.subscription') }}" class="btn btn-styled btn-mint btn-circle btn-shadow text-uppercase strong-600 mt-3 px-5">
                                        <i class="fa fa-bolt" aria-hidden="true" style="color:#ffc107;"></i>
                                        Comenzar ahora
                                    </a>
                                @elseif(isset($user) && $user['premium'] === true)
                                    <div class="alert alert-primary" role="alert">
                                        Ya eres Premium
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="slice-xl pt-0 sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center">
                <h3 class="section-title-inner heading-2 text-normal strong-500">
                    La suscripción Premium a Geeky Theory incluye
                </h3>
            </div>

            <span class="space-xs-xl"></span>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon block-icon-lg mb-0">
                            <i class="icon-basic-heart"></i>
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">+200 lecciones</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon block-icon-lg mb-0">
                            <i class="icon-basic-webpage-multiple"></i>
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">+800 articulos</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon block-icon-lg mb-0">
                            <i class="icon-basic-clockwise"></i>
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">Soporte por email 365x7</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon block-icon-lg mb-0">
                            <i class="icon-basic-webpage-multiple"></i>
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">Cancelación gratuita</h3>
                        </div>
                    </div>
                </div>
            </div>

            <section class="slice-sm"></section>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon block-icon-lg mb-0">
                            <i class="icon-ecommerce-graph-increase"></i>
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">Más oportunidades profesionales</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon block-icon-lg mb-0">
                            <i class="icon-basic-clockwise"></i>
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">Educación en las tecnologías más importantes</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon block-icon-lg mb-0">
                            <i class="icon-basic-webpage-multiple"></i>
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">Aprendizaje práctico con ejemplos reales</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon block-icon-lg mb-0">
                            <i class="icon-software-layers2"></i>
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">Contribución directa al software libre</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="slice-xl pt-0 sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center">
                <h3 class="section-title-inner heading-2 text-normal strong-500">
                    Lo que dicen de Geeky Theory
                </h3>
            </div>

            <span class="space-xs-xl"></span>

            <div class="row cols-xs-space cols-md-space cols-lg-space">
                <div class="col-lg-4">
                    <div class="card card-blockquote z-depth-3-top">
                        <div class="card-body">
                            <div class="block-author">
                                <div class="author-image ">
                                    <img src="https://s.gravatar.com/avatar/2f78bd9412c33c6cd2b9338a0c3cc66f?s=200">
                                </div>
                                <div class="author-info">
                                    <span class="d-block heading-6 author-name strong-600 c-base-1">Mercedes Muela</span>
                                    <span class="heading-xs author-desc">Arquitecta y fundadora de Espacio Especie</span>
                                </div>
                            </div>

                            <p class="mt-4 line-height-1_8">
                                Con Geeky Theory he aprendido a realizar mi propia página web y ahora estoy al tanto de todas las nuevas tecnologías
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-blockquote z-depth-3-top">
                        <div class="card-body">
                            <div class="block-author">
                                <div class="author-image ">
                                    <img src="https://www.gravatar.com/avatar/c5e4f29f7c876fd40102d73a87025a96?s=200">
                                </div>
                                <div class="author-info">
                                    <span class="d-block heading-6 author-name strong-600 c-base-1">Miguel Catalan</span>
                                    <span class="heading-xs author-desc">Android Engineer at Product Team, Cabify</span>
                                </div>
                            </div>

                            <p class="mt-4 line-height-1_8">
                                Geeky Theory es posiblemente la mejor plataforma de aprendizaje online para convertirse en un programador experto
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-blockquote z-depth-3-top">
                        <div class="card-body">
                            <div class="block-author">
                                <div class="author-image ">
                                    <img src="https://www.gravatar.com/avatar/923ae129bd4ad8566ed65a88076abcd6?s=200">
                                </div>
                                <div class="author-info">
                                    <span class="d-block heading-6 author-name strong-600 c-base-1">Javier Andrés</span>
                                    <span class="heading-xs author-desc">ITS Software Developer, GMV</span>
                                </div>
                            </div>

                            <p class="mt-4 line-height-1_8">
                                Recomiendo Geeky Theory a todo aquel que quiera mejorar su carrera profesional viendo contenido de calidad
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="slice-xl sct-color-2 border-top border-bottom">
        <div class="container">
            <div class="row cols-md-space cols-sm-space cols-xs-space">
                <div class="col-lg-4">
                    <h3 class="heading heading-3 strong-500 text-normal">
                        Preguntas frecuentes
                    </h3>
                </div>

                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="feature feature--text-only bg-transparent">
                                <h3 class="heading heading-6 strong-600">
                                    ¿Cómo funciona la suscripción?                                
                                </h3>
                                <p>
                                    Se te harán cobros automáticos a tu tarjeta mensualmente a menos que canceles tu suscripción.
                                </p>
                            </div>

                            <div class="feature feature--text-only bg-transparent mt-5">
                                <h3 class="heading heading-6 strong-600">
                                    ¿Tengo permanencia en mi suscripción?
                                </h3>
                                <p>
                                    No hay ningún compromiso de permanencia con Geeky Theory. Tú decides cuándo darte de alta y cuándo darte de baja.
                                </p>
                            </div>

                            <div class="feature feature--text-only bg-transparent mt-5">
                                <h3 class="heading heading-6 strong-600">
                                    ¿Qué conocimientos necesito para empezar a aprender en Geeky Theory?
                                </h3>
                                <p>
                                    ¡Ninguno! En Geeky Theory enseñamos a principiantes y a expertos. Añadimos cursos continuamente para que aprendas lo máximo posible.
                                </p>
                            </div>

                            <div class="feature feature--text-only bg-transparent mt-5">
                                <h3 class="heading heading-6 strong-600">
                                    ¿Hay penalización si me doy de baja?
                                </h3>
                                <p>
                                    ¡La duda ofende! ¡Claro que no! Puedes darte de alta y de baja tantas veces como quieras sin ningún tipo de penalización.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="feature feature--text-only bg-transparent">
                                <h3 class="heading heading-6 strong-600">
                                    ¿Cada cuánto tiempo publicáis nuevos cursos?
                                </h3>
                                <p>
                                    Cada 3 ó 4 semanas. Sin embargo, intentaremos que sea de forma semanal con tu ayuda.
                                </p>
                            </div>

                            <div class="feature feature--text-only bg-transparent mt-5">
                                <h3 class="heading heading-6 strong-600">
                                    Si me doy de alta a mitad de mes, ¿lo pago completo?
                                </h3>
                                <p>
                                    No importa qué día te des de alta. Tu suscripción dura un mes completo. 
                                    Si por ejemplo te das de alta el día 20 del mes, tu suscripción durará hasta el 20 del mes siguiente y no hasta el día 1.
                                </p>
                            </div>

                            <div class="feature feature--text-only bg-transparent mt-5">
                                <h3 class="heading heading-6 strong-600">
                                    ¿Puedo darme de alta solo un mes?
                                </h3>
                                <p>
                                    ¡Claro! Tú eliges cuánto tiempo quieres ser miembro Premium porque puedes cancelar de forma gratuita y sin penalizaciones.
                                </p>
                            </div>

                            <div class="feature feature--text-only bg-transparent mt-5">
                                <h3 class="heading heading-6 strong-600">
                                    ¿Se me cobra algo durante el periodo de prueba?
                                </h3>
                                <p>
                                    No te cobraremos nada durante el periodo de prueba. ¡Para eso está!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection