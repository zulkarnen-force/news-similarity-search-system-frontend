@extends('layouts.frontend')
@section('title','Binocular')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        @auth
        @if (Auth::user()->roles == "ADMIN")
        <div class="row">
            <!-- Admin Count Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    ADMIN</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countadmin}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-cog fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- User Count Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    USER</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countuser}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- File Count Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Files</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countfile}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-excel fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        @endif
        <!-- File detail Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User and File Data Analysis</h6>
            </div>
            <div class="card-body">
                <div id="container"></div>
            </div>
        </div>

        <div class="row">
            {{-- Card Map --}}
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Binocular Map</h6>
                    </div>
                    <div class="card-body">
                        {{-- content --}}
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1387442699174!2d110.43090571477805!3d-7.775109294396594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5a1925d0165d%3A0x91e9a2049cb1abc8!2sPT%20BINOKULAR%20MEDIA%20UTAMA%20Yogyakarta!5e0!3m2!1sen!2sid!4v1643268133468!5m2!1sen!2sid" class="mapping" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <!-- Card Reporter -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Reporter Records</h6>
                    </a>
                    <div class="collapse show" id="collapseCardExample">
                        <div class="card-body">
                            {{-- content --}}
                            <div id="reported"></div>
                            <input type="text" value="{{json_encode($reported)}}" id="data" hidden>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    </div>
<script type="text/javascript">
    var users = {{ json_encode($users) }};
    var files = {{ json_encode($files) }};
    var reported = document.getElementById('data').value;
    var reported = JSON.parse(reported)

    // Chart jumlah data User & File
    Highcharts.chart('container', {
            chart: {
                type: 'spline',
                scrollablePlotArea: {
                minWidth: 600,
                scrollPositionX: 1
                }
            },
            title: {
                text: 'Data Display'
            },
            subtitle: {
                text: 'Data Number of Users and Files'
            },
            xAxis: {
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September','October', 'November', 'December'
                ]
            },
            yAxis: {
                title: {
                    text: 'Number of New Users & data Uploaded'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true
                }
            },
            series: [{
                name: 'New Users',
                data: users
            },{
                name: 'Files Uploaded',
                data: files
            }
        ],
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

    // Jumlah laporan setiap Users
    Highcharts.chart('reported', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Data Reporter at Bino'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Contribution',
            colorByPoint: true,
            data: reported
        }]
    });
  
</script>
@endsection