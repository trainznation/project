/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/project/show_files.js ***!
  \********************************************/
var projectContainer = document.querySelector("#project");
var kt_modal_users_search_handler = document.querySelector('#kt_modal_users_search_handler');
var wrapper = kt_modal_users_search_handler.querySelector('[data-kt-search-element="wrapper"]');
var suggestion = kt_modal_users_search_handler.querySelector('[data-kt-search-element="suggestions"]');
var results = kt_modal_users_search_handler.querySelector('[data-kt-search-element="results"]');
var empty = kt_modal_users_search_handler.querySelector('[data-kt-search-element="empty"]');
var content_file = document.querySelector('#content_files');
var dropzoneContainer = "#dropzonejs";
var kt_filter_search = document.querySelector('#kt_filter_search');
var search;

function humanFileSize(bytes) {
  var si = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  var dp = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;
  var thresh = si ? 1000 : 1024;

  if (Math.abs(bytes) < thresh) {
    return bytes + ' B';
  }

  var units = si ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
  var u = -1;
  var r = Math.pow(10, dp);

  do {
    bytes /= thresh;
    ++u;
  } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);

  return bytes.toFixed(dp) + ' ' + units[u];
}

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
          "project_id": projectContainer.dataset.projectId,
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
        content_file.innerHTML += "\n                    <div class=\"col-12 col-sm-12 col-xl\">\n                        <!--begin::Card-->\n                        <div class=\"card h-100\">\n                            <!--begin::Card body-->\n                            <div class=\"card-body d-flex justify-content-center text-center flex-column p-8\">\n                                <!--begin::Name-->\n                                <a href=\"/project/".concat(document.querySelector('#project').dataset.projectId, "/files/").concat(file.id, "/dispatcher\" class=\"text-gray-800 text-hover-primary d-flex flex-column\">\n                                    <!--begin::Image-->\n                                    <div class=\"symbol symbol-60px mb-6\">\n                                        <img src=\"/storage/core/icons_files/").concat(file.type, ".png\" alt=\"\" data-bs-toggle=\"popover\" title=\"Fichier ").concat(file.name, "\" data-bs-html=\"true\" data-bs-content=\"<strong>Type:</strong> ").concat(file.type, " <br><strong>Nom:</strong> ").concat(file.name, " <br><strong>Taille:</strong> ").concat(humanFileSize(file.size, true, 2), "\"/>\n                                    </div>\n                                    <!--end::Image-->\n                                    <!--begin::Title-->\n                                    <div class=\"fs-5 fw-bolder mb-2\">").concat(file.name, "</div>\n                                    <!--end::Title-->\n                                </a>\n                                <!--end::Name-->\n                                <!--begin::Description-->\n                                <div class=\"fs-7 fw-bold text-gray-400 mt-auto\">").concat(file.created_at, "</div>\n                                <!--end::Description-->\n                            </div>\n                            <!--end::Card body-->\n                        </div>\n                        <!--end::Card-->\n                    </div>\n                ");
      });
      content_file.querySelectorAll('.col-12').forEach(function (item) {
        item.addEventListener('blur', function (e) {
          e.preventDefault();
          var popover = new bootstrap.Popover(item);
          popover.show();
        });
      });
    },
    error: function error(err) {
      console.log(err);
    }
  });
}

