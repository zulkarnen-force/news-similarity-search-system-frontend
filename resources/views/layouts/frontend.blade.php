<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{url('/issets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="{{url('/issets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{url('/issets/css/style.css')}}" rel="stylesheet">
    <link rel="icon" href="{{url('/issets/img/undraw_rocket.svg')}}">

    {{-- jspreadsheets --}}
    <script src="https://jspreadsheet.com/v8/jspreadsheet.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jspreadsheet.com/v8/jspreadsheet.css" type="text/css" />
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />

    {{-- highcharts --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('components.sidebar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

        @include('components.topbar')

        @yield('content')

            </div>
            <!-- End of Main Content -->

        @include('components.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="logout-text"><i class="fas fa-exclamation-triangle"></i> If you log out, your session will be expire which requires you to login again</p>
                </div>
                <div class="modal-footer">
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="btn btn-secondary"  type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{url('/issets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{url('/issets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{url('/issets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{url('/issets/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{url('/issets/vendor/chart.js/Chart.min.js')}}"></script>
</body>

</html>