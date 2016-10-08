<div class="form-group">
    {!! Form::label('adsense_script', 'Google Adsense script') !!}
    {!! Form::text('adsense_script', null, ['class' => 'form-control']) !!}
</div>
<div class="checkbox">
    <label>
        <input name="adsense_enabled" type="checkbox" {{ ($siteMeta->adsense_enabled) ? 'checked' : '' }}> {{ trans('home.enable_adsense') }}
    </label>
</div>