let ProjectCreate = function () {
    let description = function () {
        ClassicEditor
            .create(document.querySelector('.editor'))
            .catch(error => {
                console.error(error)
            });
    }



    return {
        init: function () {
            description()
        }
    };
}();


jQuery(document).ready(function () {
    $(".editor").summernote()
});
