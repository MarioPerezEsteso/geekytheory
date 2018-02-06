$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

Stripe.setPublishableKey(window.stripePublicKey);

$('#btn-add-credit-card').click(function () {
    var creditCardNameInput = $('#credit-card-name');
    var creditCardNumberInput = $('#credit-card-number');
    var creditCardExpirationMonthInput = $('#credit-card-expiration-month');
    var creditCardExpirationYearInput = $('#credit-card-expiration-year');
    var creditCardExpirationCVVInput = $('#credit-card-cvv');
    var errors = false;

    const classInputWithError = 'has-danger';

    if (!creditCardNameInput.val()) {
        errors = true;
        creditCardNameInput.closest('div').addClass(classInputWithError);
    } else {
        creditCardNameInput.closest('div').removeClass(classInputWithError);
    }

    if (!Stripe.card.validateCardNumber(creditCardNumberInput.val())) {
        errors = true;
        creditCardNumberInput.closest('div').addClass(classInputWithError);
    } else {
        creditCardNumberInput.closest('div').removeClass(classInputWithError);
    }

    if (!Stripe.card.validateExpiry(creditCardExpirationMonthInput.val(), creditCardExpirationYearInput.val())) {
        errors = true;
        creditCardExpirationMonthInput.closest('div').addClass(classInputWithError);
        creditCardExpirationYearInput.closest('div').addClass(classInputWithError);
    } else {
        creditCardExpirationMonthInput.closest('div').removeClass(classInputWithError);
        creditCardExpirationYearInput.closest('div').removeClass(classInputWithError);
    }

    if (!Stripe.card.validateCVC(creditCardExpirationCVVInput.val())) {
        errors = true;
        creditCardExpirationCVVInput.closest('div').addClass(classInputWithError);
    } else {
        creditCardExpirationCVVInput.closest('div').removeClass(classInputWithError);
    }

    if (!errors) {
        Stripe.card.createToken({
            number: creditCardNumberInput.val(),
            cvc: creditCardExpirationCVVInput.val(),
            exp_month: creditCardExpirationMonthInput.val(),
            exp_year: creditCardExpirationYearInput.val(),
            name: creditCardNameInput.val()
        }, stripeResponseHandler);
    }
});

/** Insert double whitespace on credit card input */
$('#credit-card-number').keyup(function () {
    if ($(this).val().length == 4 || $(this).val().length == 10 || $(this).val().length == 16) {
        $(this).val($(this).val() + '  ');
    }
});

$('#coupon').keyup(function () {
    if ($(this).val()) {
        $('#btn-apply-coupon').prop('disabled', false);
    } else {
        $('#btn-apply-coupon').prop('disabled', true);
        $('#coupon-valid-alert').css('display', 'none');
        $('#coupon-invalid-alert').css('display', 'none');
    }
});

$('#btn-apply-coupon').click(function () {
    $.ajax({
        type: 'POST',
        url: '/coupon/validate',
        data: {
            coupon: $('#coupon').val()
        },
        dataType: 'JSON',
        success: function (coupon) {
            var couponValidAlert = $('#coupon-valid-alert');
            var couponInvalidAlert = $('#coupon-invalid-alert');
            if (coupon.status === 'valid') {
                if (coupon.duration === 'forever') {
                    couponValidAlert.html(coupon.percent_off + '% de descuento para siempre.');
                } else {
                    if (coupon.duration_in_months > 1) {
                        couponValidAlert.html(coupon.percent_off + '% de descuento durante ' + coupon.duration_in_months + ' meses.'); 
                    } else {
                        couponValidAlert.html(coupon.percent_off + '% de descuento durante ' + coupon.duration_in_months + ' mes.'); 
                    }
                }
                couponValidAlert.css('display', '');
                couponInvalidAlert.css('display', 'none');
            } else {
                if (coupon.status === 'redeemed') {
                    couponInvalidAlert.html('El cupón ya ha sido utilizado.')
                } else if (coupon.status === 'expired') {
                    couponInvalidAlert.html('Este cupón ha expirado.');
                } else {
                    couponInvalidAlert.html('Este cupón no es válido.')
                }

                couponValidAlert.css('display', 'none');
                couponInvalidAlert.css('display', '');
            }
        },
        error: function (response) {
            $('#coupon-invalid-alert').html('Ha habido un error aplicando el cupón.')
            $('#coupon-invalid-alert').css("display", "");
            $('#coupon-valid-alert').css("display", "none");
        }
    });
});

/**
 * Stripe response handler.
 * @param status
 * @param response
 */
function stripeResponseHandler(status, response) {
    if (response.error) {
        $('#error-message').css("display", "");
    } else {
        $('#error-message').css("display", "none");
        // Get the token ID
        var token = response.id;
        var coupon = $('#coupon').val();

        // Submit the form with the Stripe Token
        var form = $('#subscription-form');

        form.append($('<input type="hidden" name="stripe_token" />').val(token));
        form.append($('<input type="hidden" name="coupon" />').val(coupon));

        form.get(0).submit();
    }
}