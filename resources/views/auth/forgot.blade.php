<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - Sabzimandi</title>
    <link href="/assets/dist/img/AdminLTELogo.png" rel="apple-touch-icon-precomposed">
    <link href="/assets/dist/img/AdminLTELogo.png" rel="shortcut icon" type="image/png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <!-- Sweet alert -->
    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Sabzimandi</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

            <form action="{{url('/forgot')}}" method="post" name="password-forgot-form" id="password-forgot-form">
                @csrf
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email" required name="email" id="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <label id="email-error" class="error" for="email"
                       style="display: none;color: red;font-weight: normal;"></label>
                <div class="row mt-2">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success btn-block">Request new password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="/login" style="text-decoration-line: underline;">Login</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Jquery Validation -->
<script src="{{asset('assets/plugins/jquery-validate/jquery.validate.min.js')}}"></script>
<!-- Sweet alert -->
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>--}}
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>

<script>
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

    $(document).ready(function () {
        $("#password-forgot-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Email is Required*",
                    email: "Must be a valid Email",
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
