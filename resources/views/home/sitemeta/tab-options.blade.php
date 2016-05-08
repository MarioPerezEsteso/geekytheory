<div class="form-group">
    {!! Form::label('title', trans('home.title')) !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('subtitle', trans('home.subtitle')) !!}
    {!! Form::text('subtitle', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', trans('home.description')) !!}
    <label id="sitemeta-description-length"></label>
    {!! Form::textarea('description', null, ['rows' => '3', 'class' => 'form-control', 'required' => 'required', 'id' => 'sitemeta-description']) !!}
</div>

<div class="form-group">
    {!! Form::label('url', trans('home.site_url')) !!}
    {!! Form::text('url', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="checkbox">
    <label><input name="allow_register" type="checkbox" {{ ($siteMeta->allow_register) ? 'checked' : '' }}> {{ trans('home.allow_register') }}</label>
</div>