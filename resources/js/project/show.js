let project_overview_chart = document.querySelector('#project_overview_chart')
let kt_project_overview_graph = document.querySelector('#kt_project_overview_graph')
let light_primary = KTUtil.getCssVariableValue("--bs-light-primary");
let light_success = KTUtil.getCssVariableValue("--bs-light-success");
let primary = KTUtil.getCssVariableValue("--bs-primary");
let success = KTUtil.getCssVariableValue("--bs-success");
let gray_200 = KTUtil.getCssVariableValue("--bs-gray-200");
let gray_500 = KTUtil.getCssVariableValue("--bs-gray-500");

let kt_modal_users_search_handler = document.querySelector('#kt_modal_users_search_handler')
let wrapper = kt_modal_users_search_handler.querySelector('[data-kt-search-element="wrapper"]')
let suggestion = kt_modal_users_search_handler.querySelector('[data-kt-search-element="suggestions"]')
let results = kt_modal_users_search_handler.querySelector('[data-kt-search-element="results"]')
let empty = kt_modal_users_search_handler.querySelector('[data-kt-search-element="empty"]')
let search;

function overviewCHart() {
    $.ajax({
        url: `/api/project/${project_overview_chart.dataset.projectId}/graphData`,
        success: (data) => {
            if(project_overview_chart) {
                let e = project_overview_chart.getContext("2d")
                new Chart(e, {
                    type: "doughnut",
                    data: {
                        datasets: [{
                            data: data.overview,
                            backgroundColor: ["#00ff2a", "#cd5050"]
                        }],
                        labels: ["Ouvert", "Fermer"]
                    },
                    options: {
                        chart: {
                            fontFamily: "inherit"
                        },
                        cutoutPercentage: 75,
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
            if(kt_project_overview_graph) {
                let i = parseInt(KTUtil.css(kt_project_overview_graph, "height"))
                new ApexCharts(kt_project_overview_graph, {
                    series: [{
                        name: "Ouvert",
                        data: data.metric.open
                    }, {
                        name: "Fermer",
                        data: data.metric.close
                    }],
                    chart: {
                        type: "area",
                        height: i,
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: !1
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    fill: {
                        type: "solid",
                        opacity: 1
                    },
                    stroke: {
                        curve: "smooth",
                        show: !0,
                        width: 3,
                        colors: [primary, success]
                    },
                    xaxis: {
                        categories: ["Janv", "Fev", "Mar", "Avr", "Juin", "Juil", "Aout", "Sept", "Oct", "Nov", "Dec"],
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            style: {
                                colors: gray_500,
                                fontSize: "12px"
                            }
                        },
                        crosshairs: {
                            position: "front",
                            stroke: {
                                color: primary,
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: !0,
                            formatter: void 0,
                            offsetY: 0,
                            style: {
                                fontSize: "12px"
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: gray_500,
                                fontSize: "12px"
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: !1,
                            filter: {
                                type: "none",
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: "12px"
                        },
                        y: {
                            formatter: function(t) {
                                return t + " Tâches"
                            }
                        }
                    },
                    colors: [light_primary, light_success],
                    grid: {
                        borderColor: gray_200,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: !0
                            }
                        }
                    },
                    markers: {
                        colors: [light_primary, light_success],
                        strokeColor: [primary, success],
                        strokeWidth: 3
                    }
                }).render()
            }
        }
    })
}

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

overviewCHart()
searchUserList()

jQuery(document).ready(function () {
    $(".editor").summernote({
        height: 200
    })
});
