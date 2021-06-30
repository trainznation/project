jQuery(document).ready(function () {
    $(".editor").summernote({
        height: 300
    })

    $("#time_start").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
    })
});
