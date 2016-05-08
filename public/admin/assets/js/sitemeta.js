$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#sitemeta-description').keyup(function () {
        var limit = 170;
        if ($(this).val().length > 170) {
            $(this).val($(this).val().substr(0, limit));
        }
        $('#sitemeta-description-length').text('(' + $(this).val().length + '/170)');
    });

    $('.js-file-input').on('change', function () {
        var siteMetaInputSource = $(this).data("image");
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('img#' + siteMetaInputSource).attr('src', e.target.result);
                $('button#button-delete-' + siteMetaInputSource).removeClass('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('.delete-image').on('click', function (e) {
        e.preventDefault();
        var siteMetaImage = $(this).data('image');
        $('img#' + siteMetaImage).attr('src', '');
        $('input#' + siteMetaImage + '-file-input').val('');
        $(this).addClass('hidden');
        $.ajax({
            url: '/home/sitemeta/delete-image',
            method: 'post',
            data: {
                'imageToDelete' : siteMetaImage
            }
        });
    });

});