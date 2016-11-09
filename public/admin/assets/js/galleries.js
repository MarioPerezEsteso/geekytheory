$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.js-file-input').on('change', function () {
        $.each(this.files, function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                var div = $("<div>", {
                    class: "gallery-img col-sm-6 col-md-4 col-lg-3"
                });
                // var span = $("<span>", {
                //     class: "close js-delete-image",
                //     html: "&times;"
                // }).appendTo(div);
                var image = $("<img>", {
                    class: "img-responsive",
                    src: e.target.result,
                }).appendTo(div);
                $("#gallery-images-container").append(div);
            };
            reader.readAsDataURL(this);
        });
    });

    $(document).on('click', '.js-delete-image', function () {
        var imageId = $(this).data('image-id');
        var span = $(this);
        if (imageId) {
            $.ajax({
                method: 'post',
                url: '/home/gallery/image/delete',
                data: {
                    imageId: imageId
                },
                success: function (response) {
                    span.parent('.gallery-img').fadeOut(300, function () {
                        $(this).remove();
                    });
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    });
});