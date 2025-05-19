<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $title }} </title>
  <link rel="stylesheet" href="style.css" />

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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



  {{-- cluster --}}
  <link rel="stylesheet" href="js/Leaflet.markercluster/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="/js/Leaflet.markercluster/dist/MarkerCluster.Default.css" />
  <script src="/js/Leaflet.markercluster/dist/leaflet.markercluster-src.js"></script>
  <link rel="stylesheet" href="/js/treeLayer/L.Control.Layers.Tree.css">
  <script src="/js/treeLayer/L.Control.Layers.Tree.js"></script>

  {{-- slide menu --}}
  <link rel="stylesheet" href="/css/L.Control.SlideMenu.css">
  <script src="/js/L.Control.SlideMenu.js"></script>


  <style>
    body {
    margin: 0;
    font-family: sans-serif;
    }

    .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    padding: 1rem 2rem;
    }

    .breadcrumb a {
    color: #1a73e8;
    text-decoration: none;
    margin-right: 4px;
    }

    /* Hero section */
    .hero {
    position: relative;
    height: 100vh;
    background: url('/img/gerbang ulm.jpg') no-repeat center center/cover;
    }

    .hero-overlay {
    background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0));
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 4rem;
    max-width: 60%;
    }

    .hero-overlay h1 {
    font-size: 3rem;
    margin-bottom: 1.5rem;
    }

    .hero-overlay p {
    font-size: 1.25rem;
    line-height: 1.6;
    }

    .content {
    /* height: 2000px;
    background: #fff; */
    padding: 2rem;
    }

  </style>
</head>
<body>

  <nav class="navbar">
    <div class="breadcrumb">
      <a href="/home">Home</a> / 
      <a href="/gis-mahasiswa"> Persebaran Asal Daerah</a> / 
      <a href="/gis-sekolah"> Persebaran Asal Sekolah</a> /
      <a href="/statistik"> Statistik</a> 
      {{-- <span>GIS Mahasiswa PILKOM</span> --}}
    </div>
  </nav>


  <div class="content">
    <main>
      @include('sweetalert::alert') <!-- Tambahkan ini -->
      @yield('content')
    </main>
  </div>

  
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  
  @yield('js')


</body>
</html>

