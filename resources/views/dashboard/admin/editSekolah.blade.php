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
            <h3>Edit Sekolah</h3>
            <form action="{{ route('update.sekolah') }}" method="POST">
                <div class="row">
                    @csrf

                    <div class="col-sm-12">

                        <div class="sekolah">

                            <div class="mb-2">
                                <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah"
                                    placeholder="Masukkan nama sekolah" value="{{$sekolah->nama_sekolah}}">
                            </div>

                            <div class="mb-2">
                                <label for="jenis" class="form-label">Jenis Sekolah</label>
                                <select class="form-select" name="jenis">
                                    <option selected value="{{$sekolah->jenis}}">{{$sekolah->jenis}}</option>
                                    <option value="SMK">SMK</option>
                                    <option value="SMA">SMA</option>
                                    <option value="MA">MA</option>
                                    <option value="Paket C">Paket C</option>
                                    <option value="lainnya">lainnya</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="status" class="form-label">Status Sekolah</label>
                                <select class="form-select" name="status">
                                    <option selected value="{{$sekolah->status}}">{{$sekolah->status}}</option>
                                    <option value="Negeri">Negeri</option>
                                    <option value="Swasta">Swasta</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="koordinat" class="form-label">koordinat</label>
                                <input type="text" class="form-control mb-2" id="koordinat" name="koordinat"
                                    placeholder="latitude, longitude" value="{{ $sekolah->koordinat }}">
                                <div id="map2"></div>
                            </div>

                            <input type="hidden" name="id" value="{{ $sekolah->id }}">
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
        var map = L.map('map2').setView([{{$sekolah->koordinat}}], 16.86);
        var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        })
        baseLayer.addTo(map);

        // get location
        var inputKoordinat = document.querySelector("#koordinat"),
            curLocation = [{{$sekolah->koordinat}}]

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
