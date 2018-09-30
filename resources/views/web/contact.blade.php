@extends('web.layouts.layout')

@section('content')
    <section class="bg-base-2 holder-item holder-item-dark">
        <div class="container container-lg d-flex align-items-center">
            <div class="col">
                <div class="row py-5 justify-content-center text-center">
                    <div class="col-12 col-md-10">
                        <h2 class="heading heading-1 c-white strong-600 mt-3 animated" data-animation-in="fadeIn"
                            data-animation-delay="400">
                            ¿En qué podemos ayudarte?
                        </h2>
                        <span class="sd-1 sd-sm sd-thick-3px sd-center"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="slice-xl sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center mb-2">
                <h3 class="section-title-inner text-normal">
                    Escríbenos
                </h3>
                <span class="section-title-delimiter clearfix d-none"></span>
            </div>

            <span class="clearfix"></span>

            <span class="space-xs-xl"></span>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                <!-- Contact form -->
                    {!! Form::open(['url' => route('contact.post'), 'method' => 'POST', 'id' => 'contact-form', 'role' => 'form', 'class' => 'form-default']) !!}
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {!! Form::text('name', null, [
                                        'class' => 'form-control form-control-xl '. (isset($errors) && $errors->has('name') ? 'is-invalid' : '').'',
                                        'placeholder' => trans('public.name'),
                                        'required' => 'required']) !!}
                                @if (isset($errors) && $errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {!! Form::email('email', null, [
                                        'class' => 'form-control form-control-xl '. (isset($errors) && $errors->has('email') ? 'is-invalid' : '').'',
                                        'placeholder' => 'nombre@email.com',
                                        'required' => 'required']) !!}
                                @if (isset($errors) && $errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {!! Form::textarea('formMessage', null, [
                                        'class' => 'form-control form-control-xl '. (isset($errors) && $errors->has('formMessage') ? 'is-invalid' : '').'',
                                        'rows' => '5',
                                        'placeholder' => trans('public.message'),
                                        'required' => 'required']) !!}
                                @if (isset($errors) && $errors->has('formMessage'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('formMessage') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group has-feedback">
                                <button type="reset" class="btn-reset d-none"></button>
                                <button type="submit"
                                        class="btn btn-block btn-styled btn-lg btn-base-1 btn-shadow strong-600 mt-4">
                                    {{ trans('public.send_message') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

    @include('web.partials.gopremiumsquare')

@endsection