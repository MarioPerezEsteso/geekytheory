$(document).ready(function () {
    let iframe = document.querySelector('iframe');
    let player = new Vimeo.Player(iframe);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    player.on('play', function () {
        $.ajax({
            'method': 'POST',
            'url': '/lesson/start',
            'data': {
                'lesson_id': $("#lesson-video").attr("data-lesson-id")
            }
        });
    });

    player.on('timeupdate', function(data){
        let currentPercent = Math.ceil(data.percent * 100);
        let lessonCompleted = false;

        if (lessonCompleted === false && currentPercent > 90) {
            let lessonId = $("#lesson-video").attr("data-lesson-id");
            $.ajax({
                'method': 'POST',
                'url': '/lesson/complete',
                'data': {
                    'lesson_id': lessonId
                },
                success: function (response) {
                    $("i#lesson-completed-icon-title-" + lessonId).removeClass('d-none');
                    $("i#lesson-uncompleted-icon-title-" + lessonId).addClass('d-none');

                    $("i#lesson-completed-icon-" + lessonId).removeClass('d-none');
                    $("img#lesson-technology-img-" + lessonId).addClass('d-none');
                },
                error: function (response) {}
            });
        }
    });
});