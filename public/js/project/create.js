/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/project/create.js ***!
  \****************************************/
var ProjectCreate = function () {
  var description = function description() {
    ClassicEditor.create(document.querySelector('.editor'))["catch"](function (error) {
      console.error(error);
    });
  };

  return {
    init: function init() {
      description();
    }
  };
}();

jQuery(document).ready(function () {
  $(".editor").summernote();
});
/******/ })()
;