/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/project/show.js ***!
  \**************************************/
var project_overview_chart = document.querySelector('#project_overview_chart');
var kt_project_overview_graph = document.querySelector('#kt_project_overview_graph');
var light_primary = KTUtil.getCssVariableValue("--bs-light-primary");
var light_success = KTUtil.getCssVariableValue("--bs-light-success");
var primary = KTUtil.getCssVariableValue("--bs-primary");

var _success = KTUtil.getCssVariableValue("--bs-success");

var gray_200 = KTUtil.getCssVariableValue("--bs-gray-200");
var gray_500 = KTUtil.getCssVariableValue("--bs-gray-500");

function overviewCHart() {
  $.ajax({
    url: "/api/project/".concat(project_overview_chart.dataset.projectId, "/graphData"),
    success: function success(data) {
      if (project_overview_chart) {
        var e = project_overview_chart.getContext("2d");
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
        });
      }

      if (kt_project_overview_graph) {
        var i = parseInt(KTUtil.css(kt_project_overview_graph, "height"));
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
            colors: [primary, _success]
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
              formatter: function formatter(t) {
                return t + " Tâches";
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
            strokeColor: [primary, _success],
            strokeWidth: 3
          }
        }).render();
      }
    }
  });
}

overviewCHart();
/******/ })()
;