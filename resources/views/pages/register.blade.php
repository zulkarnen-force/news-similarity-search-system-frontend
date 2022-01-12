<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Binosaurus - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{url('/issets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{url('/issets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="icon" href="{{url('/issets/img/undraw_rocket.svg')}}">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-6 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            @if (session()->has('failed'))
                                <div class="alert alert-danger" role="alert" id="failed">
                                    Sorry Your Username Has been Already
                                </div>
                            @endif
                            <form class="user" action="{{route('register')}}" method="post">
                                @csrf
                                {{-- start name --}}
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleFirstName" placeholder="Full Name" name="name" value="{{ old('name')}}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                </div>
                                {{-- end name --}}

                                {{-- start password --}}
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleFirstpassword" placeholder="password" name="password" value="{{('password')}}">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                </div>
                                {{-- end password --}}
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{route('login')}}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
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

    <script>
        setTimeout(() => {
            $('#failed').slideUp('fast');
        }, 1500);
    </script>

</body>

</html>