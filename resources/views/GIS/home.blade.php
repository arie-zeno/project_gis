@extends("GIS.layouts.app")

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


<style>
  #map {
      height: 70vh;
      width: 100%;
      border: 3px solid #222e64;
      border-radius: 12px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    }

  #map:hover {
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.3);
  }

    span{
        color: #ff9800;
    }

    nav{
        transition: 0.2s;
    }

    .container-home{
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .welcome{
      /* background-color: rgba(0, 0, 0, 0.329); */
      padding: 20px;
    }

    body{
      background-image: url('/img/playstation-pattern.webp');
    }
</style>

@section("content")
    {{-- <div class="container-fluid container-home" style="position:relative">
      <div style="background-color:rgba(0, 0, 0, 0.385); position: absolute; top: 0; bottom: 0; left: 0; right: 0; z-index: 1; ">

      </div>
      
  <div class="container ">
        <div class=" row justify-content-between align-items-center" style="height: 100vh ;">
          
          
          <div class="col-sm-6 " style="z-index: 2; ">
            
        </div>
        <div class="col-sm-5 welcome " style="z-index: 2;/* From https://css.glass */
          background: rgba(0, 0, 0, 0.2);
          border-radius: 16px;
          box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
          backdrop-filter: blur(5px);
          -webkit-backdrop-filter: blur(5px);">
              <h1 class="fw-bold text-white text-shadow">Selamat Datang Di Website <span><b> Tracer Study </b></span> Prodi Pendidikan Komputer Universitas Lambung Mangkurat</h1>
              <p class="text-white fs-5 mt-4">Mari sukseskan pelaksanaan <span><b> Tracer Study </b></span> Prodi Pendidikan Komputer Universitas Lambung Mangkurat dengan mengisi biodata anda <a style="text-decoration: none" href="http://"><span><i><b> disini. </b></i></span></a> </p>
            </div>
        </div>

      </div>
  </div> --}}
  <div class="container-home" style="height: 85vh;" >
    <div id="particles-js"></div>
    <div class="container my-auto">

        <div style="position: relative; " class="row justify-content-start align-items-center">
            <div class="col-sm-6 p-5" >
                <h2 style="color: #222e64;">Sistem Informasi Geografis <span style="color: #ff9800;">Pemetaan Persebaran Mahasiswa</span> <br>Prodi Pendidikan Komputer <br></h2>
            </div>
            <div class="col-sm-6" data-aos="fade-up">
              <div id="map" style=" width: 100%; border-radius: 12px;"></div>
            </div>
        </div>
    </div>
  </div>


  <script>
    document.getElementById("map").addEventListener("click", function () {
        window.location.href = "/gis-mahasiswa"; // Ganti dengan route yang sesuai
    });

    var map = L.map('map').setView([-3.306018932804326, 114.61100239854602], 12); 

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Contoh marker
    // L.marker([-3.319437, 114.59075]).addTo(map)
    //     .bindPopup('Universitas Lambung Mangkurat')
    //     .openPopup();

    var ulmIcon = L.icon({ iconUrl: "/img/Logo_ULM.png", iconSize: [35, 35] });
    var marker = L.marker([-3.298618801108944, 114.58542404981114], { icon: ulmIcon }).addTo(map);
    marker.bindPopup('Pendidikan Komputer FKIP ULM');

    // Memastikan ukuran map tetap benar saat resize atau mobile
    // setTimeout(function() {
    //     map.invalidateSize();
    // }, 500);
</script>
