<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/custom.css') }}">
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="{{ asset('assets/logo1.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.1.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/shared/iconly.css">

</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative align-items-center">
                    <div class="justify-content-between align-items-center">
                        <div class="logo">
                            <img src="{{ asset('assets/logo2.png') }}" id="logo_nav" alt="Logo"
                                srcset="">
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2" id="theme_toggle">
                            <i class="mdi mdi-bird"></i>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" >
                                <label class="form-check-label" ></label>
                            </div>
                            <i class="mdi mdi-sleep"></i>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item active">
                            <a href="#" class='sidebar-link'>
                                <i class="mdi mdi-duck"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class='sidebar-link'>
                                <i class="mdi mdi-account"></i>
                                <span>Users</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class='sidebar-link'>
                                <i class="mdi mdi-book-music"></i>
                                <span>Buku</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class='sidebar-link'>
                                <i class="mdi mdi-headphones"></i>
                                <span>Literatur</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div>
                @if (session()->has('error'))
                    <div class="alert alert-danger">{!! session('error') !!}
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">{!! session('success') !!}
                    </div>
                @endif
            </div>
            <div class="page-heading">
                <h3>Dashboard</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-6 col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                <div class="stats-icon purple mb-2">
                                                    <i class="mdi mdi-book-music"></i>
                                                </div>
                                                <h4 class="text-muted font-semibold" style="margin-left:70px;">Jumlah <br> Buku</h4>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h4 class="font-extrabold mb-0">112.000</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon blue mb-2">
                                                    <i class="mdi mdi-headphones"></i>
                                                </div>
                                                <h4 class="text-muted font-semibold" style="margin-left:70px;">Jumlah <br> Literatur</h4>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h4 class="font-extrabold mb-0">183.000</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <i class="fa fa-solid fa-circle"
                                style="color:#00FF38; margin-left: 2.5px; padding: 10px 0px 0px 180px;"></i>
                            <div class="card-body py-1 px-4 mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                        <img src="assets/images/faces/1.jpg" id="icon_profil" alt="Face 1">
                                    </div>
                                    <div class="ms-1 name">
                                        <h5 class="font-bold">{{ auth()->user()->name }}</h5>
                                        {{-- <h6 class="text-muted mb-0">@johnducky</h6> --}}
                                        {{-- <li> --}}
                                            <a href="/logout"><i class="mdi mdi-power"></i><span>Log Out</span></a>
                                        {{-- </li> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Liditune</p>
                    </div>
                </div>
            </footer>

            <script src="assets/js/bootstrap.js"></script>
            <script src="assets/js/app.js"></script>

            <!-- Need: Apexcharts -->
            <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
            <script src="assets/js/pages/dashboard.js"></script>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // show the alert
            setTimeout(function() {
                $(".alert").alert('close');
            }, 2000);
        });
    </script>
</body>

</html>
