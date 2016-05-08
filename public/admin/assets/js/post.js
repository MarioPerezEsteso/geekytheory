$(document).ready(function () {

    tinymce.init({
        selector: "#post-body",
        plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste", "imageupload"],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | imageupload",
        setup: function (ed) {
            ed.on('init', function () {
                this.getDoc().body.style.fontSize = '15px';
            });
        },
        convert_urls: false
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#post-description').keyup(function () {
        var limit = 170;
        if ($(this).val().length > 170) {
            $(this).val($(this).val().substr(0, limit));
        }
        $('#post-description-length').text('(' + $(this).val().length + '/170)');
    });

    $('#post-image-file-input').on('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#post-image').attr('src', e.target.result);
                $('#delete-post-image').removeClass('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#delete-post-image').on('click', function (e) {
        e.preventDefault();
        $('#post-image').attr('src', '');
        $('#post-image-file-input').val('');
        $(this).addClass('hidden');
        $.ajax({
            url: '/home/posts/delete-image',
            method: 'post',
            data: {
                'id' : $('#post-image').data('post-id')
            }
        });
    });

});