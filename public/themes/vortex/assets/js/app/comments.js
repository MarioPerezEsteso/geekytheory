$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('submit', '.form-new-comment', function (e) {
        e.preventDefault();

        var form = $(this);

        var formData = {
            'postId': form.data('postid'),
            'parent': form.data('parent'),
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
                if (response.error == 0) {
                    $(".comment-reply-container[data-comment='" + formData.parent + "']").append(response.html);
                    $(".reply-comment-form[data-in-reply-to='" + formData.parent + "']").empty();
                }
            },
            error: function (response) {

            }
        });

        return false;
    });

    $(document).on('click', '.reply-comment-button', function (e) {
        e.preventDefault();

        var anchor = $(this);

        var formData = {
            'parent': anchor.data('in-reply-to')
        };

        $.ajax({
            'method': 'get',
            'url': 'comment/getForm',
            'data': formData,
            success: function (response) {
                if (!response.error) {
                    $(".reply-comment-form[data-in-reply-to='" + formData.parent + "']").append(response);
                }
            }
        });

    });

});