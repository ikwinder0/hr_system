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
    // [ leave-type-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'leave/leave_type_chart',
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
				palette: 'palette4',
                monochrome: {
                    enabled: true,
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
		//alert(response.iseries);
        var chart = new ApexCharts(document.querySelector("#leave-type-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ leave-type-chart ] end
	// [ membership-type-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'membership/membership_type_chart',
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
				palette: 'palette4',
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
        var chart = new ApexCharts(document.querySelector("#membership-type-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ membership-type-chart ] end
	// [ leave-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'leave/leave_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {	
		//var status_colors = ['rgba(0, 227, 150, 0.85)', 'rgba(254, 176, 25, 0.85)', 'rgba(255, 69, 96, 0.85)'];	
        var options = {
            chart: {
                height: 260,
                type: 'donut',
            },
            series: [response.accepted_count,response.pending_count,response.rejected_count],
            labels: [response.accepted,response.pending,response.rejected],
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
           //	colors: status_colors,
		   theme: {
				mode: 'light',
				palette: 'palette4',
                monochrome: {
                    enabled: true,
                    color: '#64d999',
					shadeTo: 'light',
					shadeIntensity: 0.65
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
		//alert(response.iseries);
        var chart = new ApexCharts(document.querySelector("#leave-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ leave-status-chart ] end
	// [ invoice-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'invoices/invoice_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {	
		//var status_colors = ['rgba(0, 227, 150, 0.85)', 'rgba(254, 176, 25, 0.85)', 'rgba(255, 69, 96, 0.85)'];	
        var options = {
            chart: {
                height: 130,
                type: 'pie',
            },
            series: [response.paid_count,response.unpaid_count],
            labels: [response.paid,response.unpaid],
            legend: {
                show: true,
                offsetY: 10,
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
           //	colors: status_colors,
		   theme: {
				mode: 'light',
				palette: 'palette4',
                monochrome: {
                    enabled: true,
                    color: '#64d999',
					shadeTo: 'light',
					shadeIntensity: 0.65
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
		//alert(response.iseries);
        var chart = new ApexCharts(document.querySelector("#invoice-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ invoice-status-chart ] end
	// [ paid-invoice-chart ] start
    $(function() {
        $(function() {
			$.ajax({
			url: main_url+'invoices/invoice_amount_chart',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(response) {
				var options = {
				  series: [{
				  name: response.unpaid_inv_label,
				  type: 'column',
				  data: response.unpaid_invoice
				}, {
				  name: response.paid_inv_label,
				  type: 'line',
				  data: response.paid_invoice
				}],
				  chart: {
				  height: 365,
				  type: 'line',
				},
				stroke: {
				  width: [0, 4]
				},
				/*title: {
				  text: response.unpaid_inv_label
				},*/
				dataLabels: {
				  enabled: true,
				  enabledOnSeries: [1]
				},
				labels: response.invoice_month,
				xaxis: {
				  type: 'month'
				},
				yaxis: [{
				  title: {
					text: response.paid_inv_label,
				  },
				
				}, {
				  opposite: true,
				  title: {
					text: response.unpaid_inv_label,
				  }
				}]
				};
				var chart = new ApexCharts(document.querySelector("#paid-invoice-chart"), options);
				chart.render();
				},
					error: function(data) {
						console.log(data);
					}
				});				
        });
    });
    // [ paid-invoice-chart ] end
	// [ company-invoice-chart ] start
    $(function() {
        $(function() {
			$.ajax({
			url: main_url+'membershipinvoices/membership_invoice_amount_chart',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(response) {
			var options = {
			  series: [{
			  name: response.total_payment,
			  type: 'area',
			  data: response.paid_invoice,
			}],
			  chart: {
			  height: 312,
			  type: 'line',
			},
			stroke: {
			  curve: 'smooth'
			},
			fill: {
			  type:'solid',
			  opacity: [0.35, 1],
			},
			labels: response.invoice_month,
			markers: {
			  size: 0
			},
			
			tooltip: {
			  shared: true,
			  intersect: false,
			  y: {
				formatter: function (y) {
				  if(typeof y !== "undefined") {
					return  y.toFixed(0);
				  }
				  return y;
				}
			  }
			}
			};
			var chart = new ApexCharts(document.querySelector("#company-invoice-chart"), options);
			chart.render();
			},
				error: function(data) {
					console.log(data);
				}
			});				
        });
    });
    // [ company-invoice-chart ] end
	// [ membership-by-country-chart ] start
    $(function() {
        $(function() {
			$.ajax({
			url: main_url+'membership/membership_by_country_chart',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(response) {
			var options = {
			  series: [{
			  data: response.iseries,
			}],
			  chart: {
			  type: 'bar',
			  height: 400
			},
			plotOptions: {
			  bar: {
				barHeight: '100%',
				distributed: true,
				horizontal: true,
				dataLabels: {
				  position: 'bottom'
				},
			  }
			},
			colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
			  '#f48024', '#69d2e7'
			],
			dataLabels: {
			  enabled: true,
			  textAnchor: 'start',
			  style: {
				colors: ['#fff']
			  },
			  formatter: function (val, opt) {
				return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
			  },
			  offsetX: 0,
			  dropShadow: {
				enabled: true
			  }
			},
			stroke: {
			  width: 1,
			  colors: ['#fff']
			},
			xaxis: {
			  categories: response.ilabels,
			},
			yaxis: {
			  labels: {
				show: false
			  }
			},
			
			tooltip: {
			  theme: 'dark',
			  x: {
				show: false
			  },
			  y: {
				title: {
				  formatter: function () {
					return ''
				  }
				}
			  }
			}
			};
			var chart = new ApexCharts(document.querySelector("#membership-by-country-chart"), options);
			chart.render();
			},
				error: function(data) {
					console.log(data);
				}
			});				
        });
    });
    // [ membership-by-country-chart ] end
	// [ ticket-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'tickets/tickets_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {	
		var status_colors = ['rgba(0, 227, 150, 0.85)', 'rgba(254, 176, 25, 0.85)'];	
        var options = {
            chart: {
                width: '100%',
                type: 'donut',
            },
            series: [response.open_count,response.closed],
            labels: [response.open_label,response.closed_label],
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
			fill: {
			  type: 'gradient',
			},
           	theme: {
				mode: 'light', 
				palette: 'palette1',
			  monochrome: {
				enabled: false
			  }
			},
			//colors: status_colors,
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
		//alert(response.iseries);
        var chart = new ApexCharts(document.querySelector("#ticket-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ ticket-status-chart ] end
	// [ ticket-priority-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'tickets/tickets_priority_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			///start
			var options = {
			  series: [response.low_count,response.medium_count,response.high_count,response.critical_count],
			  chart: {
				  width: '100%',
				  type: 'pie',
				},
			labels: [response.low_labt,response.medium_lab,response.high_lab,response.critical_lab],
			theme: {
			  monochrome: {
				enabled: true,
				color: '#ffa21d',
			  }
			},
			plotOptions: {
			  pie: {
				dataLabels: {
				  offset: -5
				}
			  }
			},
			dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
			legend: {
                show: true,
                offsetY: 50,
            },
			};
	
			var chart = new ApexCharts(document.querySelector("#ticket-priority-chart"), options);
			chart.render();
			/// end
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ ticket-priority-chart ] end
	// [ jobs-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'recruitment/jobs_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {	
		var status_colors = ['rgba(0, 227, 150, 0.85)', 'rgba(254, 176, 25, 0.85)'];	
        var options = {
            chart: {
                height: 150,
                type: 'donut',
            },
            series: [response.closed,response.open_count],
            labels: [response.closed_label,response.open_label],
            legend: {
                show: true,
                offsetY: 10,
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
			fill: {
			  type: 'gradient',
			},
			plotOptions: {
			  pie: {
				donut: {
				  labels: {
					show: true,
					total: {
					  showAlways: true,
					  show: true
					}
				  }
				}
			  }
			},
           	theme: {
				mode: 'light',
				palette: 'palette4',
                monochrome: {
                    enabled: true,
                    color: '#7267EF',
					shadeTo: 'light',
					shadeIntensity: 0.65
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
        var chart = new ApexCharts(document.querySelector("#jobs-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	});
    // [ jobs-status-chart ] end
	// [ jobs-type-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'recruitment/jobs_type_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
        var options = {
            chart: {
                 height: 150,
                type: 'donut',
            },
            series: [response.full_time,response.part_time,response.internship,response.freelance],
            labels: [response.full_time_lb,response.part_time_lb,response.internship_lb,response.freelance_lb,],
            legend: {
                show: true,
                offsetY: 10,
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
			fill: {
			  type: 'gradient',
			},
           	theme: {
				mode: 'light',
				palette: 'palette4',
                monochrome: {
                    enabled: true,
                    color: '#17C666',
					shadeTo: 'light',
					shadeIntensity: 0.65
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
        };
        var chart = new ApexCharts(document.querySelector("#jobs-type-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	});
    // [ jobs-type-chart ] end
	// [ job-by-designation-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'recruitment/job_by_designation_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {	
		var options = {
            chart: {
                 height: 150,
                type: 'donut',
            },
            series: response.iseries,
            labels: response.ilabels,
            legend: {
                show: true,
                offsetY: 10,
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
			fill: {
			  type: 'gradient',
			},
           	theme: {
				mode: 'light',
				palette: 'palette1',
                monochrome: {
                    enabled: false,
                  //  color: '#17C666',
					shadeTo: 'light',
					shadeIntensity: 0.65
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
        var chart = new ApexCharts(document.querySelector("#job-by-designation-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ job-by-designation-chart ] end
	// [ task-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'tasks/task_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
		var options = {
          series: [response.not_started,response.in_progress,response.completed,response.cancelled,response.hold],
          chart: {
          height: 275,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
              total: {
                show: true,
                label: 'Total',
                formatter: function (w) {
                  return response.total
                }
              }
            }
          }
        },
		
        labels: [response.not_started_lb,response.in_progress_lb,response.completed_lb,response.cancelled_lb,response.hold_lb]
        };
        var chart = new ApexCharts(document.querySelector("#task-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	});
    // [ task-status-chart ] end
	 // [ tasks-by-projects-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'tasks/tasks_by_projects_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {		
        var options = {
            chart: {
                height: 180,
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
				palette: 'palette4',
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
        var chart = new ApexCharts(document.querySelector("#tasks-by-projects-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ tasks-by-projects-chart ] end
	// [ project-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'projects/project_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
		var options = {
          series: [response.not_started,response.in_progress,response.completed,response.cancelled,response.hold],
          chart: {
          height: 275,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
              total: {
                show: true,
                label: response.total_label,
                formatter: function (w) {
                  return response.total
                }
              }
            }
          }
        },
		
        labels: [response.not_started_lb,response.in_progress_lb,response.completed_lb,response.cancelled_lb,response.hold_lb]
        };
		
        var chart = new ApexCharts(document.querySelector("#project-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	});
    // [ project-status-chart ] end
	// [ project-priority-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'projects/projects_priority_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			///start
			var options = {
			  series: [response.highest,response.high,response.normal,response.low],
			  chart: {
				  height: 260,
				  type: 'pie',
				},
			labels: [response.highest_lb,response.high_lb,response.normal_lb,response.low_lb],
			theme: {
			  monochrome: {
				enabled: true,
				color: '#33B2DF',
			  }
			},
			plotOptions: {
			  pie: {
				dataLabels: {
				  offset: -5
				}
			  }
			},
			dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
			legend: {
                show: true,
                offsetY: 50,
            },
			};
	
			var chart = new ApexCharts(document.querySelector("#project-priority-chart"), options);
			chart.render();
			/// end
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ project-priority-chart ] end
	// [ payroll-chart ] start
    $(function() {
        $(function() {
			$.ajax({
			url: main_url+'payroll/payroll_chart',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(response) {
				var options = {
					chart: {
						height: 365,
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
    // [ designation-wise-chart ] end
	// [ staff-attendance-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'timesheet/staff_working_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
        var options = {
            chart: {
                height: 110,
                type: 'bar',
                sparkline: {
                    enabled: true
                },
            },
            colors: ["#008FFB", "#EA4D4D","#0e9e4a"],
            plotOptions: {
                bar: {
                    columnWidth: '55%',
                    distributed: true
                }
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 0
            },
            series: [{
                name: 'Attendance',
                data: [response.total,response.absent,response.working]
            }],
            xaxis: {
                categories: [response.total_label, response.absent_label,response.working_label],
            }
        };
        var chart = new ApexCharts(
            document.querySelector("#staff-attendance-chart"),
            options
        );
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
    });
    // [ staff-attendance-chart ] end
	// [ task-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'tasks/staff_task_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
        var options = {
            chart: {
                height: 260,
                type: 'pie',
            },
            series: [response.not_started,response.in_progress,response.completed,response.cancelled,response.hold],
            labels: [response.not_started_lb,response.in_progress_lb,response.completed_lb,response.cancelled_lb,response.hold_lb],
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
        };
        var chart = new ApexCharts(document.querySelector("#staff-task-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	});
    // [ staff-task-status-chart ] end
	// [ client-task-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'tasks/client_task_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
        var options = {
            chart: {
                height: 235,
                type: 'pie',
            },
            series: [response.not_started,response.in_progress,response.completed,response.cancelled,response.hold],
            labels: [response.not_started_lb,response.in_progress_lb,response.completed_lb,response.cancelled_lb,response.hold_lb],
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
        };
        var chart = new ApexCharts(document.querySelector("#client-task-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	});
    // [ client-task-status-chart ] end
	// [ client-project-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'projects/client_project_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
		var options = {
            chart: {
                height: 264,
                type: 'donut',
            },
            series: [response.not_started,response.in_progress,response.completed,response.cancelled,response.hold],
            labels: [response.not_started_lb,response.in_progress_lb,response.completed_lb,response.cancelled_lb,response.hold_lb],
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
                    color: '#17C666',
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
        var chart = new ApexCharts(document.querySelector("#client-project-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	});
    // [ client-project-status-chart ] end
	// [ project-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'projects/staff_project_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
		var options = {
            chart: {
                height: 265,
                type: 'donut',
            },
            series: [response.not_started,response.in_progress,response.completed,response.cancelled,response.hold],
            labels: [response.not_started_lb,response.in_progress_lb,response.completed_lb,response.cancelled_lb,response.hold_lb],
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
                    color: '#17C666',
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
        var chart = new ApexCharts(document.querySelector("#staff-project-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	});
    // [ staff-project-status-chart ] end
	// [ staff-ticket-status-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'tickets/staff_tickets_status_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {	
		var status_colors = ['rgba(0, 227, 150, 0.85)', 'rgba(254, 176, 25, 0.85)'];	
        var options = {
            chart: {
                height: 150,
                type: 'donut',
            },
            series: [response.open_count,response.closed],
            labels: [response.open_label,response.closed_label],
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
			fill: {
			  type: 'gradient',
			},
           	theme: {
				mode: 'light', 
				palette: 'palette1',
			  monochrome: {
				enabled: false
			  }
			},
			//colors: status_colors,
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
		//alert(response.iseries);
        var chart = new ApexCharts(document.querySelector("#staff-ticket-status-chart"), options);
        chart.render();
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ staff-ticket-status-chart ] end
	// [ staff-ticket-priority-chart ] start
    $(function() {
		$.ajax({
		url: main_url+'tickets/staff_tickets_priority_chart',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			///start
			var options = {
			  series: [response.low_count,response.medium_count,response.high_count,response.critical_count],
			  chart: {
				  height: 170,
				  type: 'pie',
				},
			labels: [response.low_labt,response.medium_lab,response.high_lab,response.critical_lab],
			theme: {
			  monochrome: {
				enabled: true,
				color: '#ffa21d',
			  }
			},
			plotOptions: {
			  pie: {
				dataLabels: {
				  offset: -5
				}
			  }
			},
			dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false,
                }
            },
			legend: {
                show: true,
                offsetY: 50,
            },
			};
	
			var chart = new ApexCharts(document.querySelector("#staff-ticket-priority-chart"), options);
			chart.render();
			/// end
		},
		error: function(data) {
			console.log(data);
		}
    });
	
	});
    // [ staff-ticket-priority-chart ] end
	// [ client-paid-invoice-chart ] start
    $(function() {
        $(function() {
			$.ajax({
			url: main_url+'invoices/client_invoice_amount_chart',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(response) {
				var options = {
				  series: [{
				  name: response.unpaid_inv_label,
				  type: 'column',
				  data: response.unpaid_invoice
				}, {
				  name: response.paid_inv_label,
				  type: 'line',
				  data: response.paid_invoice
				}],
				  chart: {
				  height: 340,
				  type: 'line',
				},
				stroke: {
				  width: [0, 4]
				},
				dataLabels: {
				  enabled: true,
				  enabledOnSeries: [1]
				},
				labels: response.invoice_month,
				xaxis: {
				  type: 'month'
				},
				yaxis: [{
				  title: {
					text: response.paid_inv_label,
				  },
				
				}, {
				  opposite: true,
				  title: {
					text: response.unpaid_inv_label
				  }
				}]
				};
				var chart = new ApexCharts(document.querySelector("#client-paid-invoice-chart"), options);
				chart.render();
				},
					error: function(data) {
						console.log(data);
					}
				});				
        });
    });
    // [ client-paid-invoice-chart ] end
}
