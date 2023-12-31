var options = {
    chart: {
        height: 320,
        type: "radialBar"
    },
    plotOptions: {
        radialBar: {
            hollow: {
                size: "70%"
            }
        }
    },
    colors: ["#39afd1"],
    series: [70],
    labels: ["CRICKET"]
};
(chart = new ApexCharts(document.querySelector("#basic-radialbar"), options)).render();
options = {
    chart: {
        height: 320,
        type: "radialBar"
    },
    plotOptions: {
        circle: {
            dataLabels: {
                showOn: "hover"
            }
        }
    },
    colors: ["#6c757d", "#ffbc00", "#727cf5", "#0acf97"],
    series: [44, 55, 67, 83],
    labels: ["Apples", "Oranges", "Bananas", "Berries"],
    responsive: [{
        breakpoint: 380,
        options: {
            chart: {
                height: 260
            }
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#multiple-radialbar"), options)).render();
options = {
    chart: {
        height: 380,
        width: 380,
        type: "radialBar"
    },
    plotOptions: {
        radialBar: {
            offsetY: -30,
            startAngle: 0,
            endAngle: 270,
            hollow: {
                margin: 5,
                size: "30%",
                background: "transparent",
                image: void 0
            },
            dataLabels: {
                name: {
                    show: !1
                },
                value: {
                    show: !1
                }
            }
        }
    },
    colors: ["#0acf97", "#727cf5", "#fa5c7c", "#ffbc00"],
    series: [50, 30, 40, 35, 22],
    labels: ["Auto", "CRNO", "CRGO", "Purlins-Solar", "Purlins-Construction"],
    legend: {
        show: !0,
        floating: !0,
        fontSize: "12px",
        position: "left",
        verticalAlign: "top",
        textAnchor: "end",
        labels: {
            useSeriesColors: !0
        },
        markers: {
            size: 0
        },
        formatter: function(e, a) {
            return e + ":  " + a.globals.series[a.seriesIndex]
        },
        itemMargin: {
            vertical: 0
        },
        containerMargin: {
            left: 180,
            top: 8
        }
    },
    responsive: [{
        breakpoint: 380,
        options: {
            chart: {
                height: 240,
                width: 240
            },
            legend: {
                show: !1
            }
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#circle-angle-radial"), options)).render();
options = {
    chart: {
        height: 380,
        type: "radialBar"
    },
    fill: {
        type: "image",
        image: {
            src: ["assets/images/small/small-2.jpg"]
        }
    },
    plotOptions: {
        radialBar: {
            hollow: {
                size: "70%"
            }
        }
    },
    series: [70],
    stroke: {
        lineCap: "round"
    },
    labels: ["Volatility"],
    responsive: [{
        breakpoint: 380,
        options: {
            chart: {
                height: 280
            }
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#image-radial"), options)).render();
var chart;
options = {
    chart: {
        height: 380,
        type: "radialBar"
    },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            dataLabels: {
                name: {
                    fontSize: "16px",
                    color: void 0,
                    offsetY: 120
                },
                value: {
                    offsetY: 76,
                    fontSize: "22px",
                    color: void 0,
                    formatter: function(e) {
                        return e + "%"
                    }
                }
            }
        }
    },
    fill: {
        gradient: {
            enabled: !0,
            shade: "dark",
            shadeIntensity: .15,
            inverseColors: !1,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 65, 91]
        }
    },
    stroke: {
        dashArray: 4
    },
    colors: ["#727cf5"],
    series: [67],
    labels: ["Median Ratio"],
    responsive: [{
        breakpoint: 380,
        options: {
            chart: {
                height: 280
            }
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#stroked-guage-radial"), options)).render();