let count_project = document.querySelector('#count_project')
let graph = document.querySelector('#kt_project_list_chart')

let progress = document.querySelector('#project_progress')
let finish = document.querySelector('#project_finish')
let trash = document.querySelector('#project_trash')
let waiting = document.querySelector('#project_waiting')

let showProject = document.querySelector('#showProject')
let select = document.querySelector('#selectStatus')

function graphique() {
    if (graph) {
        let e = graph.getContext("2d")
        new Chart(e, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        progress.dataset.count,
                        finish.dataset.count,
                        trash.dataset.count,
                        waiting.dataset.count,
                    ],
                    backgroundColor: [
                        "#ff6600",
                        "#59ff00",
                        "#ff0033",
                        "#6a00ff",
                    ]
                }],
                labels: ["En cours", "Terminer", "Annuler", "En attente"]
            },
            options: {
                chart: {
                    fontFamily: 'inherit'
                },
                cutoutPercentage: 65,
                responsive: !0,
                maintainAspectRatio: !1,
                legend: {
                    display: !1
                },
                title: {
                    display: !1
                },
                animation: {
                    animateScale: !0,
                    animateRotate: !0
                },
                tooltips: {
                    enabled: !0,
                    intersect: !1,
                    mode: "nearest",
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10,
                    caretPadding: 0,
                    displayColors: !1,
                    backgroundColor: "#20D489",
                    titleFontColor: "#ffffff",
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                }
            }
        })
    }
}

graphique()
