{{-- @dd($provinsi);
@extends ("GIS.layouts.app")

@section('content')
<div class="container-home" style="height: 80vh;" >
    <div class="container my-auto">

        <div style="position: relative; " class="row justify-content-start align-items-center">
            <div class="col-sm-6 p-3" >
                <h1 style="color: #222e64;">Selamat Datang Di Website <span style="color: #ff9800;"> Sistem Informasi Geografis </span> <br> Persebaran Mahasiswa Pendidikan Komputer <br>Universitas Lambung Mangkurat.</h1>
                <p class="fs-5 mt-4">Mari sukseskan Pendataan <span> Mahasiswa </span> Prodi Pendidikan Komputer Universitas Lambung Mangkurat dengan mengisi biodata anda <a class="fst-italic" style="text-decoration: none;color: #ff9800" href="/login"> disini.</a> </p>
            </div>
            <div class="col-sm-6" data-aos="fade-up">
                <img class="img-fluid" style="max-height: 55vh;" src="{{asset('AdminLTE')}}/dist/img/foto2021.png" alt="">
            </div>
        </div>
    </div>
</div>
@endsection --}}


{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GIS Mahasiswa PILKOM</title>
  <link rel="stylesheet" href="style.css" />
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
    height: 2000px;
    background: #fff;
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
      <a href="/statistik"> Statistik</a>  --}}
      {{-- <span>GIS Mahasiswa PILKOM</span> --}}
    {{-- </div>
  </nav>

  <header class="hero">
    <div class="hero-overlay">
      <h1>GIS Persebaran<br>Mahasiswa PILKOM</h1>
      <p>
        Creating brighter opportunities for public school students<br>
        with super-efficient land administration
      </p>
    </div>
  </header>

  <div class="content">
    <h2>Scroll Down</h2>
    <p>Konten panjang di sini biar kamu bisa lihat navbarnya tetap muncul dan transparan saat scroll.</p>
  </div>

</body>
</html> --}}



<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

{{-- cluster --}}
<link rel="stylesheet" href="js/Leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="/js/Leaflet.markercluster/dist/MarkerCluster.Default.css" />
<script src="/js/Leaflet.markercluster/dist/leaflet.markercluster-src.js"></script>
<link rel="stylesheet" href="/js/treeLayer/L.Control.Layers.Tree.css">
<script src="/js/treeLayer/L.Control.Layers.Tree.js"></script>

<div class="container pt-5 pb-5">
    <div class="row justify-content-md-center">
        <input id="search" type="search" style="width: 350px">
        <button type="button" class="ml-5 btn btn-primary" id="search-button">Search</button>
    </div>
    <div class="row mt-5">
        <ul id="result-list" class="col-4 list-group"></ul>
        <div class="col-8">
            <div id="map" style="height: 75vh"></div>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('search'),
          resultList = document.getElementById('result-list'),
          mapContainer = document.getElementById('map'),
          currentMarkers = [];

    
    var map = L.map('map').setView([-3.298618801108944, 114.58542404981114], 13.46);
        
    var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
        })
        baseLayer.addTo(map);

        document.getElementById('search-button').addEventListener('click', () => {
            const query = searchInput.value.trim();
            if (!query) {
                alert("Masukkan alamat terlebih dahulu.");
                return;
            }

            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query))
                .then(result => result.json())
                .then(parsedResult => {
                    setResultList(parsedResult);
                })
                .catch(error => {
                    console.error('Gagal fetch:', error);
                    alert("Gagal mengambil data. Coba lagi nanti.");
                });
        });

    function setResultList(parsedResuld) {
        resultList.innerHTML = "";
        for (const marker of currentMarkers) {
            map.removeLayer(marker);
        }
        currentMarkers.length = 0;
        for (const result of parsedResuld) {
            const li = document.createElement('li');
            li.classList.add('list-group-item', 'list-group-item-action');
            li.innerHTML = JSON.stringify({
                displayName: result.display_name,
                lat : result.lat,
                long : result.lon
            }, undefined, 2);
            li.addEventListener('click', (event) => {
                for(const child of resultList.children) {
                    child.classList.remove('active');
                }
                event.target.classList.add('active');
                const clickedData = JSON.parse(event.target.innerHTML);
                const position = new L.LatLng(clickedData.lat, clickedData.lon);
                map.flyTo(position, 10);
            });
            const position = new L.LatLng(result.lat, result.lon);
            const marker = new L.marker(position).addTo(map);
            currentMarkers.push(marker);
            resultList.appendChild(li);
        }
    }

</script>

