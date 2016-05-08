@foreach($fileUploaders as $key => $fileUploader)
    <div class="row top15">
        <div class="col-md-12">
            <label>{{ $fileUploader['title'] }}</label>
            <?php $imgSrc = ""; ?>
            @if(!empty($siteMeta->$key))
                <?php $imgSrc = \App\Http\Controllers\ImageManagerController::getPublicImageUrl($siteMeta->$key, true); ?>
            @endif
            <img id="{{ $key }}" class="img-responsive" src="{{ $imgSrc }}"/>
        </div>
    </div>
    <div class="row top15">
        <div class="col-md-12">
        <span class="btn btn-primary btn-file">
            {{ trans('home.browse') }}
            {!! Form::file('image', array('id' => $key . '-file-input', 'class' => 'js-file-input', 'data-image' => $key)) !!}
        </span>
            <button id="button-delete-{{ $key }}" data-image="{{ $key }}" class="btn btn-danger delete-image {{ (!empty($imgSrc)) ? '' : ' hidden ' }}">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
        </div>
    </div>
    <hr>
@endforeach