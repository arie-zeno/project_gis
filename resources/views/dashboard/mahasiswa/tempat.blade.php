{{-- @dd($biodata) --}}
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
                @if ($biodata->tempat_tinggal != null)
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="{{ $biodata->foto ? asset('storage/' . $biodata->foto) : asset('img/il_1.svg') }}"
                                class="img-fluid rounded shadow" alt="..." style="max-height: 300px">
                        </div>
                        <div class="col-sm-4 d-flex flex-column justify-content-center">
                            <h2 class="fw-light">{{ $biodata->nama }}</h2>
                            <h5 class="fw-light mb-4">{{ $biodata->nim }} </h5>
                            <table>


                                <tr>
                                    <td class="fw-bold" style="width: 200px">Provinsi</td>
                                    <td style="width: 300px">{{ Str::title($biodata->tempat_tinggal->province->name) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="width: 200px">Kota/Kabupaten</td>
                                    <td style="width: 300px">{{ Str::title($biodata->tempat_tinggal->regency->name) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="width: 200px">Kecamatan</td>
                                    <td style="width: 300px">{{ Str::title($biodata->tempat_tinggal->district->name) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="width: 200px">Kelurahan</td>
                                    <td style="width: 300px">{{ Str::title($biodata->tempat_tinggal->village->name) }}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-sm-6">
                            <div id="map2" class="rounded"></div>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow" style="background: #fff;">
                        <div class="card-body">
                            <h2>Anda belum mengisi tempat tinggal domisili, <a href="{{ route('isi.tempat') }}">isi domisili</a></h2>
                        </div>
                    </div>
                @endif
            @else
                <div class="card border-0 shadow" style="background: #fff;">
                    <div class="card-body">
                        <h2>Anda belum mengisi biodata, <a href="{{ route('isi.biodata') }}">isi biodata</a></h2>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@if ($biodata != null)
    @if ($biodata->tempat_tinggal != null)
        @section('js')
            <script>
                var map = L.map('map2').setView([{{ $biodata->tempat_tinggal->koordinat }}], 16.86);
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
                var marker = new L.marker([{{ $biodata->tempat_tinggal->koordinat }}]);


                map.addLayer(marker);
            </script>
        @endsection
    @endif
@endif
