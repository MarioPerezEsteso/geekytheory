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