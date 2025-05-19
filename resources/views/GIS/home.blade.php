{{-- @dd($provinsi); --}}
{{-- @extends ("GIS.layouts.app")

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


<!DOCTYPE html>
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
      <a href="/statistik"> Statistik</a> 
      {{-- <span>GIS Mahasiswa PILKOM</span> --}}
    </div>
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
</html>


