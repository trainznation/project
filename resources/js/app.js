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

window.$sleek=[];
window.SLEEK_PRODUCT_ID=276487884;
(function(){
    d=document;
    s=d.createElement("script");
    s.src="https://client.sleekplan.com/sdk/e.js";
    s.async=1;
    d.getElementsByTagName("head")[0].appendChild(s);
})();

