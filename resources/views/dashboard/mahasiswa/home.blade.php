@extends('dashboard.layouts.dashboard')
<style>
    #map2 {
        height: 35vh;
    }
</style>
{{-- @dd($biodata) --}}

@section('dashboard-content')
    <div class="card border-0 shadow" style="background: #fff;">
        <div class="card-body">
            @if ($biodata != null)
                <div class="row ">
                    <div class="mb-2 d-flex justify-content-end">
                        <a href="{{route('mahasiswa.edit', $biodata->nim)}}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil-square"></i> Edit Biodata</a>
                    </div>
                    <div class="col-sm-2">
                        <img src="{{ $biodata->foto ? asset('storage/' . $biodata->foto) : asset('img/noImage.png') }}"
                            class="img-fluid rounded shadow" alt="..." style="max-height: 300px">
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
                                <td style="width: 300px">{{ Str::title($biodata->province->name) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kota/Kabupaten</td>
                                <td style="width: 300px">{{ Str::title($biodata->regency->name) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kecamatan</td>
                                <td style="width: 300px">{{ Str::title($biodata->district->name) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kelurahan</td>
                                <td style="width: 300px">{{ Str::title($biodata->village->name) }}</td>
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
                    <div class="col-sm-4 d-flex flex-column justify-content-center align-items-center">
                        <h2
                            style="background: linear-gradient(135deg, #6a11cb, #2575fc);
                        -webkit-background-clip: text;
                        background-clip: text;
                        -webkit-text-fill-color: transparent;">
                            Anda belum mengisi biodata.</h2>

                        <a href="{{ route('isi.biodata') }}" class="link-tambah">Isi Biodata</a>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <div class="row mt-3">

        @if ($biodata != null)
            @if ($biodata->sekolah == null)
                <div class="col-sm-6">
                    <div class="card border-0 shadow" style="background: #fff;">

                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-sm-6">
                                    <h4 class=""
                                        style="background: linear-gradient(135deg, #6a11cb, #2575fc); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
                                        <i class="me-2 bi bi-mortarboard-fill"></i> Riwayat Pendidikan
                                    </h4>
                                    <p>Anda belum mengisi Riwayat Pendidikan.</p>

                                </div>
                                <div class="col-sm-6 d-flex justify-content-end">
                                    <a href="{{ route('isi.sekolah') }}" class="link-tambah">Isi Riwayat Pendidikan</a>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            @endif
            @if ($biodata->tempat_tinggal == null)
                <div class="col-sm-6">
                    <div class="card border-0 shadow" style="background: #fff;">

                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-sm-6">
                                    <h4 class=""
                                        style="background: linear-gradient(135deg, #6a11cb, #2575fc); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
                                        <i class="me-2 bi bi-mortarboard-fill"></i> Domisili
                                    </h4>
                                    <p>Anda belum mengisi Tempat Tinggal Domisili.</p>

                                </div>
                                <div class="col-sm-6 d-flex justify-content-end">
                                    <a href="{{ route('isi.tempat') }}" class="link-tambah">Isi Domisili</a>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            @endif
        @endif
    </div>
    </div>
@endsection
@if ($biodata != null)
    @section('js')
        <script>
            var map = L.map('map2').setView([{{ $biodata->koordinat }}], 16.86);
            var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            })
            baseLayer.addTo(map);

            // // get location
            // var inputKoordinat = document.querySelector("#koordinat"),
            //     curLocation = [{{ $biodata->koordinat }}]

            // // map.attributionControl.setPrefix(false)

            // var marker = new L.marker(curLocation, {
            //     draggable: "false"
            // });
            var marker = new L.marker([{{ $biodata->koordinat }}]);


            map.addLayer(marker);
        </script>
    @endsection
@endif
