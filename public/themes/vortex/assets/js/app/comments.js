$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".form-new-comment").submit(function (e) {
        e.preventDefault();

        var form = $(this);

        var formData = {
            'postId': form.data('postid'),
            'authorName': form.find("input[name=author_name]").val(),
            'authorEmail': form.find("input[name=author_email]").val(),
            'authorUrl': form.find("input[name=author_url]").val(),
            'body': form.find("textarea[name=body]").val()
        };

        $.ajax({
            'method': 'post',
            'url': 'comment/store',
            'data': formData,
            success: function (response) {

            },
            error: function (response) {

            }
        });

        return false;
    });

});