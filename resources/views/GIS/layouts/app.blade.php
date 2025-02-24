<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }} </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/dist/css/adminlte.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{asset('AdminLTE')}}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

    <!-- jQuery -->
    <script src="{{asset('AdminLTE')}}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('AdminLTE')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{asset('AdminLTE')}}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('AdminLTE')}}/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('AdminLTE')}}/dist/js/demo.js"></script>


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Cluster --}}
    {{-- cluster --}}
    <link rel="stylesheet" href="js/Leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="/js/Leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <script src="/js/Leaflet.markercluster/dist/leaflet.markercluster-src.js"></script>
    <link rel="stylesheet" href="/js/treeLayer/L.Control.Layers.Tree.css">
    <script src="/js/treeLayer/L.Control.Layers.Tree.js"></script>

    {{-- slide menu --}}
    {{-- Slide --}}
    <link rel="stylesheet" href="/css/L.Control.SlideMenu.css">
    <script src="/js/L.Control.SlideMenu.js"></script>

    <style>
        .navbar {
          background-color: #415884;
          position: fixed; /* Make navbar fixed */
          top: 0; /* Pin it to the top */
          width: 100%; /* Ensure it spans the full width */
          z-index: 1030; /* Ensure it stays on top of other content */
        }
      
        .brand-text {
          font-weight: 500;
          color: #CAD6FF;
          font-size: 24px;
          transition: 0.3s color;
        }
      
        .login-button {
          background-color: #CAD6FF;
          color: #000;
          font-size: 14px;
          padding: 8px 20px;
          border-radius: 50px;
          text-decoration: none;
          transition: 0.3s background-color;
        }
      
        .login-button:hover {
          background-color: #CAD6FF;
        }
      
        .nav-link {
          color: #fff;
          font-weight: 500;
          position: relative;
        }
      
        .nav-link:hover,
        .nav-link.active {
          color: #CAD6FF;
        }
      
        body {
          padding-top: 70px; /* Add padding to prevent content from being overlapped by navbar */
        }
        .collapse {
          background-color: #415884;
        }
      
        .navbar {
          background-color: #415884; 
        }
      
      
        .brand-text {
          font-weight: 500;
          color:#CAD6FF;
          font-size: 24px;
          transition: 0.3s color;
        }
      
        .login-button {
          background-color: #CAD6FF;
          color: #000;
          font-size: 14px;
          padding: 8px 20px;
          border-radius: 50px;
          text-decoration: none;
          transition: 0.3s background-color;
        }
        .login-button:hover {
          background-color: #CAD6FF;
        }
      
        .navbar-toggler {
          border: none;
          font-size: 1.25rem;
        }
      
      
        .navbar-toggler:focus, .btn-close:focus {
          box-shadow: none;
          outline: none;
        }
      
        .nav-link {
          color: #fff;
          font-weight: 500;
          position: relative;
        }
      
        .nav-link:hover, .nav-link.active {
          color: #CAD6FF;
        }
      
        @media (min-width:991px) {
          .nav-link::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: #CAD6FF;
            visibility: hidden;
            transition: 0.3s ease-in-out;
          }  
      
          .nav-link:hover::before, .nav-link.active::before {
            width: 100%;
            visibility: visible;
          }
        }
      
      </style>

</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
    
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
          <a href="/" class="navbar-brand">
            <img src="{{asset('AdminLTE')}}/dist/img/logoulm.png" alt="SIG Banjarmasin" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"><b>PILKOM</b></span>
          </a>
    
          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
    
          <div class="collapse navbar-collapse order-3 " id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
              <li class="nav-item">
                <a href="/home" class="nav-link text-light">Beranda</a>
              </li>
              <li class="nav-item">
                <a href="/gis-mahasiswa" class="nav-link text-light">Persebaran Daerah Asal</a>
              </li>
              <li class="nav-item">
                <a href="/gis-domisili" class="nav-link text-light">Persebaran Domisili</a>
              </li>
              <li class="nav-item">
                <a href="/gis-sekolah" class="nav-link text-light">Persebaran Sekolah Asal</a>
              </li>
              <li class="nav-item">
                <a href="/statistik" class="nav-link text-light">Statistik</a>
              </li>
            </ul>
          </div>
    
          <!-- Right navbar links -->
          <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">          
                <a class="login-button"  href="/login" >
                  <i class="fas fa-user fa-light"> Login </i>
                </a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- /.navbar -->

        <main>
            @include('sweetalert::alert') <!-- Tambahkan ini -->
            @yield('content')
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
            crossorigin="anonymous"></script>
        @yield('js')
      </div>
      <!-- /.content-wrapper -->
    
    
    
      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2024 <a href="https://www.instagram.com/alfika_nf">Alfika Nurfadia</a>.</strong> All rights reserved.
      </footer>
    </div>
    <!-- ./wrapper -->
    
    
    </body>
</html>
