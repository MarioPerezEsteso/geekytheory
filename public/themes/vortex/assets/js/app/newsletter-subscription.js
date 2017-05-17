$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * Show feedback messages depending on the result of the subscription submit.
     *
     * @param alert
     * @param message
     */
    function showPostSubscriptionFeedback(alert, message) {
        var subscriptionSuccessAlert = $('.js-alert-subscription-success');
        var subscriptionErrorAlert = $('.js-alert-subscription-error');
        var timeToFadeOut = 3000;
        switch (alert) {
            case 'success':
                subscriptionSuccessAlert.removeClass('hidden');
                subscriptionSuccessAlert.html(message);
                subscriptionErrorAlert.addClass('hidden');
                break;
            case 'error':
                subscriptionSuccessAlert.addClass('hidden');
                subscriptionErrorAlert.removeClass('hidden');
                subscriptionErrorAlert.html(message);
                break;
            default:
                break;
        }
    };

    /**
     * Submit new comment.
     */
    $('.js-newsletter-subscribe').on('click', function (e) {
        var inputEmail = $('.js-newsletter-email-input');
        var email = inputEmail.val();
        if (email.trim()) {
            $.ajax({
                'method': 'post',
                'url': 'newsletter/subscribe',
                'data': {
                    'email': inputEmail.val()
                },
                success: function (response) {
                    console.log(response);
                    if (response.error == "0") {
                        showPostSubscriptionFeedback('success', response.message);
                    } else {
                        showPostSubscriptionFeedback('error', response.message);
                    }
                    inputEmail.val('');
                },
                error: function (response) {
                    showPostSubscriptionFeedback('error', 'Ha habido un error');
                }
            });
        } else {
            showPostSubscriptionFeedback('error', 'El campo de email es requerido');
        }

        return false;
    });
});