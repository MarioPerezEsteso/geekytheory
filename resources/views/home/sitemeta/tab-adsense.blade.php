<div class="form-group">
    {!! Form::label('adsense_script', 'Google Adsense script') !!}
    {!! Form::textarea('adsense_script', null, ['class' => 'form-control', 'rows' => '4']) !!}
</div>
<div class="checkbox">
    <label>
        <input name="adsense_enabled" type="checkbox" {{ ($siteMeta->adsense_enabled) ? 'checked' : '' }}> {{ trans('home.enable_adsense') }}
    </label>
</div>