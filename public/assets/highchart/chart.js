var colors_arr = ['#007bff', '#28a745', '#17a2b8', '#dc3545', '#f8f9fa', '#343a40', '#6610f2', '#17a2b8', '#20c997', '#fd7e14'];

function BarChart()
{
    Highcharts.chart('container', {
        colors: colors_arr,
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: 'Browser market shares. January, 2022'
        },
        subtitle: {
            align: 'left',
            text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total percent market share'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [
            {
                name: "Browsers",
                colorByPoint: true,
                data: [
                    {
                        name: "Chrome",
                        y: 63.06,
                        drilldown: "Chrome"
                    },
                    {
                        name: "Safari",
                        y: 19.84,
                        drilldown: "Safari"
                    },
                    {
                        name: "Firefox",
                        y: 4.18,
                        drilldown: "Firefox"
                    },
                    {
                        name: "Edge",
                        y: 4.12,
                        drilldown: "Edge"
                    },
                    {
                        name: "Opera",
                        y: 2.33,
                        drilldown: "Opera"
                    },
                    {
                        name: "Internet Explorer",
                        y: 0.45,
                        drilldown: "Internet Explorer"
                    },
                    {
                        name: "Other",
                        y: 1.582,
                        drilldown: null
                    }
                ]
            }
        ],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: 'right'
                }
            },
            series: [
                {
                    name: "Chrome",
                    id: "Chrome",
                    data: [
                        [
                            "v65.0",
                            0.1
                        ],
                        [
                            "v64.0",
                            1.3
                        ],
                        [
                            "v63.0",
                            53.02
                        ],
                        [
                            "v62.0",
                            1.4
                        ],
                        [
                            "v61.0",
                            0.88
                        ],
                        [
                            "v60.0",
                            0.56
                        ],
                        [
                            "v59.0",
                            0.45
                        ],
                        [
                            "v58.0",
                            0.49
                        ],
                        [
                            "v57.0",
                            0.32
                        ],
                        [
                            "v56.0",
                            0.29
                        ],
                        [
                            "v55.0",
                            0.79
                        ],
                        [
                            "v54.0",
                            0.18
                        ],
                        [
                            "v51.0",
                            0.13
                        ],
                        [
                            "v49.0",
                            2.16
                        ],
                        [
                            "v48.0",
                            0.13
                        ],
                        [
                            "v47.0",
                            0.11
                        ],
                        [
                            "v43.0",
                            0.17
                        ],
                        [
                            "v29.0",
                            0.26
                        ]
                    ]
                },
                {
                    name: "Firefox",
                    id: "Firefox",
                    data: [
                        [
                            "v58.0",
                            1.02
                        ],
                        [
                            "v57.0",
                            7.36
                        ],
                        [
                            "v56.0",
                            0.35
                        ],
                        [
                            "v55.0",
                            0.11
                        ],
                        [
                            "v54.0",
                            0.1
                        ],
                        [
                            "v52.0",
                            0.95
                        ],
                        [
                            "v51.0",
                            0.15
                        ],
                        [
                            "v50.0",
                            0.1
                        ],
                        [
                            "v48.0",
                            0.31
                        ],
                        [
                            "v47.0",
                            0.12
                        ]
                    ]
                },
                {
                    name: "Internet Explorer",
                    id: "Internet Explorer",
                    data: [
                        [
                            "v11.0",
                            6.2
                        ],
                        [
                            "v10.0",
                            0.29
                        ],
                        [
                            "v9.0",
                            0.27
                        ],
                        [
                            "v8.0",
                            0.47
                        ]
                    ]
                },
                {
                    name: "Safari",
                    id: "Safari",
                    data: [
                        [
                            "v11.0",
                            3.39
                        ],
                        [
                            "v10.1",
                            0.96
                        ],
                        [
                            "v10.0",
                            0.36
                        ],
                        [
                            "v9.1",
                            0.54
                        ],
                        [
                            "v9.0",
                            0.13
                        ],
                        [
                            "v5.1",
                            0.2
                        ]
                    ]
                },
                {
                    name: "Edge",
                    id: "Edge",
                    data: [
                        [
                            "v16",
                            2.6
                        ],
                        [
                            "v15",
                            0.92
                        ],
                        [
                            "v14",
                            0.4
                        ],
                        [
                            "v13",
                            0.1
                        ]
                    ]
                },
                {
                    name: "Opera",
                    id: "Opera",
                    data: [
                        [
                            "v50.0",
                            0.96
                        ],
                        [
                            "v49.0",
                            0.82
                        ],
                        [
                            "v12.1",
                            0.14
                        ]
                    ]
                }
            ]
        }
    });
}

