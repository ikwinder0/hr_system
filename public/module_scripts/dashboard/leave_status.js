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


    
    $(function() {
        $(function() {
			$.ajax({
			url: main_url+'payroll/payroll_chart',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(response) {
				var options = {
				  chart: {
					type: 'bar'
				  },
				  stroke: {
						width: [0, 3],
						curve: 'smooth'
					},
					plotOptions: {
						bar: {
							columnWidth: '20%'
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
					}],
					colors: ['#7267EF', '#c7d9ff'],
				  series: [{
					data: [{
					  x: 'Total Candidate Applied',
					  y: 500
					}, {
					  x: 'Total Candidate Screened',
					  y: 100
					}, {
					  x: 'Shortlisted',
					  y: 50
					}, {
					  x: 'Selected',
					  y: 40
					}, {
					  x: 'Visa Aprroved',
					  y: 35
					}, {
					  x: 'Ticket Issue',
					  y: 35
					}, {
					  x: 'Travelled',
					  y: 35
					}]
				  }]
				};
				var chart = new ApexCharts(document.querySelector("#erp-payroll-chart"), options);
				chart.render();
				},
					error: function(data) {
						console.log(data);
					}
				});				
        });
    });
    // [ payroll-chart ] end
	// [ staff-payroll-chart ] start
    $(function() {
        $(function() {
			$.ajax({
			url: main_url+'payroll/staff_payroll_chart',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(response) {
				var options = {
					chart: {
						height: 390,
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
						name: response.paid_inv_label,
						type: 'column',
						data: response.payroll_amount
					}],
					fill: {
						opacity: [0.85, 1],
					},
					labels: response.payslip_month,
					markers: {
						size: 0
					},
					xaxis: {
						type: 'month'
					},
					yaxis: {
						min: 0
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
				};
				var chart = new ApexCharts(document.querySelector("#staff-payroll-chart"), options);
				chart.render();
				},
					error: function(data) {
						console.log(data);
					}
				});				
        });
    });
    // [ staff-payroll-chart ] end
	// [ department-wise-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'department/department_wise_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {		
        var options = {
            chart: {
                height: 260,
                type: 'donut',
            },
            series: response.iseries,
            labels: response.ilabels,
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
				mode: 'light',
				palette: 'palette6',
                monochrome: {
                    enabled: false,
                    color: '#255aee',
					shadeTo: 'light',
					shadeIntensity: 0.65
                }
            },
			plotOptions: {
			  pie: {
				donut: {
				  labels: {
					show: true,
					total: {
					  label: response.total_label,
					  showAlways: true,
					  show: true
					}
				  }
				}
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
        var chart = new ApexCharts(document.querySelector("#department-wise-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ department-wise-chart ] end
	// [ designation-wise-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'designation/designation_wise_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {		
        var options = {
            chart: {
                height: 260,
                type: 'donut',
            },
            series: response.iseries,
            labels: response.ilabels,
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
				mode: 'light',
				palette: 'palette8',
                monochrome: {
                    enabled: false,
                    color: '#255aee',
					shadeTo: 'light',
					shadeIntensity: 0.65
                }
            },
			plotOptions: {
			  pie: {
				donut: {
				  labels: {
					show: true,
					total: {
					  label: response.total_label,
					  showAlways: true,
					  show: true
					}
				  }
				}
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
        var chart = new ApexCharts(document.querySelector("#designation-wise-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});




}
