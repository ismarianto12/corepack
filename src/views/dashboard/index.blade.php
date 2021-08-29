@extends('ismarianto::layouts.template')

@section('content')
    <section class="section">

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Order Statistics -
                            <div class="dropdown d-inline">
                                <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#"
                                    id="orders-month">August</a>
                                <ul class="dropdown-menu dropdown-menu-sm">
                                    <li class="dropdown-title">Select Month</li>
                                    <li><a href="#" class="dropdown-item">January</a></li>
                                    <li><a href="#" class="dropdown-item">February</a></li>
                                    <li><a href="#" class="dropdown-item">March</a></li>
                                    <li><a href="#" class="dropdown-item">April</a></li>
                                    <li><a href="#" class="dropdown-item">May</a></li>
                                    <li><a href="#" class="dropdown-item">June</a></li>
                                    <li><a href="#" class="dropdown-item">July</a></li>
                                    <li><a href="#" class="dropdown-item active">August</a></li>
                                    <li><a href="#" class="dropdown-item">September</a></li>
                                    <li><a href="#" class="dropdown-item">October</a></li>
                                    <li><a href="#" class="dropdown-item">November</a></li>
                                    <li><a href="#" class="dropdown-item">December</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">24</div>
                                <div class="card-stats-item-label">Pending</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">12</div>
                                <div class="card-stats-item-label">Shipping</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">23</div>
                                <div class="card-stats-item-label">Completed</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Orders</h4>
                        </div>
                        <div class="card-body">
                            59
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Balance</h4>
                        </div>
                        <div class="card-body">
                            $187,13
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sales</h4>
                        </div>
                        <div class="card-body">
                            4,732
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Statistics</h4>
                        <div class="card-header-action">
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary">Week</a>
                                <a href="#" class="btn">Month</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                        </figure>

                        <div class="statistic-details mt-sm-4">
                            <div class="statistic-details-item">
                                <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>
                                    7%</span>
                                <div class="detail-value">$243</div>
                                <div class="detail-name">Today's Sales</div>
                            </div>
                            <div class="statistic-details-item">
                                <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span>
                                    23%</span>
                                <div class="detail-value">$2,902</div>
                                <div class="detail-name">This Week's Sales</div>
                            </div>
                            <div class="statistic-details-item">
                                <span class="text-muted"><span class="text-primary"><i
                                            class="fas fa-caret-up"></i></span>9%</span>
                                <div class="detail-value">$12,821</div>
                                <div class="detail-name">This Month's Sales</div>
                            </div>
                            <div class="statistic-details-item">
                                <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>
                                    19%</span>
                                <div class="detail-value">$92,142</div>
                                <div class="detail-name">This Year's Sales</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <h3 class="section-title"><i class="fas fa-user-check"></i>Marketing Activities</h3>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border">
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50"
                                    src="https://demo.getstisla.com/assets/img/avatar/avatar-1.png" alt="avatar">
                                <div class="media-body">
                                    <div class="float-right text-primary">Now</div>
                                    <div class="media-title">Farhan A Mujib</div>
                                    <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla
                                        vel metus scelerisque ante sollicitudin.</span>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50"
                                    src="https://demo.getstisla.com/assets/img/avatar/avatar-1.png" alt="avatar">
                                <div class="media-body">
                                    <div class="float-right">12m</div>
                                    <div class="media-title">Ujang Maman</div>
                                    <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla
                                        vel metus scelerisque ante sollicitudin.</span>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50"
                                    src="https://demo.getstisla.com/assets/img/avatar/avatar-3.png" alt="avatar">
                                <div class="media-body">
                                    <div class="float-right">17m</div>
                                    <div class="media-title">Rizal Fakhri</div>
                                    <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla
                                        vel metus scelerisque ante sollicitudin.</span>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50"
                                    src="https://demo.getstisla.com/assets/img/avatar/avatar-4.png" alt="avatar">
                                <div class="media-body">
                                    <div class="float-right">21m</div>
                                    <div class="media-title">Alfa Zulkarnain</div>
                                    <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla
                                        vel metus scelerisque ante sollicitudin.</span>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center pt-1 pb-1">
                            <a href="#" class="btn btn-primary btn-lg btn-round">
                                View All
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script src="https://demo.getstisla.com/assets/modules/chart.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        var balance_chart = document.getElementById("balance-chart").getContext('2d');

        var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var myChart = new Chart(balance_chart, {
            type: 'line',
            data: {
                labels: ['16-07-2018', '17-07-2018', '18-07-2018', '19-07-2018', '20-07-2018', '21-07-2018',
                    '22-07-2018', '23-07-2018', '24-07-2018', '25-07-2018', '26-07-2018', '27-07-2018',
                    '28-07-2018', '29-07-2018', '30-07-2018', '31-07-2018'
                ],
                datasets: [{
                    label: 'Balance',
                    data: [50, 61, 80, 50, 72, 52, 60, 41, 30, 45, 70, 40, 93, 63, 50, 62],
                    backgroundColor: balance_chart_bg_color,
                    borderWidth: 3,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1
                    }
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }]
                },
            }
        });



        var sales_chart = document.getElementById("sales-chart").getContext('2d');
        var sales_chart_bg_color = sales_chart.createLinearGradient(0, 0, 0, 80);

        var myChart = new Chart(sales_chart, {
            type: 'line',
            data: {
                labels: ['16-07-2018', '17-07-2018', '18-07-2018', '19-07-2018', '20-07-2018', '21-07-2018',
                    '22-07-2018', '23-07-2018', '24-07-2018', '25-07-2018', '26-07-2018', '27-07-2018',
                    '28-07-2018', '29-07-2018', '30-07-2018', '31-07-2018'
                ],
                datasets: [{
                    label: 'Sales',
                    data: [70, 62, 44, 40, 21, 63, 82, 52, 50, 31, 70, 50, 91, 63, 51, 60],
                    borderWidth: 2,
                    backgroundColor: balance_chart_bg_color,
                    borderWidth: 3,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1
                    }
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }]
                },
            }
        });


        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Rekapitulasi Ismarianto'
            },
            subtitle: {
                text: 'Source: PDS'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Tokyo',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

            }, {
                name: 'New York',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

            }, {
                name: 'London',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

            }, {
                name: 'Berlin',
                data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

            }]
        });
    </script>
@endsection
