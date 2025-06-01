<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $title }} </title>
  {{-- <link rel="stylesheet" href="style.css" /> --}}

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

 <!-- jQuery -->
 <script src="{{asset('AdminLTE')}}/plugins/jquery/jquery.min.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
    .t-nav {
             color: #222e64;
             transition: 0.2s;
           }
   
     .t-nav:hover{
       transform: scale(1.2);
       color: #222e64;
     }
   
     .t-nav:active{
       background-color: transparent;
       border-bottom: 3px solid;
       border-radius: 10px;
     }
     .dropdown-menu{
       border: none;
     }

     .nav-link.active {
        /* font-weight: bold; */
        border-bottom: 2px solid #222e64;
        border-radius: 10px;
      }

      .nav-link.active {
        color: #222e64 !important;
        font-weight: bold;
        border-bottom: 2px solid #222e64;
      }

      .navbar-nav .nav-item {
        margin-right: 20px;
      }

      body {
      padding-top: 55px;
    }
      


  </style>

  <style>
    canvas{ display: block; vertical-align: bottom; } /* ---- particles.js container ---- */ 
    #particles-js{ position:absolute; width: 100%; height: 100%; background-color: #ffffff; background-image: url(""); background-repeat: no-repeat; background-size: cover; background-position: 50% 50%; } /* ---- stats.js ---- */ 
    .count-particles{ background: #000022; position: absolute; top: 48px; left: 0; width: 80px; color: #13E8E9; text-align: left; text-indent: 4px; line-height: 14px; padding-bottom: 2px; font-family: Helvetica, Arial, sans-serif; font-weight: bold; } 
    .js-count-particles{ font-size: 1.1em; } #stats, .count-particles{ -webkit-user-select: none; margin-top: 5px; margin-left: 5px; } #stats{ border-radius: 3px 3px 0 0; overflow: hidden; } .count-particles{ border-radius: 0 0 3px 3px; }
  </style>
</head>
<body>
 <!-- particles.js container --> <div id="particles-js"></div> <!-- stats - count particles --><!-- particles.js lib - https://github.com/VincentGarreau/particles.js --> <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> <!-- stats.js lib --> <script src="http://threejs.org/examples/js/libs/stats.min.js"></script> 

  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container ">
      <a class="navbar-brand t-nav" href="/" >PILKOM GIS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
        <ul class="navbar-nav" >
          <li class="nav-item">
            <a class="nav-link t-nav {{ Request::is('/') || Request::is('home') ? 'active' : '' }}" href="/home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link t-nav {{ Request::is('gis-mahasiswa') ? 'active' : '' }}" href="/gis-mahasiswa">Persebaran Asal Mahasiswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link t-nav {{ Request::is('gis-sekolah') ? 'active' : '' }}" href="/gis-sekolah">Persebaran Asal Sekolah</a>
          </li>
          <li class="nav-item">
            <a class="nav-link t-nav {{ Request::is('statistik') ? 'active' : '' }}" href="/statistik">Statistik</a>
          </li>           
        </ul>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link t-nav {{ Request::is('login') ? 'active' : '' }}" href="/login">Login</a>
          </li>
        </ul>
      </div>
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

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const navbar = document.querySelector(".navbar");
  
      window.addEventListener("scroll", function () {
        if (window.scrollY > 10) {
          navbar.classList.add("scrolled");
        } else {
          navbar.classList.remove("scrolled");
        }
      });
    });
  </script>
  <script>
    particlesJS("particles-js", {"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#222e64"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#222e64","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});var count_particles, stats, update; stats = new Stats; stats.setMode(0); stats.domElement.style.position = 'absolute'; stats.domElement.style.left = '0px'; stats.domElement.style.top = '0px'; document.body.appendChild(stats.domElement); count_particles = document.querySelector('.js-count-particles'); update = function() { stats.begin(); stats.end(); if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) { count_particles.innerText = window.pJSDom[0].pJS.particles.array.length; } requestAnimationFrame(update); }; requestAnimationFrame(update);;
  </script>
  <script>
    if (!sessionStorage.getItem('hasVisited')) {
        sessionStorage.setItem('hasVisited', 'true');
        setTimeout(function() {
            window.location.href = "/gis-mahasiswa";
        }, 1000);
    }
</script>
</body>
</html>

