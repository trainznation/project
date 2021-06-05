require('./bootstrap');

require('alpinejs');
require('summernote/src/js/summernote')

$(".readNotification").on('click', function (e) {
    e.preventDefault()
    $.ajax({
        url: '/account/readAllNotification',
        error: (err) => {
            console.error(err)
        }
    })
})
