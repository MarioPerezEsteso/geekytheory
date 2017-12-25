/**
 * Mark lesson as completed when the video finish.
 */
$(document).ready(function () {
    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    player.on('ended', function () {
        var lessonId = $('body').attr("data-lesson-id");

        var formData = {
            'lesson_id': lessonId
        };

        $.ajax({
            'method': 'post',
            'url': '/lesson/complete',
            'data': formData,
            success: function (response) {
            },
            error: function (response) {
            }
        });
    });
});