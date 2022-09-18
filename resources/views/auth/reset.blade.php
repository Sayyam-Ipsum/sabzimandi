<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Sabzimandi</title>
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
            <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

            <form action="{{url('reset')}}" method="post" name="password-reset-form" id="password-reset-form">
                @csrf
                <input type="hidden" name="reset_token" value="{{@$resetToken->token}}">
                <input type="hidden" name="user_id" value="{{@$user->id}}">
                <div class="input-group mt-1">
                    <input type="password" class="form-control" placeholder="New Password" autocomplete="off" required
                           name="password" id="password">
                    <div class="input-group-append">
                        <div class="input-group-text" onclick="myFunction()" style="cursor:pointer;">
                            <span class="fas fa-eye"></span>
                        </div>
                    </div>
                </div>
                <label id="password-error" class="error" for="password"></label>


                <div class="input-group mt-2">
                    <input type="password" class="form-control" placeholder="Confirm Password" autocomplete="off"
                           name="confirm_password" id="confirm_password">
                    <div class="input-group-append">
                        <div class="input-group-text" onclick="myCFunction()" style="cursor:pointer;">
                            <span class="fas fa-eye"></span>
                        </div>
                    </div>
                </div>
                <label id="confirm_password-error" class="error" for="confirm_password"></label>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success btn-block">Change password</button>
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

    var pass = document.getElementById('password');

    function myFunction() {
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    }

    var cpass = document.getElementById('confirm_password');

    function myCFunction() {
        if (cpass.type === "password") {
            cpass.type = "text";
        } else {
            cpass.type = "password";
        }
    }

    $(document).ready(function () {
        $("#password-reset-form").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                confirm_password: {
                    equalTo: "#password",
                },
            },
            messages: {
                password: {
                    required: "New password is Required*",
                    minlength: "Password must contain at least 8 characters",
                },
                confirm_password: {
                    equalTo: "Password should be same as New Password",
                },
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