function PieChart()
{
    Highcharts.chart('pie-chart', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Browser market shares. January, 2022'
        },
        subtitle: {
            text: 'Click the slices to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
        },

        accessibility: {
            announceNewData: {
                enabled: true
            },
            point: {
                valueSuffix: '%'
            }
        },

        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [
            {
                name: "Browsers",
                colorByPoint: true,
                data: [
                    {
                        name: "Chrome",
                        y: 61.04,
                        drilldown: "Chrome"
                    },
                    {
                        name: "Safari",
                        y: 9.47,
                        drilldown: "Safari"
                    },
                    {
                        name: "Edge",
                        y: 9.32,
                        drilldown: "Edge"
                    },
                    {
                        name: "Firefox",
                        y: 8.15,
                        drilldown: "Firefox"
                    },
                    {
                        name: "Other",
                        y: 11.02,
                        drilldown: null
                    }
                ]
            }
        ],
        drilldown: {
            series: [
                {
                    name: "Chrome",
                    id: "Chrome",
                    data: [
                        [
                            "v97.0",
                            36.89
                        ],
                        [
                            "v96.0",
                            18.16
                        ],
                        [
                            "v95.0",
                            0.54
                        ],
                        [
                            "v94.0",
                            0.7
                        ],
                        [
                            "v93.0",
                            0.8
                        ],
                        [
                            "v92.0",
                            0.41
                        ],
                        [
                            "v91.0",
                            0.31
                        ],
                        [
                            "v90.0",
                            0.13
                        ],
                        [
                            "v89.0",
                            0.14
                        ],
                        [
                            "v88.0",
                            0.1
                        ],
                        [
                            "v87.0",
                            0.35
                        ],
                        [
                            "v86.0",
                            0.17
                        ],
                        [
                            "v85.0",
                            0.18
                        ],
                        [
                            "v84.0",
                            0.17
                        ],
                        [
                            "v83.0",
                            0.21
                        ],
                        [
                            "v81.0",
                            0.1
                        ],
                        [
                            "v80.0",
                            0.16
                        ],
                        [
                            "v79.0",
                            0.43
                        ],
                        [
                            "v78.0",
                            0.11
                        ],
                        [
                            "v76.0",
                            0.16
                        ],
                        [
                            "v75.0",
                            0.15
                        ],
                        [
                            "v72.0",
                            0.14
                        ],
                        [
                            "v70.0",
                            0.11
                        ],
                        [
                            "v69.0",
                            0.13
                        ],
                        [
                            "v56.0",
                            0.12
                        ],
                        [
                            "v49.0",
                            0.17
                        ]
                    ]
                },
                {
                    name: "Safari",
                    id: "Safari",
                    data: [
                        [
                            "v15.3",
                            0.1
                        ],
                        [
                            "v15.2",
                            2.01
                        ],
                        [
                            "v15.1",
                            2.29
                        ],
                        [
                            "v15.0",
                            0.49
                        ],
                        [
                            "v14.1",
                            2.48
                        ],
                        [
                            "v14.0",
                            0.64
                        ],
                        [
                            "v13.1",
                            1.17
                        ],
                        [
                            "v13.0",
                            0.13
                        ],
                        [
                            "v12.1",
                            0.16
                        ]
                    ]
                },
                {
                    name: "Edge",
                    id: "Edge",
                    data: [
                        [
                            "v97",
                            6.62
                        ],
                        [
                            "v96",
                            2.55
                        ],
                        [
                            "v95",
                            0.15
                        ]
                    ]
                },
                {
                    name: "Firefox",
                    id: "Firefox",
                    data: [
                        [
                            "v96.0",
                            4.17
                        ],
                        [
                            "v95.0",
                            3.33
                        ],
                        [
                            "v94.0",
                            0.11
                        ],
                        [
                            "v91.0",
                            0.23
                        ],
                        [
                            "v78.0",
                            0.16
                        ],
                        [
                            "v52.0",
                            0.15
                        ]
                    ]
                }
            ]
        }
    });
}

function LineChart()
{
    Highcharts.chart('line-chart', {

        title: {
            text: 'U.S Solar Employment Growth by Job Category, 2010-2020'
        },

        subtitle: {
            text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>'
        },

        yAxis: {
            title: {
                text: 'Number of Employees'
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2010 to 2020'
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 2010
            }
        },

        series: [{
            name: 'Installation & Developers',
            data: [43934, 48656, 65165, 81827, 112143, 142383,
                171533, 165174, 155157, 161454, 154610]
        }, {
            name: 'Manufacturing',
            data: [24916, 37941, 29742, 29851, 32490, 30282,
                38121, 36885, 33726, 34243, 31050]
        }, {
            name: 'Sales & Distribution',
            data: [11744, 30000, 16005, 19771, 20185, 24377,
                32147, 30912, 29243, 29213, 25663]
        }, {
            name: 'Operations & Maintenance',
            data: [null, null, null, null, null, null, null,
                null, 11164, 11218, 10077]
        }, {
            name: 'Other',
            data: [21908, 5548, 8105, 11248, 8989, 11816, 18274,
                17300, 13053, 11906, 10073]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
}
