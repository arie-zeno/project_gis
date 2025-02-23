@extends('dashboard.layouts.dashboard')
<style>
    #map2 {
        height: 35vh;
    }
</style>
@section('dashboard-content')
    <div class="card border-0 shadow" style="background: #fff;">
        <div class="card-body">
            @if ($biodata != null)
                <div class="row">
                    <div class="col-sm-2">
                        <img src="{{ $biodata->foto ? asset('storage/'.$biodata->foto) : asset('img/il_1.svg') }}" class="img-fluid rounded shadow" alt="..." style="max-height: 300px">
                    </div>
                    <div class="col-sm-4 d-flex flex-column justify-content-center">
                        <h2 class="fw-light">{{ $biodata->nama }}</h2>
                        <h5 class="fw-light mb-4">{{ $biodata->nim }} </h5>
                        <table>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Angkatan</td>
                                <td style="width: 300px">{{ $biodata->angkatan }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Provinsi</td>
                                <td style="width: 300px">{{ $biodata->provinsi }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kabupaten/Kota</td>
                                <td style="width: 300px">{{ $biodata->kabupaten }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kecamatan</td>
                                <td style="width: 300px">{{ $biodata->kecamatan }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kelurahan</td>
                                <td style="width: 300px">{{ $biodata->kelurahan }}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-sm-6">
                        <div id="map2" class="rounded"></div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-sm-4">
                        <img height="300" class="" src="/img/il_1.svg" alt="">
                    </div>
                    <div class="col-sm-4 d-flex  align-items-center">
                        <h2
                            style="background: linear-gradient(135deg, #6a11cb, #2575fc);
                        -webkit-background-clip: text;
                        background-clip: text;
                        -webkit-text-fill-color: transparent;">
                            Anda belum mengisi biodata.</h2>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="card border-0 shadow" style="background: #fff;">

                <div class="card-body">
                    @if ($biodata == null)
                        <div class="row align-items-center justify-content-between">
                            <div class="col-sm-6">
                                <h4 class=""
                                    style="background: linear-gradient(135deg, #6a11cb, #2575fc); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
                                    <i class="me-2 bi bi-person-fill"></i> Biodata Pribadi
                                </h4>
                                <p>Anda belum mengisi Biodata Pribadi.</p>

                            </div>
                            <div class="col-sm-6 d-flex justify-content-end">
                                <a href="{{ route('isi.biodata') }}" class="link-tambah">Isi Biodata</a>

                            </div>

                        </div>
                    @else
                        <h4 class=""
                            style="background: linear-gradient(135deg, #6a11cb, #2575fc); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
                            <i class="me-2 bi bi-person-fill"></i> Biodata Pribadi
                        </h4>
                        <h3>{{$biodata->nama}}</h3>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card border-0 shadow" style="background: #fff;">

                <div class="card-body">
                    <h4 style="background: linear-gradient(135deg, #6a11cb, #2575fc);
    -webkit-background-clip: text;
            background-clip: text;
    -webkit-text-fill-color: transparent;"
                        class=""><i class="me-2 bi bi-mortarboard-fill"></i> Riwayat Pendidikan</h4>
                    <p>Ini adalah halaman utama dashboard Anda</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@if($biodata != null)
@section('js')
    <script>
        var map = L.map('map2').setView([{{$biodata->koordinat}}], 16.86);
        var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        })
        baseLayer.addTo(map);

        // // get location
        // var inputKoordinat = document.querySelector("#koordinat"),
        //     curLocation = [{{$biodata->koordinat}}]

        // // map.attributionControl.setPrefix(false)

        // var marker = new L.marker(curLocation, {
        //     draggable: "false"
        // });
        var marker = new L.marker([{{$biodata->koordinat}}]);

    
        map.addLayer(marker);

   
        
    </script>
@endsection
@endif