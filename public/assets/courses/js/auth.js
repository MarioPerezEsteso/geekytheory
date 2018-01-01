$(document).ready(function () {
    var getGravatar = function (email) {
        var base = 'https://secure.gravatar.com/avatar/';
        email = email.trim().toLowerCase();

        return base + $.md5(email) + "?s=250";
    };

    $('#email').focusout(function () {
        $("#profile-img").attr("src", getGravatar($('#email').val()));
    });
});
