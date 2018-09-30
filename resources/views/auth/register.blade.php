@extends('web.layouts.layout')

@section('content')
    <section class="slice--offset-top bg-base-2 holder-item holder-item-dark"></section>

    <section class="slice-xl sct-color-1">
        <div class="container">
            <div class="section-title section-title--style-1 text-center mb-2">
                <h2 class="section-title-inner text-normal">
                    Escríbenos
                </h2>
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

                <!-- Email and password form -->
                    {!! Form::open(['url' => route('contact.post'), 'method' => 'POST', 'id' => 'contact-form', 'role' => 'form', 'class' => 'form-default']) !!}
                    <div class="row">
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
                        <div class="col">
                            <div class="form-group">
                                <input type="password" id="password" name="password"
                                       class="form-control form-control-xl" placeholder="Contraseña" required>
                                @if (isset($errors) && $errors->has('password'))
                                    <p>
                                        <small class="text-danger">{{ $errors->first('password') }}</small>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Email and password form -->

                    <!-- Payment form -->
                    <div class="row">
                        <div class="col">
                            <section class="slice sct-color-1">
                                <div class="container">
                                    <div class="row row-no-padding cols-xs-space cols-sm-space cols-md-space">
                                        <div class="col">
                                            <form class="form-default mt-4" data-toggle="validator" role="form">
                                                <h3 class="heading heading-3 strong-400 mb-4">Payment method</h3>

                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <label class="heading heading-6 strong-600 mt-2 pl-4">Tarjeta de crédito</label>
                                                                <p class="c-gray-light mt-2 pl-4">
                                                                    Safe money transfer using your bank account. We support Mastercard, Visa, Maestro and Skrill.
                                                                </p>
                                                            </div>

                                                            <div class="col-lg-4 text-lg-right">
                                                                <img src="/assets/images/cards/mastercard.png" width="40" class="mr-2">
                                                                <img src="/assets/images/cards/visa.png" width="40" class="mr-2">
                                                                <img src="/assets/images/cards/american-express.png" width="40">
                                                            </div>
                                                        </div>

                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <div class="form-group">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Número de tarjeta</label>
                                                                    <div class="input-group input-group--style-1">
                                                                        <input type="text" class="form-control form-control-lg input-mask" data-mask="0000 0000 0000 0000" placeholder="0000 0000 0000 0000" autocomplete="off" maxlength="19">
                                                                        <span class="input-group-addon">
                                                                            <i class="ion-card"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Fecha de caducidad</label>
                                                                    <input type="text" class="form-control form-control-lg input-mask" data-mask="00/00" placeholder="MM/YY" autocomplete="off" maxlength="5">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">CVV</label>
                                                                    <div class="input-group input-group--style-1">
                                                                        <input type="text" class="form-control form-control-lg input-mask" data-mask="000" autocomplete="off" maxlength="3">
                                                                        <span class="input-group-addon" data-toggle="popover" title="" data-content="It is a three digit code that can be found only on the back of your card. Be carefull so no one sees it." data-original-title="What is a CVV code?">
                                                                    <i class="ion-help-circled"></i>
                                                                </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
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
@endsection

@section('customJavascript')
    {!! Html::script('/assets/js/jquery-md5/jquery-md5.js') !!}
    {!! Html::script('/assets/courses/js/auth.js') !!}
@endsection
