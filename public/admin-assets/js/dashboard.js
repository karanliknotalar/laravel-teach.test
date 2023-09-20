$(document).ready(function (e) {
    $("#dash-daterange").daterangepicker({singleDatePicker: !0});

    const donutOpt = {
        chart: {height: 202, type: "donut"},
        legend: {show: !1},
        stroke: {colors: ["transparent"]},
        series: [44, 55, 41, 17],
        labels: ["Direct", "Affilliate", "Sponsored", "E-mail"],
        colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"],
        responsive: [{breakpoint: 480, options: {chart: {width: 200}, legend: {position: "bottom"}}}]
    };
    new ApexCharts(document.querySelector("#average-sales"), donutOpt).render();


    window.Apex = {
        chart: {parentHeightOffset: 0, toolbar: {show: !1}},
        grid: {padding: {left: 0, right: 0}},
    };

    const lineOpt = {
        chart: {height: 370, type: "line", dropShadow: {enabled: !0, opacity: .2, blur: 7, left: -7, top: 7}},
        dataLabels: {enabled: !1},
        stroke: {curve: "smooth", width: 4},
        series: [
            {name: "Bu Hafta", data: [10, 20, 15, 25, 20, 30, 20]},
            {name: "Geçen Hafta", data: [0, 15, 10, 30, 15, 35, 25]}
        ],
        colors: ["#727cf5", "#0acf97"],
        zoom: {enabled: !1},
        legend: {show: !1},
        xaxis: {
            type: "string",
            categories: ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],
            tooltip: {enabled: !1},
            axisBorder: {show: !1}
        },
        grid: {strokeDashArray: 7},
        yaxis: {
            labels: {
                formatter: function (e) {
                    return e + "k"
                }, offsetX: -15
            }
        }
    };
    new ApexCharts(document.querySelector("#revenue-chart"), lineOpt).render();
})
