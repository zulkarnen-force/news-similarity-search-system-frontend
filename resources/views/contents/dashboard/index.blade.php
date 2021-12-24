@extends('layouts.frontend')
@section('title','Binocular')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Basic Card Example</h6>
            </div>
            <div class="card-body">
                <div id="container"></div>
            </div>
        </div>
    </div>
<script type="text/javascript">
        var users = {{ json_encode($users) }};
        var files = {{ json_encode($files) }};
        Highcharts.chart('container', {
            chart: {
                type: 'spline',
                scrollablePlotArea: {
                minWidth: 600,
                scrollPositionX: 1
                }
            },
            title: {
                text: 'Temporary Display'
            },
            subtitle: {
                text: 'Kedepannya ini untuk Report Generatornya'
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
</script>
@endsection