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

</style>
@section("content")
  <div class="container-home" style="height: 90vh;" >
    <div id="particles-js"></div>
    <div class="container my-auto">

        <div style="position: relative; " class="row justify-content-start align-items-center">
            <div class="col-sm-6 p-3" >
                <h2 style="color: #222e64;">Sistem Informasi Geografis <span style="color: #ff9800;">Pemetaan Persebaran Mahasiswa</span> <br>Prodi Pendidikan Komputer <br></h2>
            </div>
            <div class="col-sm-6" data-aos="fade-up">
              <div id="map" style=" width: 100%; border-radius: 12px;"></div>
              <p style="text-align: center; color: #222e64;">Klik peta untuk melihat persebaran mahasiswa.</p>
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

    var ulmIcon = L.icon({ iconUrl: "/img/Logo_ULM.png", iconSize: [35, 35] });
    var marker = L.marker([-3.298618801108944, 114.58542404981114], { icon: ulmIcon }).addTo(map);
    marker.bindPopup('Pendidikan Komputer FKIP ULM');

</script>

@section('js')

@endsection

