@extends('dashboard.layouts.dashboard')
<style>
    #map2 {
        height: 35vh;
    }
</style>
{{-- @dd($biodata) --}}

@section('dashboard-content')
<a class="text-decoration-none btn link-tambah mb-2 " href="{{URL::previous()}}" style=" background: linear-gradient(135deg, #6a11cb, #2575fc); color:#fff"><i class="bi bi-chevron-double-left"></i> Kembali</a>
    <div class="card border-0 shadow" style="background: #fff;">
        <div class="card-body">
            <div class="row">

                <div class="col-sm-6">
                    <h4 class="fw-bold">{{ $biodata->nama }}</h4>
                    <table class="table table-borderless">
                        <tr>
                            <th>NIM</th>
                            <td>: {{ $biodata->nim }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: {{ $biodata->status }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>: {{ $biodata->telepon }}</td>
                        </tr>
                        <tr>
                            <th>Angkatan</th>
                            <td>: {{ $biodata->angkatan }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: {{ $biodata->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <th>Agama</th>
                            <td>: {{ $biodata->agama }}</td>
                        </tr>
                        <tr>
                            <th>Tempat Lahir</th>
                            <td>: {{ $biodata->tempat_lahir }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>: {{ \Carbon\Carbon::parse($biodata->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Penghasilan</th>
                            <td>: {{ $biodata->penghasilan }}</td>
                        </tr>
                        <tr>
                            <th>Sekolah Asal</th>
                            <td>: {{ optional($biodata->sekolah)->nama_sekolah ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-sm-5">
                    <h5 class="fw-bold mt-2">Alamat Lengkap</h5>
                    <p>
                        Kelurahan {{ Str::title($biodata->kelurahan ?? '-') }}<br> 
                        Kecamatan {{ Str::title($biodata->kecamatan ?? '-') }}<br>
                        Kab/Kota {{ Str::title($biodata->kabupaten) }}<br>
                        Provinsi {{ Str::title($biodata->provinsi) }}
                    </p>

                    @if($biodata->koordinat)
                        <div id="map2" class="rounded"></div>
                    @endif
                </div>
            </div>
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
