@extends('dashboard.layouts.dashboard')
<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('dashboard-content')
    <style>
        #map2 {
            height: 35vh;
        }
    </style>
    <div class="card border-0 shadow" style="background: #fff;">
        <div class="card-body">
            <h1>Biodata</h1>
            <form action="{{ route('store.biodata') }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    @csrf

                    <div class="col-sm-6">
                        <div class="mb-2">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" disabled
                                placeholder="Masukkan nama anda" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="mb-2">
                            <label for="nim" class="form-label">Nim</label>
                            <input type="text" class="form-control" id="nim" name="nim" disabled
                                placeholder="Masukkan nim anda" value="{{ auth()->user()->nim }}">
                        </div>
                        <div class="mb-2">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                placeholder="Masukkan no telepon" value="{{ old('telepon') }}">
                        </div>
                        <div class="mb-2">
                            <?php
                                $angkatan = str_split(auth()->user()->nim, 2);
                                $angkatan = "20".$angkatan[0];
                            ?>
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <input  type="text" class="form-control" id="angkatan" name="angkatan" value="{{ $angkatan }}" >
                        </div>

                        <div class="mb-2">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" aria-label="Default select example">
                                <option selected>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="agama" class="form-label">Agama</label>
                            <select name="agama" class="form-select" >
                                <option selected>-- Pilih Agama --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Budha">Budha</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="tempat-lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat-lahir" name="tempat_lahir" placeholder=""
                                value="{{ old('tempat_lahir') }}">
                        </div>

                        <div class="mb-2">
                            <label for="tanggal-lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal-lahir" name="tanggal_lahir"
                                placeholder="" value="{{ old('tanggal_lahir') }}">
                        </div>

                        <div class="mb-2">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <select class="form-select" id="provinsi" name="provinsi">
                                <option selected>--Pilih Provinsi--</option>
                                @foreach ($provinces as $provinsi)
                                    <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="kabupaten" class="form-label">Kota/Kabupaten</label>
                            <select class="form-select" id="kabupaten" name="kabupaten"></select>
                        </div>
                        <div class="mb-2">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select class="form-select" id="kecamatan" name="kecamatan"></select>
                        </div>
                        <div class="mb-2">
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <select class="form-select" id="kelurahan" name="kelurahan"></select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="mb-2">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto"
                                value="{{ old('foto') }}">
                        </div>

                        <div class="mb-2">
                            <label for="koordinat" class="form-label">Koordinat</label>
                            <input type="text" class="form-control mb-2" id="koordinat" name="koordinat"
                                placeholder="latitude, longitude" value="{{ old('koordinat') }}">
                            <div id="map2"></div>
                        </div>

                        <div class="mb-2">
                            <label for="penghasilan" class="form-label">Rata-Rata Penghasilan Orang Tua</label>
                            <input type="text" class="form-control" id="penghasilan" name="penghasilan"
                                placeholder="" value="{{ old('penghasilan') }}">
                        </div>

                        <div class="mb-2">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Simpan
                            </button>

                        </div>


                    </div>
            </form>

        </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        var map = L.map('map2').setView([-3.298618801108944, 114.58542404981114], 16.86);
        var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        })
        baseLayer.addTo(map);

        // get location
        var inputKoordinat = document.querySelector("#koordinat"),
            curLocation = [-3.298618801108944, 114.58542404981114]

        map.attributionControl.setPrefix(false)

        var marker = new L.marker(curLocation, {
            draggable: "true"
        });

        marker.on("dragend", (event) => {
            var position = marker.getLatLng();
            marker.setLatLng(position, {
                draggable: "true"
            }).bindPopup(position).update();
            $("#koordinat").val(`${position.lat}, ${position.lng}`).keyup();
        });

        map.addLayer(marker);

        map.on("click", (e) => {
            if (!marker) {
                marker = L.marker(e.latlng).addTo(map);
            } else {
                console.log(e.latlng)
                marker.setLatLng(e.latlng);
            }
            map.flyTo([e.latlng.lat, e.latlng.lng]);
            inputKoordinat.value = `${e.latlng.lat}, ${e.latlng.lng}`;
        })

        inputKoordinat.addEventListener("input", (e) => {
            console.log(inputKoordinat.value)
            let koord = inputKoordinat.value.split(",")
            if (!marker) {
                marker = L.marker(koord).addTo(map);
            } else {

                marker.setLatLng(new L.LatLng(koord[0], koord[1]));
                map.flyTo([koord[0], koord[1]]);

            }
        });
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(function() {
            $('#provinsi').on('change', () => {
                let id_provinsi = $('#provinsi').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('getKabupaten') }}",
                    data: {
                        id_provinsi: id_provinsi
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kabupaten').html(msg);
                        $('#kecamatan').html('');
                        $('#kelurahan').html('');
                    },
                    error: (data) => {
                        console.log('error', data)
                    }
                })
            })

            $('#kabupaten').on('change', () => {
                let id_kabupaten = $('#kabupaten').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('getKecamatan') }}",
                    data: {
                        id_kabupaten: id_kabupaten
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kecamatan').html(msg);
                        $('#kelurahan').html('');
                    },
                    error: (data) => {
                        console.log('error', data)
                    }
                })
            })

            $('#kecamatan').on('change', () => {
                let id_kecamatan = $('#kecamatan').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('getKelurahan') }}",
                    data: {
                        id_kecamatan: id_kecamatan
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kelurahan').html(msg);
                    },
                    error: (data) => {
                        console.log('error', data)
                    }
                })
            })
        })
    </script>
@endsection
