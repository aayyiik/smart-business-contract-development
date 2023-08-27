<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF --}}
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('../../assets/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('../../assets/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet"
        href="{{ asset('../../assets/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('../../assets/admin-lte/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('../../assets/admin-lte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('../../assets/admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('../../assets/admin-lte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('../../assets/admin-lte/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('../../assets/admin-lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('../../assets/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css
    ">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.css" />
    <!-- DataTable Button-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.bootstrap4.min.css">
    <!--DataTable Fixed Column-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedcolumns/4.0.0/css/fixedColumns.dataTables.min.css">
    <!-- Pace-->
    <link rel="stylesheet" href="{{ asset('../../assets/pace/themes/red/pace-theme-flash.css') }}"> <!-- custom CSS -->
    <link href="{{ asset('../../assets/css/style.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('../../assets/img/logo.png') }}">
    <style>
        thead input {
            width: 100%;
        }
    </style>
    @stack('styles')
    <title>Draft Kontrak Online</title>
</head>

<body>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>
            <button class="btn btn-outline-second btn-xs" onclick="goBack()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <button class="btn btn-outline-second btn-xs" onclick="goForward()">
                <i class="fas fa-arrow-right"></i>
            </button>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-sm-inline-block dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-xs" style="font-weight: bold;">{{ Auth::user()->nik }}</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('signout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link ml-1 text-xs"><i
                                    class="fas fa-sign-out-alt fa-sm"></i> Keluar</button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-color">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link text-center py-2" style="background-color: white;">
                <img src="{{ asset('../../assets/img/sintract-02.png') }}" height="40" class="text-center">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <div class="profile text-center mt-4 mb-2">
                        <img src="{{ asset('../../assets/img/user.png') }}" alt="Profile Picture"
                            style="width: 30%; ">
                        <h6 style="color: white; margin-top: 15px">{{ Auth::user()->name }}</h6>
                        @if (Auth::user()->userdetail->role->role == 'Buyer')
                            <p style="color: #F69016;"> {{ Auth::user()->userdetail->role->role }}
                                {{ Auth::user()->userdetail->unit->unit }}</p>
                        @elseif(Auth::user()->userdetail->role->role == 'AVP')
                            <p style="color: #F69016;"> {{ Auth::user()->userdetail->role->role }}
                                {{ Auth::user()->userdetail->unit->unit }}</p>
                        @elseif(Auth::user()->userdetail->role->role == 'VP')
                            <p style="color: #F69016;"> {{ Auth::user()->userdetail->role->role }}
                                {{ Auth::user()->userdetail->department->department }}</p>
                        @elseif(Auth::user()->userdetail->role->role == 'SVP')
                            <p style="color: #F69016;"> {{ Auth::user()->userdetail->role->role }} TEKNIK</p>
                        @elseif(Auth::user()->userdetail->role->role == 'DKU')
                            <p style="color: #F69016;"> {{ Auth::user()->userdetail->role->role }}</p>
                        @elseif(Auth::user()->userdetail->role->role == 'Vendor')
                            <p style="color: #F69016;">{{ Auth::user()->userdetail->vendor_user->vendor }}</p>
                        @elseif(Auth::user()->userdetail->role->role == 'Legal')
                            <p style="color: #F69016;">{{ Auth::user()->userdetail->role->role }}</p>
                        @elseif(Auth::user()->userdetail->role->role == 'Super Admin')
                            <p style="color: #F69016;">{{ Auth::user()->userdetail->role->role }}</p>
                        @endif
                    </div>
                    <br>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link @yield('active-dashboard')">
                                <i class="nav-icon fas fa-chart-line fa-xs"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        @if (Auth::user()->userDetail->role->role == 'Super Admin')
                            <li class="nav-item">
                                <a href="{{ route('superadmin.users') }}" class="nav-link @yield('superadmin-user')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Data Pengguna
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.units') }}" class="nav-link @yield('superadmin-units')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Data Unit
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.vendors') }}" class="nav-link @yield('superadmin-vendors')">
                                    <i class="nav-icon fas fa-light fa-business-time fa-xs"></i>
                                    <p>
                                        Data Vendor
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.templates') }}" class="nav-link @yield('superadmin-templates')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Data Templates
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.departments') }}" class="nav-link @yield('superadmin-departments')">
                                    <i class="nav-icon fas fa-pencil-alt fa-xs"></i>
                                    <p>
                                        Data Departemen
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.statuses') }}" class="nav-link @yield('superadmin-statuses')">
                                    <i class="nav-icon fas fa-solid fa-check-circle fa-xs"></i>
                                    <p>
                                        Data Status
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.roles') }}" class="nav-link @yield('superadmin-roles')">
                                    <i class="nav-icon fas fa-solid fa-check-circle fa-xs"></i>
                                    <p>
                                        Data Role
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->userDetail->role->role == 'Buyer')
                            <li class="nav-item">
                                <a href="{{ route('buyer.contracts-monitoring') }}"
                                    class="nav-link @yield('active-contract')">
                                    <i class="nav-icon fas fa-light fa-business-time fa-xs"></i>
                                    <p>
                                        Monitoring Pekerjaan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('buyer.contracts-review-vendor') }}"
                                    class="nav-link @yield('buyer-review-vendor')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Review Vendor
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('buyer.contracts-review-legal') }}"
                                    class="nav-link @yield('buyer-review-legal')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Review Hukum
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('buyer.contracts-approval') }}"
                                    class="nav-link @yield('buyer-approval')">
                                    <i class="nav-icon fas fa-pencil-alt fa-xs"></i>
                                    <p>
                                        Approval Manajemen
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('buyer.contracts-final-vendor') }}"
                                    class="nav-link @yield('buyer-final-vendor')">
                                    <i class="nav-icon fas fa-light fa-signature fa-xs"></i>
                                    <p>
                                        Approval Rekanan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('buyer.contracts-final-buyer') }}"
                                    class="nav-link @yield('buyer-final')">
                                    <i class="nav-icon fas fa-solid fa-check-circle fa-xs"></i>
                                    <p>
                                        Final Rekanan
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->userDetail->role->role == 'Vendor')
                            <li class="nav-item">
                                <a href="{{ route('vendor.contracts') }}" class="nav-link @yield('active-contract')">
                                    <i class="nav-icon fas fa-light fa-business-time fa-xs"></i>
                                    <p>
                                        Monitoring Kontrak
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('vendor.sign-contracts') }}" class="nav-link @yield('sign-contract')">
                                    <i class="nav-icon fas fa-light fa-signature fa-xs"></i>
                                    <p>
                                        Tanda Tangan Kontrak
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->userDetail->role->role == 'Legal')
                            <li class="nav-item">
                                <a href="{{ route('legal.contracts') }}" class="nav-link @yield('active-contract')">
                                    <i class="nav-icon fas fa-light fa-business-time fa-xs"></i>
                                    <p>
                                        Monitoring Kontrak
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('legal.review-contracts') }}" class="nav-link @yield('review-contract')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Review Kontrak
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->userDetail->role->role == 'AVP')
                            <li class="nav-item">
                                <a href="{{ route('avp.contracts') }}" class="nav-link @yield('monitoring-contract')">
                                    <i class="nav-icon fas fa-light fa-business-time fa-xs"></i>
                                    <p>
                                        Monitoring Kontrak
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('avp.review-contracts') }}" class="nav-link @yield('review-contract')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Review Kontrak
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->userDetail->role->role == 'VP')
                            <li class="nav-item">
                                <a href="{{ route('vp.contracts') }}" class="nav-link @yield('monitoring-contract')">
                                    <i class="nav-icon fas fa-light fa-business-time fa-xs"></i>
                                    <p>
                                        Monitoring Kontrak
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('vp.review-contracts') }}" class="nav-link @yield('review-contract')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Review Kontrak
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->userDetail->role->role == 'SVP')
                            <li class="nav-item">
                                <a href="{{ route('svp.contracts') }}" class="nav-link @yield('monitoring-contract')">
                                    <i class="nav-icon fas fa-light fa-business-time fa-xs"></i>
                                    <p>
                                        Monitoring Kontrak
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('svp.review-contracts') }}" class="nav-link @yield('review-contract')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Review Kontrak
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->userDetail->role->role == 'DKU')
                            <li class="nav-item">
                                <a href="{{ route('dku.contracts') }}" class="nav-link @yield('monitoring-contract')">
                                    <i class="nav-icon fas fa-light fa-business-time fa-xs"></i>
                                    <p>
                                        Monitoring Kontrak
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dku.review-contracts') }}" class="nav-link @yield('review-contract')">
                                    <i class="nav-icon fas fa-light fa-paper-plane fa-xs"></i>
                                    <p>
                                        Review Kontrak
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">

                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            @yield('address')
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('dashboard')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 Departemen Pengadaan Jasa.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block mt-0">
                <div class="row justify-context-center">
                    <div class="col-md-12">
                        <p id="date" class="text-center mb-0 d-inline"></p>
                        <p id="time" class="text-center mb-0 d-inline"></p>
                        <b>-</b>
                        <p class="text-center mb-0 d-inline"> V 1.5</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('../../assets/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('../../assets/admin-lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('../../assets/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('../../assets/admin-lte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('../../assets/admin-lte/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('../../assets/admin-lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('../../assets/admin-lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('../../assets/admin-lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('../../assets/admin-lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('../../assets/admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('../../assets/admin-lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('../../assets/admin-lte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script
        src="{{ asset('../../assets/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <!-- Summernote -->
    <script src="{{ asset('../../assets/admin-lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('../../assets/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
    </script>
    <!-- Select2 -->
    <script src="{{ asset('../../assets/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('../../assets/admin-lte/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('../../assets/confirmation/popover.js') }}"></script>
    <!-- AdminLTE App -->
    <!-- AdminLTE App -->
    <script src="{{ asset('../../assets/confirmation/bootstrap-confirmation.js') }}"></script>
    <!-- Datatable -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.js">
    </script>
    <!-- DataTable Button -->
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.colVis.min.js"></script>
    <!-- Datatable Fixed Column -->
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>
    <!-- jQuery -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <!-- Sweet Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <!-- Pace -->
    <script src="{{ asset('../../assets/pace/pace.js') }}"></script>
    @stack('script')
    <!-- Date -->
    <script>
        const date = new Date();
        var options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric"
        };
        let tanggal = date.toLocaleDateString("id-ID", options);
        document.getElementById("date").innerHTML = tanggal;
    </script>
    {{-- Back dan Next --}}
    <script>
        function goBack() {
            window.history.back();
        }

        function goForward() {
            window.history.forward();
        }
    </script>

    {{-- Next --}}


    <!-- Time -->
    <script>
        function time() {
            const date = new Date();
            let waktu = date.toLocaleTimeString("id-ID");
            document.getElementById("time").innerHTML = waktu;
        }
        setInterval(time, 1000);
    </script>
    <script>
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
        });
    </script>

    <script>
        //Date Picker
        $('#reservationdate_add, #reservationdate_add_2, #reservationdate_edit, #reservationdate_edit_2').datetimepicker({
            format: 'yy-MM-DD'
        });

        //Date Mask
        $('#datemask').inputmask('yyyy-mm-dd', {
            'placeholder': 'yyyy-mm-dd'
        })
        $('[data-mask]').inputmask()
    </script>

    <script>
        $('.select2bs4, .select2bs42').select2({
            theme: 'bootstrap4',
            allowClear: true,
        })
    </script>

    <script>
        $(function() {
            $('#summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontname', 'fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['view', ['undo', 'redo', 'fullscreen', 'help']],
                ]
            })
        })
    </script>


    {{-- Datatable new versi --}}
    <script>
        $(document).ready(function() {

            // Setup - add a text input to each footer cell
            $('#datatable thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#datatable thead');

            var table = $('#datatable').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');

                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr =
                                    '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        });
    </script>

    {{-- data table Bisa dipakai kembali tapi jangan lupa destroy grid data table sebelumnya --}}
    {{-- <script type="text/javascript">
    // DataTable
    $(function() {
        $('#pekerjaanTable .second-row th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text"  class="form-control" placeholder="" />');
        });
        $(document).ready(function() {
            $('.datatable2').DataTable({
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    ['10', '25', '50', '100', 'All']
                ],
                ordering: false,
                scrollY: '500px',
                scrollCollapse: true,
                pageLength: 100,
                initComplete: function() {
                    this.api().columns([0, 1, 2, 3, 4, 5]).every(function() {
                        var that = this;

                        $('input', this.header()).on('keyup change clear',
                            function() {
                                if (that.search() !== this.value) {
                                    that
                                        .search(this.value)
                                        .draw();
                                }
                            });
                    });
                },
            });
        });
    });
</script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>


</body>

</html>