function searchFilesList() {
  if (kt_filter_search.value !== null) {
    kt_filter_search.addEventListener('keyup', function (e) {
      e.preventDefault();
      $.ajax({
        url: "/api/project/".concat(projectContainer.dataset.projectId, "/files/search"),
        method: 'POST',
        data: {
          "q": kt_filter_search.value
        },
        success: function success(data) {
          if (data.files.length === 0) {
            content_file.innerHTML = "\n                        <div class=\"alert alert-dismissible bg-light-info d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10\">\n                            <!--begin::Close-->\n                            <button type=\"button\" class=\"position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger\" data-bs-dismiss=\"alert\">\n                                <span class=\"svg-icon svg-icon-1\">\n                                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\">\n                                        <path opacity=\"0.25\" fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z\" fill=\"#12131A\"></path>\n                                        <path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z\" fill=\"#12131A\"></path>\n                                    </svg>\n                                </span>\n                            </button>\n                            <!--end::Close-->\n\n                            <!--begin::Icon-->\n                            <span class=\"svg-icon svg-icon-5tx svg-icon-info mb-5\">\n                                <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"24px\" height=\"24px\" viewBox=\"0 0 24 24\" version=\"1.1\">\n                                    <g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">\n                                        <rect x=\"0\" y=\"0\" width=\"24\" height=\"24\"/>\n                                        <path d=\"M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z\" fill=\"#000000\" fill-rule=\"nonzero\" opacity=\"0.3\"/>\n                                        <path d=\"M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z\" fill=\"#000000\" fill-rule=\"nonzero\"/>\n                                    </g>\n                                </svg>\n                            </span>\n                            <!--end::Icon-->\n\n                            <!--begin::Wrapper-->\n                            <div class=\"text-center\">\n                                <!--begin::Title-->\n                                <h5 class=\"fw-bolder fs-1 mb-5\">Aucun fichier disponible</h5>\n                                <!--end::Title-->\n\n                                <!--begin::Separator-->\n                                <div class=\"separator separator-dashed border-info opacity-25 mb-5\"></div>\n                                <!--end::Separator-->\n\n                                <!--begin::Content-->\n                                <div class=\"mb-9\">\n                                    Il n'y \xE0 aucun fichier de disponible avec le terme: <strong>".concat(kt_filter_search.value, "</strong>\n                                </div>\n                                <!--end::Content-->\n                            </div>\n                            <!--end::Wrapper-->\n                        </div>\n                        ");
          } else {
            content_file.innerHTML = "";
            data.files.forEach(function (file) {
              content_file.innerHTML += "\n                            <div class=\"col-12 col-sm-12 col-xl\">\n                                <!--begin::Card-->\n                                <div class=\"card h-100\">\n                                    <!--begin::Card body-->\n                                    <div class=\"card-body d-flex justify-content-center text-center flex-column p-8\">\n                                        <!--begin::Name-->\n                                        <a href=\"/project/".concat(document.querySelector('#project').dataset.projectId, "/files/").concat(file.id, "/dispatcher\" class=\"text-gray-800 text-hover-primary d-flex flex-column\">\n                                            <!--begin::Image-->\n                                            <div class=\"symbol symbol-60px mb-6\">\n                                                <img src=\"/storage/core/icons_files/").concat(file.type, ".png\" alt=\"\" data-bs-toggle=\"popover\" title=\"Fichier ").concat(file.name, "\" data-bs-html=\"true\" data-bs-content=\"<strong>Type:</strong> ").concat(file.type, " <br><strong>Nom:</strong> ").concat(file.name, " <br><strong>Taille:</strong> ").concat(humanFileSize(file.size, true, 2), "\"/>\n                                            </div>\n                                            <!--end::Image-->\n                                            <!--begin::Title-->\n                                            <div class=\"fs-5 fw-bolder mb-2\">").concat(file.name, "</div>\n                                            <!--end::Title-->\n                                        </a>\n                                        <!--end::Name-->\n                                        <!--begin::Description-->\n                                        <div class=\"fs-7 fw-bold text-gray-400 mt-auto\">").concat(file.created_at, "</div>\n                                        <!--end::Description-->\n                                    </div>\n                                    <!--end::Card body-->\n                                </div>\n                                <!--end::Card-->\n                            </div>\n                        ");
            });
          }
        },
        error: function error(err) {
          toastr.error("Erreur");
        }
      });
    });
  }
}

searchUserList();
initContentFile();
searchFilesList();
searchUserList();
jQuery(document).ready(function () {
  var previewNode = $(dropzoneContainer + " .dropzone-item");
  previewNode.id = "";
  var previewTemplate = previewNode.parent(".dropzone-items").html();
  previewNode.remove();
  var myDropzone = new Dropzone(dropzoneContainer, {
    // Make the whole body a dropzone
    url: "/project/".concat(projectContainer.dataset.projectId, "/files/upload"),
    // Set the url for your upload script location
    parallelUploads: 40,
    previewTemplate: previewTemplate,
    maxFilesize: 100,
    // Max filesize in MB
    autoQueue: false,
    // Make sure the files aren't queued until manually added
    previewsContainer: dropzoneContainer + " .dropzone-items",
    // Define the container to display the previews
    clickable: dropzoneContainer + " .dropzone-select" // Define the element that should be used as click trigger to select files.

  });
  myDropzone.on("addedfile", function (file) {
    // Hookup the start button
    file.previewElement.querySelector(dropzoneContainer + " .dropzone-start").onclick = function () {
      myDropzone.enqueueFile(file);
    };

    $(document).find(dropzoneContainer + " .dropzone-item").css("display", "");
    $(dropzoneContainer + " .dropzone-upload, " + dropzoneContainer + " .dropzone-remove-all").css("display", "inline-block");
  });
  myDropzone.on("totaluploadprogress", function (progress) {
    $(this).find(dropzoneContainer + " .progress-bar").css("width", progress + "%");
  });
  myDropzone.on("sending", function (file) {
    // Show the total progress bar when upload starts
    $(dropzoneContainer + " .progress-bar").css("opacity", "1"); // And disable the start button

    file.previewElement.querySelector(dropzoneContainer + " .dropzone-start").setAttribute("disabled", "disabled");
  });
  myDropzone.on("complete", function (progress) {
    var thisProgressBar = dropzoneContainer + " .dz-complete";
    setTimeout(function () {
      $(thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress, " + thisProgressBar + " .dropzone-start").css("opacity", "0");
    }, 300);
  });

  document.querySelector(dropzoneContainer + " .dropzone-upload").onclick = function () {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
  };

  document.querySelector(dropzoneContainer + " .dropzone-remove-all").onclick = function () {
    $(dropzoneContainer + " .dropzone-upload, " + dropzoneContainer + " .dropzone-remove-all").css("display", "none");
    myDropzone.removeAllFiles(true);
  };

  myDropzone.on("queuecomplete", function (progress) {
    $(dropzoneContainer + " .dropzone-upload").css("display", "none");
  });
  myDropzone.on("removedfile", function (file) {
    if (myDropzone.files.length < 1) {
      $(dropzoneContainer + " .dropzone-upload, " + dropzoneContainer + " .dropzone-remove-all").css("display", "none");
    }
  });
  document.querySelector('#upload_file').addEventListener('hidden.bs.modal', function (e) {
    window.location.reload();
  });
});
/******/ })()
;