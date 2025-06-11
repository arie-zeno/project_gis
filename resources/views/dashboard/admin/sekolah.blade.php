@extends('dashboard.layouts.dashboard')
<style>
    #map2 {
        height: 35vh;
    }
</style>
@section('dashboard-content')
    <div class="row">

        <div class="col-sm-12">
            <div class="card border-0 shadow" style="background: #fff;">
                <div class="card-body">
                    <div id="toolbar">
                        <a href="{{ route('tambah.sekolah') }}" class=" btn btn-sm  btn-outline-primary"> <i
                                class="bi bi-person-plus-fill"></i>
                            Tambah Sekolah</a>

                        <button class=" btn btn-sm  btn-outline-success" type="button" data-bs-toggle="modal"
                            data-bs-target="#importSekolah"> <i class="bi bi-file-excel-fill"></i>
                            Import Sekolah</button>

                    </div>

                    <table data-toggle="table" data-search="true" data-toolbar="#toolbar">
                        <thead>
                            <tr class="text-center">
                                <th>Nama Sekolah</th>
                                <th>Jenis Sekolah</th>
                                <th>Status Sekolah</th>
                                <th>Koordinat</th>
                                <th>Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sekolah as $item)
                                <tr>
                                    <td>{{ $item->nama_sekolah }}</td>
                                    <td class="text-center">{{ $item->jenis }}</td>
                                    <td class="text-center">{{ $item->status }}</td>
                                    <td class="text-center">
                                         @if ($item->koordinat)
                                            <i
                                                class="bi {{ $item->koordinat != null ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }} "></i>
                                        @else
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('hapus.sekolah', $item->id) }}" data-confirm-delete="true"
                                            class="btn btn-sm btn-outline-danger btn-hapus">Hapus</a>

                                        <a href="{{ route('edit.sekolah', $item->id) }}"
                                            class="btn btn-sm btn-outline-info">Edit</a>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <!-- Tampilkan pagination -->
                    </table>


                </div>
                <div class="px-4">

                    {{ $sekolah->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Import Sekolah -->
    <div class="modal fade" id="importSekolah" tabindex="-1" aria-labelledby="importSekolahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importSekolahLabel">Import Sekolah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import.sekolah') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Upload File</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="file">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        function buttons() {
            return {
                btnUsersAdd: {
                    text: 'Highlight Users',
                    icon: 'bi-arrow-down',
                    event: function() {
                        alert('Do some stuff to e.g. search all users which has logged in the last week')
                    },
                    attributes: {
                        title: 'Search all users which has logged in the last week'
                    }
                },
                btnAdd: {
                    text: 'Add new row',
                    icon: 'bi-arrow-clockwise',
                    event: function() {
                        alert('Do some stuff to e.g. add a new row')
                    },
                    attributes: {
                        title: 'Add a new row to the table'
                    }
                }
            }

        }

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
@endsection
