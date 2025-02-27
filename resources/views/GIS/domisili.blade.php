{{-- @dd($provinsi); --}}
@extends ("GIS.layouts.app")
<style>
    #map {
        height: 85vh;
    }

    .kabupaten-label {
        font-size: 14px;
        /* Ukuran lebih kecil */
    }


</style>
@section('content')
    <h3>Persebaran Domisili Mahasiswa</h3>
    <div id="map"></div>
@endsection

@section('js')
    <script>
        // basemap
        var map = L.map('map').setView([-3.298618801108944, 114.58542404981114], 13.46);
        // map.on('contextmenu', () => {
        //     map.off();
        //   })
        // icon marker
        var ulmIcon = L.icon({
            iconUrl: "/img/Logo_ULM.png",
            iconSize: [50, 50], // size of the icon
            // iconAnchor:   [24, 24], // point of the icon which will correspond to marker's location
            // shadowAnchor: [4, 62],  // the same for the shadow
            // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        var manIcon = L.icon({
            iconUrl: "/img/icon_man.png",
            iconSize: [50, 50],
        });

        var ceweIcon = L.icon({
            iconUrl: "/img/icon_cewe.png",
            iconSize: [70, 70],
        });

        var cowoIcon = L.icon({
            iconUrl: "/img/icon_cowo.png",
            iconSize: [70, 70],
        });



        //     L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
        // maxZoom: 20,
        // subdomains:['mt0','mt1','mt2','mt3']

        //     }).addTo(map);

        var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
        })
        baseLayer.addTo(map);

        //   var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);



        var marker = L.marker([-3.298618801108944, 114.58542404981114], {
            icon: ulmIcon
        }).addTo(map);
        marker.bindPopup('FKIP ULM');


        @foreach ($biodata as $data)
            var fotoIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; border: 3px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5); background: url({{ asset('storage/' . $data->biodata->foto) }}) center/cover;"></div>',
                iconSize: [50, 50], // Ukuran ikon (lebar, tinggi)
                iconAnchor: [25, 50], // Titik jangkar (agar bagian bawah ikon berada di titik koordinat)
                popupAnchor: [0, -50] // Posisi popup relatif terhadap ikon
            
            });
            @php
                $koordinats = explode(',', $data['koordinat']);
            @endphp
            var latitude = {{ $koordinats[0] }},
                longitude = {{ $koordinats[1] }}

            L.marker([latitude, longitude], {
                    icon: fotoIcon
                })

                .addTo(map)

                .bindPopup(
                    `Nama : {{ $data->biodata->nama }} <br>
                    `);
        @endforeach

        // GeoJSON
        let batasKabupaten = [];
        let sub = [];
        let colors = ["#32b8a6", "#f5cb11", "#eb7200", "#c461eb", "#6c7000", "#bf2e2e", "#46e39c", "#9fd40c", "#ad00f2",
            "#fffb00", "#7ff2fa", "#e8a784"
        ];

        var kabupaten = [];
        var listKabupaten = [];
        var html = ``;

        getShape("kabBanjarbaru", "Kota Banjarbaru");
        getShape("kabBanjarmasin", "Kota Banjarmasin");
        getShape("kabBalangan", "Kabupaten Balangan");
        getShape("kabBanjar", "Kabupaten Banjar");
        getShape("kabBaritoKuala", "Kabupaten Barito Kuala");
        getShape("kabHuluSungaiSelatan", "Kabupaten Hulu Sungai Selatan");
        getShape("kabHuluSungaiTengah", "Kabupaten Hulu Sungai Tengah");
        getShape("kabHuluSungaiUtara", "Kabupaten Hulu Sungai Utara");
        getShape("kabKotabaru", "Kabupaten Kotabaru");
        getShape("kabTabalong", "Kabupaten Tabalong");
        getShape("kabTanahBumbu", "Kabupaten Tanah Bumbu");
        getShape("kabTanahLaut", "Kabupaten Tanah Laut");
        getShape("kabTapin", "Kabupaten Tapin");


        var control2 = L.control.slideMenu("", {
            position: "topleft",
        }).addTo(map);

        var legend = L.control({
            position: "bottomright",
        });

        legend.addTo(map);

        // Fungsi untuk menampilkan atau menyembunyikan kabupaten dengan checkbox
        function showKabupaten(v, i) {
            if (v.checked === true) {
                map.addLayer(batasKabupaten[i]);
                map.flyTo(batasKabupaten[i].getBounds().getCenter(), 10); // Fokus ke kabupaten
            } else {
                map.removeLayer(batasKabupaten[i]);
            }
        }

        function getShape(namaFile, kab) {
            $.getJSON('/geoJSON/' + namaFile + '.geojson', (json) => {
                html += `
                <input type="checkbox" id="chk-${kab}" onclick="showKabupaten(this, ${batasKabupaten.length})">
                <label for="chk-${kab}" style="cursor:pointer;" class="kabupaten-label"">
                    <b> ${kab} </b>
                </label>
                <br>
            `;

                let geoLayer = L.geoJSON(json, {
                    style: (feature) => {
                        return {
                            fillOpacity: 0.8,
                            weight: 3,
                            opacity: 1,
                            color: 'black', // Garis tepi hitam
                            fillColor: colors[batasKabupaten.length] // Warna kabupaten tetap
                        };
                    }
                });

                batasKabupaten.push(geoLayer);
                kabupaten.push(geoLayer);

                // JANGAN tambahkan layer secara default agar tidak muncul di awal
                // map.addLayer(geoLayer); // Dihapus supaya awalnya tidak tampil

                control2.setContents(html);
            });
        }
    </script>
@endsection
