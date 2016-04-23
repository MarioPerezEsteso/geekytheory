$(document).ready(function () {

    tinymce.init({
        selector: "#post-body",
        plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste", "imageupload"],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | imageupload",
        setup :
            function(ed) {
                ed.on('init', function()
                {
                    this.getDoc().body.style.fontSize = '15px';
                });
            }
    });

    $("#post-description").keyup(function(){
        var limit = 170;
        if($(this).val().length > 170){
            $(this).val($(this).val().substr(0, limit));
        }
        $("#post-description-length").text("(" + $(this).val().length + "/170)");
    });

});