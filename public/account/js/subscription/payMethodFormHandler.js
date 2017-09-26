$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

Stripe.setPublishableKey(window.stripePublicKey);

$('#btn-add-credit-card').click(function () {
    var creditCardNameInput = $('#credit-card-name');
    var postalCodeInput = $('#postal-code');
    var creditCardNumberInput = $('#credit-card-number');
    var creditCardExpirationMonthInput = $('#credit-card-expiration-month');
    var creditCardExpirationYearInput = $('#credit-card-expiration-year');
    var creditCardExpirationCVVInput = $('#credit-card-cvv');
    const classInputWithError = 'has-danger';
    var errors = false;

    if (!creditCardNameInput.val()) {
        errors = true;
        creditCardNameInput.closest('div').addClass(classInputWithError);
    } else {
        creditCardNameInput.closest('div').removeClass(classInputWithError);
    }

    if (!postalCodeInput.val()) {
        errors = true;
        postalCodeInput.closest('div').addClass(classInputWithError);
    } else {
        postalCodeInput.closest('div').removeClass(classInputWithError);
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
            name: creditCardNameInput.val(),
            address_zip: postalCodeInput.val()
        }, stripeResponseHandler);
    }
});

/** Insert double whitespace on credit card input */
$('#credit-card-number').keyup(function () {
    if ($(this).val().length == 4 || $(this).val().length == 10 || $(this).val().length == 16) {
        $(this).val($(this).val() + '  ');
    }
});

/**
 * Stripe response handler.
 * @param status
 * @param response
 */
function stripeResponseHandler(status, response) {
    if (response.error) {
        $('#error-message').css("display", "");
    } else { // Token was created!
        $('#error-message').css("display", "none");

        // Get the token ID:
        var token = response.id;

        // Insert the token into the form so it gets submitted to the server:
        console.log(token);
        // TODO: send the token to the backend.
    }
}