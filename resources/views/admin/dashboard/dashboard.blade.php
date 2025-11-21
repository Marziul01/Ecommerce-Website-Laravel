
@extends('admin.master')

@section('title')
    {{ $siteSettings->title }} | Admin Dashboard
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-4"> 
                <div class=" welcome-dash ">
                    <div>
                        <h5>Welcome Back</h5>
                        <img src="{{ asset('admin-assets/img/profile-img.png') }}" alt="" width="50%" >
                    </div>
                    <div>
                        <img class="img-profile rounded-circle" src="{{ asset('admin-assets') }}/img/undraw_profile.svg">
                        <p> {{ Auth::user()->name }} </p>
                        <p> {{ Auth::user()->email }} </p>
                        <a href="{{ route('profile') }}" class="btn btn-sm btn-primary">  View Profie </a>
                    </div>
                </div>
                <div class="mt-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                                       All Time Total Earnings</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Tk {{$alltotalearning}}</div>
                                </div>
                                <div class="col-auto dash-card-icon">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="mt-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                       Total Completed Orders </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$orders->where('status', 4)->count()}}</div>
                                </div>
                                <div class="col-auto dash-card-icon">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 h-100 row dash-rows-fix">
                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Earnings (This Month)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Tk {{$monthlyEarnings}}</div>
                                </div>
                                <div class="col-auto dash-card-icon ">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class=" col-md-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a" href="{{ route('product.index') }}">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Total Products</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products }}</div>
                                </div>
                                <div class="col-auto  dash-card-icon">
                                    <i class="fa-solid fa-cube"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a" href="{{ route('product.index') }}">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Inactive Products
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $inactiveproducts }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto  dash-card-icon">
                                    <i class="fa-solid fa-shop-lock"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a" href="{{ route('ordersPending') }}">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Pending Orders</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders->where('status' ,1 )->count() }}</div>
                                </div>
                                <div class="col-auto dash-card-icon">
                                    <i class="fa-solid fa-hourglass-half"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                

                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                                        Orders out for delivery </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$orders->where('status', 3)->count()}}</div>
                                </div>
                                <div class="col-auto dash-card-icon">
                                    <i class="fa-solid fa-truck-ramp-box"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class=" col-md-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a" href="{{ route('ordersCancel') }}">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                                        Canceled Orders</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders->where('status', 2)->count() }}</div>
                                </div>
                                <div class="col-auto dash-card-icon">
                                    <i class="fa-solid fa-ban"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a" href="{{ route('ordersPending') }}">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold  text-uppercase mb-1">Payment Pending Orders 
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $orders->where('payment_status', 1)->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto dash-card-icon">
                                    <i class="fa-solid fa-money-check-dollar"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100 py-2">
                        <a class="card-body dashboard-a" href="{{ route('users.index') }}">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Users
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $users }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto dash-card-icon">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Earnings (Monthly) Card Example -->
            

            <!-- Earnings (Monthly) Card Example -->
            

            <!-- Pending Requests Card Example -->
            
        </div>

        <!-- Content Row -->

        {{-- <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChartio"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChartio"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@endsection

@section('customjs')

    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Area Chart Example
        var ctx = document.getElementById("myAreaChartio");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: {!! json_encode($monthlyEarningsData) !!}, // Pass the monthly earnings data here
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '$' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + ' Tk';
                        }
                    }
                }
            }
        });

        // Function to format numbers with commas
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    </script>

    <script>
        // Assuming you have received categoryNames and orderCounts from your backend

        // Pie Chart Example
        var ctx = document.getElementById("myPieChartio");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($subCategoryNames) !!}, // Category names array passed from backend
                datasets: [{
                    data: {!! json_encode($orderCounts) !!}, // Order counts array passed from backend
                    backgroundColor: getRandomColors({!! count($subCategoryNames) !!}), // Get random colors for each category
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index];
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return label + ': ' + value.toFixed(2) + '%';
                        }
                    }
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });

        // Function to generate random colors
        function getRandomColor() {
            return '#' + (Math.random().toString(16) + '000000').substring(2, 8).toUpperCase();
        }

        // Function to generate random colors for each category
        function getRandomColors(count) {
            var colors = [];
            for (var i = 0; i < count; i++) {
                colors.push(getRandomColor());
            }
            return colors;
        }

    </script>

@endsection
