<div class="row pricing">
    <div class="col-sm-8 col-sm-offset-2 col-xs-12">
        <h2>Planes</h2>
        <br>
        <div class="row">
            <div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5 col-xs-12">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Básico
                    </li>
                    <li class="plan-price">
                        <strong>0 €/mes</strong>
                    </li>
                    <li>
                        <strong>Acceso a cursos gratuitos</strong>
                    </li>
                    <li class="plan-action">
                        @if (!isset($user))
                            <a href="{{ route('auth.register.get') }}"
                               class="btn btn-inverse btn-lg">{{ trans('public.i_want_it') }}</a>
                        @elseif(isset($user) && !$user['premium'])
                            <a href="{{ route('account.subscription') }}"
                               class="btn btn-inverse btn-lg">{{ trans('public.you_have_it') }}</a>
                        @endif
                    </li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-5 col-xs-12">
                <ul class="plan plan2 featured">
                    <li class="plan-name">
                        Premium
                    </li>
                    <li class="plan-price">
                        <strong>15 €/mes</strong>
                    </li>
                    <li>
                        <strong>Acceso a todo el contenido</strong>
                    </li>
                    <li>
                        <strong>Certificado de finalización</strong>
                    </li>
                    {{--<li>
                        <strong>Preguntar dudas en cada curso</strong>
                    </li>--}}
                    <li>
                        <strong>Acceso a contenido exclusivo</strong>
                    </li>
                    <li>
                        <strong>Soporte</strong>
                    </li>
                    <li class="plan-action">
                        @if (!isset($user))
                            <a href="{{ route('auth.register.get') }}"
                               class="btn btn-primary btn-lg">{{ trans('public.i_want_it') }}</a>
                        @elseif (!isset($user) || (isset($user) && !$user['premium']))
                            <a href="{{ route('account.subscription') }}"
                               class="btn btn-primary btn-lg">{{ trans('public.i_want_it') }}</a>
                        @elseif(isset($user) && $user['premium'])
                            <a href="{{ route('account.subscription') }}"
                               class="btn btn-primary btn-lg">{{ trans('public.you_have_it') }}</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>