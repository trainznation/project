/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/project/show_tasks.js ***!
  \********************************************/
var kt_modal_users_search_handler = document.querySelector('#kt_modal_users_search_handler');
var wrapper = kt_modal_users_search_handler.querySelector('[data-kt-search-element="wrapper"]');
var suggestion = kt_modal_users_search_handler.querySelector('[data-kt-search-element="suggestions"]');
var results = kt_modal_users_search_handler.querySelector('[data-kt-search-element="results"]');
var empty = kt_modal_users_search_handler.querySelector('[data-kt-search-element="empty"]');
var search;
var datatable = $("#table_project_task");
var table = document.querySelector('#table_project_task');

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

searchUserList();
jQuery(document).ready(function () {
  datatable.DataTable();
  table.querySelectorAll('[data-action="view"]').forEach(function (action) {
    action.addEventListener('click', function (e) {
      e.preventDefault();
      $.ajax({
        url: action.getAttribute('href'),
        success: function success(data) {
          var modal = $("#modal_view_task");
          modal.find('.modal-title').html(data.title);
          var status = {
            0: {
              'class': 'badge-light-success',
              'text': 'Ouvert'
            },
            1: {
              'class': 'badge-light-danger',
              'text': 'Fermer'
            }
          };
          modal.find('.task-state').html("<span class=\"badge ".concat(status[data.state]["class"], "\">").concat(status[data.state].text, "</span>"));
          modal.find('.modal-body').html(data.description);
          modal.modal('show');
        },
        error: function error(err) {
          toastr.error("Erreur System", err);
        }
      });
    });
  });
  table.querySelectorAll('[data-action="edit"]').forEach(function (action) {
    action.addEventListener('click', function (e) {
      e.preventDefault();
      $.ajax({
        url: action.getAttribute('href'),
        success: function success(data) {
          var modal = $("#edit_task_modal");
          modal.find('.modal-title').html(data.title);
          modal.find('[name="title"]').val(data.title);
          modal.find('[name="description"]').html(data.description);
          modal.find('[name="project_id"]').val(data.project_id);
          modal.find('[name="task_id"]').val(data.id);
          modal.modal('show');
          modal.find('#form-edit-task').on('submit', function (ex) {
            ex.preventDefault();
            var form = modal.find("#form-edit-task");
            var url = "/api/project/".concat(modal.find('[name="project_id"]').val(), "/task/").concat(modal.find('[name="task_id"]').val());
            var data = form.serializeArray();
            var btn = document.querySelector('#btnFormEditTask');
            btn.setAttribute('data-kt-indicator', 'on');
            $.ajax({
              url: url,
              method: 'PUT',
              data: data,
              success: function success() {
                modal.modal('hide');
                toastr.success("Edition d'une tache", "La tache à été éditer avec succès");
              },
              error: function error(err) {
                toastr.error("Erreur Systeme", err);
              }
            });
          });
        },
        error: function error(err) {
          toastr.error("Erreur System", err);
        }
      });
    });
  });
  table.querySelectorAll('[data-action="delete"]').forEach(function (action) {
    action.addEventListener('click', function (e) {
      e.preventDefault();
      $.ajax({
        url: action.getAttribute('href'),
        method: 'DELETE',
        success: function success() {
          action.parentNode.parentNode.parentNode.parentNode.style.display = 'none';
          toastr.success("La tache à été supprimer avec succès");
        },
        error: function error(err) {
          toastr.error("Erreur System", err);
        }
      });
    });
  });
  table.querySelectorAll('[data-action="closeTask"]').forEach(function (action) {
    action.addEventListener('click', function (e) {
      e.preventDefault();
      $.ajax({
        url: action.getAttribute('href'),
        method: 'PUT',
        success: function success() {
          action.classList.remove('text-danger');
          action.classList.add('text-success');
          action.setAttribute('href', "/api/project/".concat(action.dataset.projectId, "/task/").concat(action.dataset.taskId, "/open"));
          action.innerHTML = 'Ouvrir la tache';
          action.parentNode.parentNode.parentNode.parentNode.querySelector('#state_task').innerHtml = '<div class="badge badge-light-danger">Fermer</div>';
        },
        error: function error(err) {
          toastr.error("Erreur System", err);
        }
      });
    });
  });
  table.querySelectorAll('[data-action="openTask"]').forEach(function (action) {
    action.addEventListener('click', function (e) {
      e.preventDefault();
      $.ajax({
        url: action.getAttribute('href'),
        method: 'PUT',
        success: function success() {
          action.classList.remove('text-success');
          action.classList.add('text-danger');
          action.setAttribute('href', "/api/project/".concat(action.dataset.projectId, "/task/").concat(action.dataset.taskId, "/close"));
          action.innerHTML = 'Fermer la tache';
          action.parentNode.parentNode.parentNode.parentNode.querySelector('#state_task').innerHtml = '<div class="badge badge-light-success">Ouvert</div>';
        },
        error: function error(err) {
          toastr.error("Erreur System", err);
        }
      });
    });
  });
  $(".editor").summernote({
    height: 200
  });
});
/******/ })()
;