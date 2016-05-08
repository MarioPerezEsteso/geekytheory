@foreach(\App\Http\Controllers\Controller::$socialNetworks as $socialNetwork)
    <div class="form-group">
        {!! Form::label($socialNetwork, trans('public.' . $socialNetwork)) !!}
        {!! Form::text($socialNetwork, null, ['class' => 'form-control']) !!}
    </div>
@endforeach