/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/project/show_files.js ***!
  \********************************************/
var kt_modal_users_search_handler = document.querySelector('#kt_modal_users_search_handler');
var wrapper = kt_modal_users_search_handler.querySelector('[data-kt-search-element="wrapper"]');
var suggestion = kt_modal_users_search_handler.querySelector('[data-kt-search-element="suggestions"]');
var results = kt_modal_users_search_handler.querySelector('[data-kt-search-element="results"]');
var empty = kt_modal_users_search_handler.querySelector('[data-kt-search-element="empty"]');
var content_file = document.querySelector('#content_files');
var search;

function searchUserList() {
  var searching = function searching(e) {
    console.log(e);
    kt_modal_users_search_handler.addEventListener('keyup', function (e) {
      e.preventDefault();
      $.ajax({
        url: '/api/user/searching',
        method: 'POST',
        data: {
          "search": kt_modal_users_search_handler.querySelector('[data-kt-search-element="input"]').value,
          "project_id": project_overview_chart.dataset.projectId,
          "user_id": document.querySelector('#kt_body').dataset.userId
        },
        success: function success(data) {
          suggestion.classList.add('d-none');
          $('[data-kt-search-element="results"]').removeClass('d-none');
          $('[data-kt-search-element="results"]').html(data.content);
          console.log(data);
        },
        error: function error(err) {
          console.error(err);
        }
      });
    });
  };

  var clearSearch = function clearSearch(e) {
    suggestion.classList.remove('d-none');
    results.classList.add('d-none');
    empty.classList.add('d-none');
  };

  (search = new KTSearch(kt_modal_users_search_handler)).on("kt.search.process", searching);
  search.on("kt.search.clear", clearSearch);
}

function initContentFile() {
  $.ajax({
    url: "/api/project/".concat(document.querySelector('#project').dataset.projectId, "/files"),
    success: function success(data) {
      content_file.innerHTML = "";
      data.files.forEach(function (file) {
        content_file.innerHTML += "\n                    <div class=\"col-12 col-sm-12 col-xl\">\n                        <!--begin::Card-->\n                        <div class=\"card h-100\">\n                            <!--begin::Card body-->\n                            <div class=\"card-body d-flex justify-content-center text-center flex-column p-8\">\n                                <!--begin::Name-->\n                                <a href=\"/project/".concat(document.querySelector('#project').dataset.projectId, "/files/").concat(file.id, "/dispatcher\" class=\"text-gray-800 text-hover-primary d-flex flex-column\">\n                                    <!--begin::Image-->\n                                    <div class=\"symbol symbol-60px mb-6\">\n                                        <img src=\"/storage/core/icons_files/").concat(file.type, ".png\" alt=\"\" data-toggle=\"tooltip\" title=\"").concat(file.type, "\"/>\n                                    </div>\n                                    <!--end::Image-->\n                                    <!--begin::Title-->\n                                    <div class=\"fs-5 fw-bolder mb-2\">").concat(file.name, "</div>\n                                    <!--end::Title-->\n                                </a>\n                                <!--end::Name-->\n                                <!--begin::Description-->\n                                <div class=\"fs-7 fw-bold text-gray-400 mt-auto\">").concat(file.created_at, "</div>\n                                <!--end::Description-->\n                            </div>\n                            <!--end::Card body-->\n                        </div>\n                        <!--end::Card-->\n                    </div>\n                ");
      });
    },
    error: function error(err) {
      console.log(err);
    }
  });
}

searchUserList();
initContentFile();
jQuery(document).ready(function () {});
/******/ })()
;