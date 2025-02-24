{{-- @dd($provinsi); --}}
@extends ("GIS.layouts.app")

@section('content')
<div class="container-home" style="height: 100vh;" >
    <div id="particles-js"></div>
    <div class="container my-auto">

        <div style="position: relative; " class="row justify-content-start align-items-center">
            <div class="col-sm-6 p-5" >
                <h1 style="color: #222e64;">Selamat Datang Di Website <span style="color: #ff9800;"> Sistem Informasi Geografis </span> <br> Persebaran Mahasiswa Pendidikan Komputer <br>Universitas Lambung Mangkurat.</h1>
                <p class="fs-5 mt-4">Mari sukseskan Pendataan <span> Mahasiswa </span> Prodi Pendidikan Komputer Universitas Lambung Mangkurat dengan mengisi biodata anda <a class="fst-italic" style="text-decoration: none;color: #ff9800" href="/login"> disini.</a> </p>
            </div>
            <div class="col-sm-6" data-aos="fade-up">
                <img class="img-fluid" style="max-height: 55vh;" src="{{asset('AdminLTE')}}/dist/img/foto2021.png" alt="">
            </div>
        </div>
    </div>
</div>
@endsection

