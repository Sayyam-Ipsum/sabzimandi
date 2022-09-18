<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sabzimandi</title>
    <link href="/assets/dist/img/AdminLTELogo.png" rel="apple-touch-icon-precomposed">
    <link href="/assets/dist/img/AdminLTELogo.png" rel="shortcut icon" type="image/png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Sweet alert -->
    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
</head>

<body class="hold-transition login-page">
<div class="login-box ">
    <div class="login-logo pt-4 text-center">
        <a href="#"><b>Sabzimandi</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card ">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{url('login')}}" method="post" name="login-form" id="login-form">
                @csrf
                <div class="input-group">
                    <input type="email" name="email" id="email" required class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <label id="email-error" class="error" for="email"
                       style="display: none;color: red;font-weight: normal;"></label>
                <div class="input-group mt-3">
                    <input type="password" required class="form-control" name="password" placeholder="Password"
                           id="password">
                    <div class="input-group-append">
                        <div class="input-group-text" onclick="myFunction()" style="cursor:pointer;">
                            <span class="fas fa-eye"></span>
                        </div>
                    </div>
                </div>
                <label id="password-error" class="error" for="password"></label>

                <div class="col-12 mt-3">
                    <p class="mb-1 text-right">
                        <a href="/forgot" class="logo-font-blue" style="text-decoration-line: underline;">Forgot Password?</a>
                    </p>
                </div>
                <!-- /.col -->
                <div class="col-12 mt-3 p-0">
                    <button type="submit" class="btn btn-success logo-blue btn-block">Sign In</button>
                </div>
                <!-- /.col -->

            </form>

        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Sweet alert -->
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Jquery Validation -->
<script src="{{asset('assets/plugins/jquery-validate/jquery.validate.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>--}}
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>

<script type="text/javascript">
    function toast(title, type) {
        Swal.fire({
            toast: true,
            title: title,
            text: '',
            icon: type,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        });
    }

    var pass = document.getElementById('password');

    function myFunction() {
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    }

    $(document).ready(function () {
        $("#login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 50
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength: 12
                }
            },
            messages: {
                email: {
                    required: "Email is Required*",
                    email: "Must be a valid Email",
                    maxlength: "Maximum Email will be of 50 characters."
                },
                password: {
                    required: "Password is Required*",
                    minlength: "Must be at least 8 characters long",
                    maxlength: "Must be at most 12 characters long",
                }
            },
            submitHandler: function (form) {
                return true;
            }
        });
    });
</script>
<script>
    @include('partials.response')
</script>
</body>

</html>
