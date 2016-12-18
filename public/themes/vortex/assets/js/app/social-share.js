$(document).ready(function () {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	/**
	 * Share post.
	 */
	$(document).on('click', '.social-icon-link', function (e) {
		e.preventDefault();

		var link = $(this),
			linkHref = link.attr('href');

		var shareData = {
			'postId': link.data('postid'),
			'socialNetwork': link.data('socialnetwork'),
		};

		$.ajax({
			'method': 'post',
			'url': 'share-article',
			'data': shareData
		});

		if (shareData['socialNetwork'] == 'mail' || shareData['socialNetwork'] == 'telegram') {
			window.location.href = linkHref;
		} else {
			window.open(linkHref, 'share', 'width=900,height=600');
		}

		return false;
	});
});