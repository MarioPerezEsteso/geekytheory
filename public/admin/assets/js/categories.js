$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#category-image-file-input').on('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#category-image').attr('src', e.target.result);
                $('#delete-category-image').removeClass('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#delete-category-image').on('click', function (e) {
        e.preventDefault();
        $('#category-image').attr('src', '');
        $('#category-image-file-input').val('');
        $(this).addClass('hidden');
        $.ajax({
            url: '/home/categories/delete-image',
            method: 'post',
            data: {
                'id' : $('#category-image').data('category-id')
            }
        });
    });

});