'use strict';
$(document).ready(function() {
    setTimeout(function() {
        floatchart()
    }, 700);
    // [ campaign-scroll ] start
    var px = new PerfectScrollbar('.feed-scroll', {
        wheelSpeed: .5,
        swipeEasing: 0,
        wheelPropagation: 1,
        minScrollbarLength: 40,
    });
    var px = new PerfectScrollbar('.pro-scroll', {
        wheelSpeed: .5,
        swipeEasing: 0,
        wheelPropagation: 1,
        minScrollbarLength: 40,
    });
    // [ campaign-scroll ] end
});

function floatchart() {
    // [ support-chart ] start
    $(function() {
        var options1 = {
            chart: {
                type: 'area',
                height: 85,
                sparkline: {
                    enabled: true
                }
            },
            colors: ["#7267EF"],
            stroke: {
                curve: 'smooth',
                width: 2,
            },
            series: [{
                data: [0, 20, 10, 45, 30, 55, 20, 30, 0]
            }],
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Ticket '
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        }
        new ApexCharts(document.querySelector("#support-chart"), options1).render();
        var options2 = {
            chart: {
                type: 'bar',
                height: 85,
                sparkline: {
                    enabled: true
                }
            },
            colors: ["#7267EF"],
            plotOptions: {
                bar: {
                    columnWidth: '70%'
                }
            },
            series: [{
                data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54, 44, 12, 36, 9, 54, 25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 25, 44, 12, 36, 9, 54]
            }],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        }
        new ApexCharts(document.querySelector("#support-chart1"), options2).render();
    });
    // [ support-chart ] end
    // [ account-chart ] start
    $(function() {
        $(function() {
            var options = {
                chart: {
                    height: 350,
                    type: 'line',
                    stacked: false,
                },
                stroke: {
                    width: [0, 3],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                colors: ['#7267EF', '#c7d9ff'],
                series: [{
                    name: 'Payrol',
                    type: 'column',
                    data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
                }],
                fill: {
                    opacity: [0.85, 1],
                },
                labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003', '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'],
                markers: {
                    size: 0
                },
                xaxis: {
                    type: 'datetime'
                },
                yaxis: {
                    min: 0
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(y) {
                            if (typeof y !== "undefined") {
                                return "$ " +y.toFixed(0);
                            }
                            return y;

                        }
                    }
                },
                legend: {
                    labels: {
                        useSeriesColors: true
                    },
                    markers: {
                        customHTML: [
                            function() {
                                return ''
                            },
                            function() {
                                return ''
                            }
                        ]
                    }
                }
            }
            var chart = new ApexCharts(
                document.querySelector("#account-chart"),
                options
            );
            chart.render();
        });
    });
    // [ account-chart ] end
    // [ satisfaction-chart ] start
    $(function() {
        var options = {
            chart: {
                height: 260,
                type: 'pie',
            },
            series: [66, 50, 40, 30],
            labels: ["extremely Satisfied", "Satisfied", "Poor", "Very Poor"],
            legend: {
                show: true,
                offsetY: 50,
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: '#7267EF',
                }
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: {
                        height: 320,

                    },
                    legend: {
                        position: 'bottom',
                        offsetY: 0,
                    }
                }
            }]
        }
        var chart = new ApexCharts(document.querySelector("#satisfaction-chart"), options);
        chart.render();
    });
    // [ satisfaction-chart ] end
	// [ satisfaction-chart ] start
    $(function() {
        var options = {
            chart: {
                height: 260,
                type: 'donut',
            },
            series: [66, 50, 40, 30, 20,50,20,10,75,63],
            labels: ["extremely Satisfied", "Satisfied", "Poor", "Very Poor",'Test1','Test2','Test3','Test4','Test5','Test6'],
            legend: {
                show: true,
                offsetY: 50,
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: '#46be8a',
                }
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: {
                        height: 320,

                    },
                    legend: {
                        position: 'bottom',
                        offsetY: 0,
                    }
                }
            }]
        }
        var chart = new ApexCharts(document.querySelector("#satisfaction-chart2"), options);
        chart.render();
    });
    // [ satisfaction-chart ] end
	// [ satisfaction-chart ] start
    $(function() {
        var options = {
            chart: {
                height: 260,
                type: 'pie',
            },
            series: [66, 50, 40, 75,81 ],
            labels: ["Bronze Plan", "Gold Plan", "Pro Plan","Silver Plan","Free Plan"],
            legend: {
                show: true,
                offsetY: 50,
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: '#ffa21d',
                }
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: {
                        height: 320,

                    },
                    legend: {
                        position: 'bottom',
                        offsetY: 0,
                    }
                }
            }]
        }
        var chart = new ApexCharts(document.querySelector("#satisfaction-chart3"), options);
        chart.render();
    });
    // [ satisfaction-chart ] end
	// [ satisfaction-chart ] start
    $(function() {
        var options = {
            chart: {
                height: 260,
                type: 'pie',
            },
            series: [66, 15,63],
            labels: ["extremely Satisfied", 'Test5','Test6'],
            legend: {
                show: true,
                offsetY: 50,
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: '#46be8a',
                }
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: {
                        height: 320,

                    },
                    legend: {
                        position: 'bottom',
                        offsetY: 0,
                    }
                }
            }]
        }
        var chart = new ApexCharts(document.querySelector("#satisfaction-chart4"), options);
        chart.render();
    });
    // [ satisfaction-chart ] end
	// [ type-chart ] start
    $(function() {
        var options = {
            chart: {
                height: 200,
                type: 'donut',
            },
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%'
                    }
                }
            },
            labels: ['Desktop Computers', 'Smartphones', 'Tablets'],
            series: [76.7, 15, 30],
            legend: {
                show: false
            },
            colors: ["#EA4D4D", "#ffa21d", "#3ec9d6"],
        }
        var chart = new ApexCharts(document.querySelector("#type-chart"), options);
        chart.render();
    });
    // [ type-chart ] end
	// [ type-chart ] start
    $(function() {
        var options = {
            chart: {
                height: 200,
                type: 'donut',
            },
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%'
                    }
                }
            },
            labels: ['Desktop Computers', 'Smartphones', 'Tablets'],
            series: [76.7, 15, 30],
            legend: {
                show: false
            },
            colors: ["#EA4D4D", "#ffa21d", "#3ec9d6"],
        }
        var chart = new ApexCharts(document.querySelector("#type-chart2"), options);
        chart.render();
    });
    // [ type-chart ] end
	// [ Support tracker ] start
    $(function() {
        var options = {
            chart: {
                height: 135,
                type: 'donut',
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [66.6, 29.7, 38.6],
            labels: ['Desktop', 'Mobile', 'Tablet'],
            grid: {
                padding: {
                    top: 20,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            },
            legend: {
                show: false
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#device-chart"),
            options
        );
        chart.render()
    });
    // [ Support tracker ] end
}
