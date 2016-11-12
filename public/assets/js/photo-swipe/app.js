var photoSwiper = $('.pswp')[0];
var image = [];

/**
 * Get the items of a gallery.
 * 
 * @param  gallery
 * @return array
 */
 var getItems = function(gallery) {
 	var items = [];
 	gallery.find('a').each(function() {
 		var href = $(this).attr('href'),
 		size = $(this).data('size').split('x'),
 		width = size[0],
 		height = size[1];

 		var item = {
 			src: href,
 			w: width,
 			h: height
 		};

 		items.push(item);
 	});

 	return items;
 };

/**
 * Get the default options for the photo swiper.
 * 
 * @param  index Index of the picture.
 * @return array	Array with the default options.
 */
 var getOptions = function(index) {
 	return {
 		index: index,
 		bgOpacity: 0.7,
 		showHideOpacity: true
 	};
 };

 $('.pictures-gallery').each( function() {
 	var pictures = $(this);

 	var items = getItems(pictures);

 	$.each(items, function(index, value) {
 		image[index] = new Image();
 		image[index].src = value['src'];
 	});

 	pictures.on('click', 'figure', function(event) {
 		event.preventDefault();

 		var index = $(this).index(),
 		options = getOptions(index);

 		var gallery = new PhotoSwipe(photoSwiper, PhotoSwipeUI_Default, items, options);
 		gallery.init();
 	});

 });

 $('.carousel-control-post').on('click', function (event) {
 	event.preventDefault();

 	var options = getOptions(0),
 	galleryId = $(this).data('gallery-id'),
 	items = getItems($(".pictures-gallery[data-gallery-id='" + galleryId + "']"));

 	var gallery = new PhotoSwipe(photoSwiper, PhotoSwipeUI_Default, items, options);
 	gallery.init();
 });
