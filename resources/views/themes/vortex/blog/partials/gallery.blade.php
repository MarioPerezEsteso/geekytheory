<div class="row">
	<div class="col-lg-12">
		<div class="carousel slide">
			<div data-gallery-id="{{ $gallery->id }}" class="pictures-gallery" itemscope itemtype="http://schema.org/ImageGallery">
				<?php $firstImage = true; ?>
				<?php $item = 0; ?>
				@foreach ($images as $image)
					@if ($item > 0)
						<?php $firstImage = false; ?>
					@endif
					<figure itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
						<a href="{{ App\Http\Controllers\ImageController::getPublicImageUrl($image->image, true) }}" itemprop="contentUrl" data-size="{{ $image->width }}x{{ $image->height }}">
							<img src="{{ App\Http\Controllers\ImageController::getPublicImageUrl($image->image, true) }}" 
							itemprop="thumbnail" alt="" style="{{ $firstImage ? '' : 'display:none' }}">
						</a>
					</figure>
					<?php $item++; ?>
				@endforeach
			</div>
			<a data-gallery-id="{{ $gallery->id }}" class="right carousel-control carousel-control-post" href="#">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	</div>
</div>