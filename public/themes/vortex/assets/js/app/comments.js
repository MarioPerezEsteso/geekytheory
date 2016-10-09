$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * Empty the comment form.
     *
     * @param commentForm
     */
    var emptyCommentForm = function (commentForm) {
        commentForm.find("input[name=author_name]").val('');
        commentForm.find("input[name=author_email]").val('');
        commentForm.find("input[name=author_url]").val('');
        commentForm.find("textarea[name=body]").val('');
    };

    /**
     * Show feedback messages depending on the result of the comment submit.
     *
     * @param alert
     */
    var showPostCommentFeedback = function (alert) {
        var commentSuccessAlert = $('.comment-success-alert');
        var commentErrorAlert = $('.comment-error-alert');
        var commentSpamAlert = $('.comment-spam-alert');
        var timeToFadeOut = 3000;
        switch (alert) {
            case 'success':
                commentSuccessAlert.show();
                commentErrorAlert.hide();
                commentSpamAlert.hide();
                commentSuccessAlert.delay(timeToFadeOut).fadeOut('slow');
                break;
            case 'error':
                commentSuccessAlert.hide();
                commentErrorAlert.show();
                commentSpamAlert.hide();
                commentErrorAlert.delay(timeToFadeOut).fadeOut('slow');
                break;
            case 'spam':
                commentSuccessAlert.hide();
                commentErrorAlert.hide();
                commentSpamAlert.show();
                commentSpamAlert.delay(timeToFadeOut).fadeOut('slow');
                break;
            default:
                break;
        }
    };

    /**
     * Submit new comment.
     */
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
                    if (formData.parent) {
                        $(".comment-reply-container[data-comment='" + formData.parent + "']").append(response.html);
                        $(".reply-comment-form[data-in-reply-to='" + formData.parent + "']").empty();
                    } else {
                        if (response.spam == 0) {
                            $(".comments-container").append(response.html);
                            showPostCommentFeedback('success');
                        } else {
                            showPostCommentFeedback('spam');
                        }
                    }
                } else {
                    showPostCommentFeedback('error');
                }
                emptyCommentForm(form);
            },
            error: function (response) {
                showPostCommentFeedback('error');
            }
        });

        return false;
    });

    /**
     * Get form to reply a comment.
     */
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