let kt_modal_users_search_handler = document.querySelector('#kt_modal_users_search_handler')
let wrapper = kt_modal_users_search_handler.querySelector('[data-kt-search-element="wrapper"]')
let suggestion = kt_modal_users_search_handler.querySelector('[data-kt-search-element="suggestions"]')
let results = kt_modal_users_search_handler.querySelector('[data-kt-search-element="results"]')
let empty = kt_modal_users_search_handler.querySelector('[data-kt-search-element="empty"]')
let search;

let datatable = $("#table_project_task")
let table = document.querySelector('#table_project_task')
let r;

function searchUserList() {
    let searching = function(e) {
        console.log(e)
        kt_modal_users_search_handler.addEventListener('keyup', (e) => {
            e.preventDefault()
            $.ajax({
                url: '/api/user/searching',
                method: 'POST',
                data: {
                    "search": kt_modal_users_search_handler.querySelector('[data-kt-search-element="input"]').value,
                    "project_id": project_overview_chart.dataset.projectId,
                    "user_id": document.querySelector('#kt_body').dataset.userId
                },
                success: (data) => {
                    suggestion.classList.add('d-none')
                    $('[data-kt-search-element="results"]').removeClass('d-none')
                    $('[data-kt-search-element="results"]').html(data.content)
                    console.log(data)
                },
                error: (err) => {
                    console.error(err)
                }
            })
        })
    };

    let clearSearch = function(e) {
        suggestion.classList.remove('d-none');
        results.classList.add('d-none');
        empty.classList.add('d-none')
    };

    (search = new KTSearch(kt_modal_users_search_handler))
        .on("kt.search.process", searching);
    search.on("kt.search.clear", clearSearch)
}

searchUserList()

jQuery(document).ready(function () {

    let r = datatable.DataTable({
        info: !1,
        order: [],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json'
        }
    })

    table.querySelectorAll('[data-action="view"]').forEach(action => {
        action.addEventListener('click', (e) => {
            e.preventDefault()

            $.ajax({
                url: action.getAttribute('href'),
                success: (data) => {
                    let modal = $("#modal_view_task")
                    modal.find('.modal-title').html(data.title)

                    let status = {
                        0: {'class': 'badge-light-success', 'text': 'Ouvert'},
                        1: {'class': 'badge-light-danger', 'text': 'Fermer'},
                    }

                    modal.find('.task-state').html(`<span class="badge ${status[data.state].class}">${status[data.state].text}</span>`)

                    modal.find('.modal-body').html(data.description)

                    modal.modal('show')
                },
                error: (err) => {
                    toastr.error("Erreur System", err)
                }
            })
        })
    })
    table.querySelectorAll('[data-action="edit"]').forEach(action => {
        action.addEventListener('click', (e) => {
            e.preventDefault()

            $.ajax({
                url: action.getAttribute('href'),
                success: (data) => {
                    let modal = $("#edit_task_modal")
                    modal.find('.modal-title').html(data.title)
                    modal.find('[name="title"]').val(data.title)
                    modal.find('[name="description"]').html(data.description)
                    modal.find('[name="project_id"]').val(data.project_id)
                    modal.find('[name="task_id"]').val(data.id)
                    modal.modal('show')

                    modal.find('#form-edit-task').on('submit', (ex) => {
                        ex.preventDefault()
                        let form = modal.find("#form-edit-task")
                        let url = `/api/project/${modal.find('[name="project_id"]').val()}/task/${modal.find('[name="task_id"]').val()}`
                        let data = form.serializeArray()
                        let btn = document.querySelector('#btnFormEditTask')

                        btn.setAttribute('data-kt-indicator', 'on')

                        $.ajax({
                            url: url,
                            method: 'PUT',
                            data: data,
                            success: () => {
                                modal.modal('hide')
                                toastr.success("Edition d'une tache", "La tache à été éditer avec succès")
                            },
                            error: (err) => {
                                toastr.error("Erreur Systeme", err)
                            }
                        })
                    })
                },
                error: (err) => {
                    toastr.error("Erreur System", err)
                }
            })
        })
    })
    table.querySelectorAll('[data-action="delete"]').forEach(action => {
        action.addEventListener('click', (e) => {
            e.preventDefault()

            $.ajax({
                url: action.getAttribute('href'),
                method: 'DELETE',
                success: () => {
                    action.parentNode.parentNode.parentNode.parentNode.style.display = 'none'
                    toastr.success("La tache à été supprimer avec succès");
                },
                error: (err) => {
                    toastr.error("Erreur System", err)
                }
            })
        })
    })
    table.querySelectorAll('[data-action="closeTask"]').forEach(action => {
        action.addEventListener('click', (e) => {
            e.preventDefault()

            $.ajax({
                url: action.getAttribute('href'),
                method: 'PUT',
                success: () => {
                    action.classList.remove('text-danger')
                    action.classList.add('text-success')
                    action.setAttribute('href', `/api/project/${action.dataset.projectId}/task/${action.dataset.taskId}/open`)
                    action.innerHTML = 'Ouvrir la tache'
                    action.parentNode.parentNode.parentNode.parentNode.querySelector('#state_task').innerHtml = '<div class="badge badge-light-danger">Fermer</div>'
                },
                error: (err) => {
                    toastr.error("Erreur System", err)
                }
            })
        })
    })
    table.querySelectorAll('[data-action="openTask"]').forEach(action => {
        action.addEventListener('click', (e) => {
            e.preventDefault()

            $.ajax({
                url: action.getAttribute('href'),
                method: 'PUT',
                success: () => {
                    action.classList.remove('text-success')
                    action.classList.add('text-danger')
                    action.setAttribute('href', `/api/project/${action.dataset.projectId}/task/${action.dataset.taskId}/close`)
                    action.innerHTML = 'Fermer la tache'
                    action.parentNode.parentNode.parentNode.parentNode.querySelector('#state_task').innerHtml = '<div class="badge badge-light-success">Ouvert</div>'
                },
                error: (err) => {
                    toastr.error("Erreur System", err)
                }
            })
        })
    })

    const t = document.querySelector('[data-kt-subscription-table-filter="form"]'),
        n = t.querySelector('[data-kt-subscription-table-filter="filter"]'),
        o = t.querySelector('[data-kt-subscription-table-filter="reset"]'),
        q = t.querySelectorAll("select");

    n.addEventListener('click', () => {
        console.log("N")
        let t = "";
        q.forEach((e, n) => {
            e.value && "" !== e.value && (0 !== n && (t += " "), t += e.value)
        }), r.search(t).draw()
    })

    o.addEventListener('click', () => {
        console.log("O")
        q.forEach((t, e) => {
            $(t).val(null).trigger("change")
        }), r.search("").draw()
    })

    $(".editor").summernote({
        height: 200
    })
});
