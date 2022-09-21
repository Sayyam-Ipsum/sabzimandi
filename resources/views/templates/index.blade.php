<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Digital Farmers Market">
    <meta name="author" content="Digital Farmers Market">
    <meta name="generator" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="/assets/dist/img/AdminLTELogo.png" rel="apple-touch-icon-precomposed">
    <link href="/assets/dist/img/AdminLTELogo.png" rel="shortcut icon" type="image/png">
    <title>@yield('page-title') - Sabzimandi</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- Sweet alert -->
    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">--}}
<!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Datatable CSS -->
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Dropzone CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/dropzone/min/dropzone.min.css')}}">
    <!-- Highchart CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/highchart/highcharts.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    {{--    <link--}}
    {{--        rel="stylesheet"--}}
    {{--        href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"--}}
    {{--        type="text/css"--}}
    {{--    />--}}
    <style>

    </style>
    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- dimmer starts -->
<div class="dimmer">
    <div class="text-center">
        <div class="spinner-border"
             role="status">
            <span class="sr-only">Loading...</span>
        </div>
        {{--        <div class="mt-3 " style=" color: #ffffff;">--}}
        {{--            <h4> Loading... </h4>--}}
        {{--        </div>--}}
    </div>
</div>
<!-- dimmer ends -->
<div class="wrapper">

    <!-- Preloader -->
{{--    <div class="preloader flex-column justify-content-center align-items-center">--}}
{{--        <img class="animation__shake" src="{{asset('assets/images/logo.png')}}" alt="AdminLTELogo" height="200px" width="300px">--}}
{{--    </div>--}}

<!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-user-alt"></i>
                </a>
                <div class="dropdown-menu p-0 dropdown-menu-sm dropdown-menu-right">
                    <span class="dropdown-item dropdown-header bg-success text-white">
                        {{auth()->user()->name}}
                        <small class="d-block text-center">({{auth()->user()->role->name}})</small>
                    </span>
                    <a href="/profile" class="dropdown-item m-0">Profile</a>
                    <a href="/setting" class="dropdown-item m-0">Settings</a>
                    <a href="/logout" class="dropdown-item m-0 dropdown-footer bg-dark text-white">Logout</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-success elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <span class="brand-text font-weight-bold">Sabzimandi</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <div class="image">
                    {{--                    @if(profilePic())--}}
                    {{--                        <img src="{{profilePic()}}" class="img-circle elevation-2" alt="User Image">--}}
                    {{--                    @else--}}
                    <img src="{{asset('assets/images/user.png')}}" class="img-circle elevation-2" alt="User Image">
                    {{--                    @endif--}}

                </div>
                <div class="info">
                    <a href="javascript:void(0);" class="d-block">{{auth()->user()->name}}</a>
                    <p class="m-0"><small class="text-success">({{auth()->user()->role->name}})</small></p>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @can('PageAccess.Dashboard')
                        <li class="nav-item">
                            <a href="{{url('dashboard')}}" class="nav-link">
                                <i class="nav-icon fa fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('PageAccess.Users')
                        <li class="nav-item">
                            <a href="{{url('customers')}}" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Customers
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('PageAccess.Products')
                        <li class="nav-item">
                            <a href="{{url('products')}}" class="nav-link">
                                <i class="nav-icon fa fa-cubes"></i>
                                <p>
                                    Products
                                </p>
                            </a>
                        </li>
                    @endcan

                    <li class="nav-item">
                        <a href="{{url('pos')}}" class="nav-link">
                            <i class="nav-icon fa fa-balance-scale"></i>
                            <p>
                                POS
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link bg-success text-white">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>
                                Sale
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{url('sales')}}" class="nav-link">
                                    <i class="nav-icon fas fa-angle-right"></i>
                                    <p>
                                        Listing
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('sales/today')}}" class="nav-link">
                                    <i class="nav-icon fas fa-angle-right"></i>
                                    <p>
                                        Today's Sale
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link bg-success text-white">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Admin
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('PageAccess.Users')
                                <li class="nav-item">
                                    <a href="{{url('users')}}" class="nav-link">
                                        <i class="nav-icon fas fa-angle-right"></i>
                                        <p>
                                            User Management
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('PageAccess.Roles')
                                <li class="nav-item">
                                    <a href="{{url('roles')}}" class="nav-link">
                                        <i class="nav-icon fas fa-angle-right"></i>
                                        <p>
                                            Role Management
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{url('logout')}}" class="nav-link bg-dark text-white">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header shadow-sm">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="m-0 text-capitalize">@yield('title')</h3>
                    </div>
                    <div class="col-sm-6 text-right">
                        @yield('page-actions')
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid py-2">
                @yield('content')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2019-2023</strong>
        All rights reserved.
        {{--        <div class="float-right d-none d-sm-inline-block">--}}
        {{--            <b>Version</b> 3.2.0--}}
        {{--        </div>--}}
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Modal Box -->
<div class="modal fade" id="global-modal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="global-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="global-modal-body">
                Something went wrong
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Jquery Validation -->
<script src="{{asset('assets/plugins/jquery-validate/jquery.validate.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>--}}
<!-- Dropzone JS -->
<script src="{{asset('assets/plugins/dropzone/min/dropzone.min.js')}}" type="text/javascript"></script>
{{--<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>--}}
<!-- ChartJS -->

<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- Moment JS -->
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('assets/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{asset('assets/dist/js/pages/dashboard.js')}}"></script>--}}
<!-- Sweet alert -->
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>--}}
<!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Datatables JS -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
{{--<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>--}}
<!-- CHART JS -->
<script src="{{asset('assets/highchart/highcharts.js')}}"></script>
<script src="{{asset('assets/highchart/chart.js')}}"></script>
<script>

    $(function () {
        var current = location.pathname;
        var c = document.URL;
        $('.nav .nav-item .nav-link').each(function () {
            var $this = $(this);
            // if the current path is like this link, make it active
            if ($this.attr('href') == c || $(this).attr('href') == current) {
                $this.addClass('active');
            }
            // if($this.attr('href').indexOf(current) !== -1){
            //     $this.addClass('active');
            // }
        })
    });
</script>
<script>
    //Initialize Select2 Elements
    $('.select2').select2({
        theme: 'bootstrap4'
    });

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

    function blockUI() {
        $(".dimmer").show();
    }

    function unblockUI() {
        $(".dimmer").hide();
    }

    function open_modal(url) {
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            dataType: "json",
            cache: false,
            success: function (res) {
                $("#global-modal-title").html(res.title);
                $("#global-modal-body").html(res.html);
                if ($("#global-modal-body").find('.select2')) {
                    $("#global-modal-body").find('.select2').select2({
                        theme: "bootstrap4",
                        dropdownParent: $('#global-modal')
                    });
                }
                $("#global-modal").modal("show");
            }
        });
    }
</script>
<script type="text/javascript">
    (function ($) {
        /* Store sidebar state */
        $('.sidebar-toggle').click(function (event) {
            event.preventDefault();
            if (Boolean(localStorage.getItem('sidebar-toggle-collapsed'))) {
                localStorage.setItem('sidebar-toggle-collapsed', '');
            } else {
                localStorage.setItem('sidebar-toggle-collapsed', '1');
            }
        });
    })(jQuery);
</script>
<script type="text/javascript">
    /* Recover sidebar state */
    (function () {
        if (Boolean(localStorage.getItem('sidebar-toggle-collapsed'))) {
            var body = document.getElementsByTagName('body')[0];
            body.className = body.className + ' sidebar-collapse';
        }
    })();
</script>
<script>
    @include('partials.response')
</script>
@yield('scripts');
</body>
</html>
