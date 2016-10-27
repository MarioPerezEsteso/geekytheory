$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.js-file-input').on('change', function () {
        var siteMetaInputSource = $(this).data("image");
        // debugger;
        $.each(this.files, function (index) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var div = $("<div>", {
                    id: "foo",
                    class: "gallery-img col-md-3"
                });
                var span = $("<span>", {
                    class: "close",
                    html: "&times;"
                }).appendTo(div);
                var image = $("<img>", {
                    class: "img-responsive",
                    src: e.target.result,
                }).appendTo(div);
                $("#gallery-images-container").append(div);
            };
            reader.readAsDataURL(this);
        });
    });
});