
        {{-- @dd($provinsi); --}}
@extends("GIS.layouts.app")

<style>
    #map {
        height: 85vh;
    }

    .kabupaten-label {
        font-size: 14px;
    }
</style>

@section('content')
    <h3>Persebaran Sekolah Asal Mahasiswa</h3>
    <div id="map"></div>
@endsection

@section('js')
<script>
    var map = L.map('map').setView([-2.90,115.50], 8.49);

    var ulmIcon = L.icon({
        iconUrl: "/img/Logo_ULM.png",
        iconSize: [50, 50],
    });

    var sekolah = L.icon({
        iconUrl: "/img/sekolah.png",
        iconSize: [35, 35],
    });


    var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
    });
    baseLayer.addTo(map);

    var marker = L.marker([-3.298618801108944, 114.58542404981114], {
        icon: ulmIcon
    }).addTo(map);
    marker.bindPopup('FKIP ULM'); 

    @foreach ($sekolah as $data)
        @php
            $koordinats = explode(',', $data->koordinat);
        @endphp
        
        @if (count($koordinats) === 2 && is_numeric($koordinats[0]) && is_numeric($koordinats[1]))
            var latitude = {{ $koordinats[0] }},
                longitude = {{ $koordinats[1] }};
            var popupContent = `<b>{{ $data->nama_sekolah }}</b><br>Mahasiswa:<ul>`;

            @foreach ($data->biodata as $mhs)
                popupContent += `<li>{{ $mhs->nama }}</li>`;
            @endforeach

            popupContent += `</ul>`;

            L.marker([latitude, longitude], {
                icon: sekolah
            })
            .addTo(map)
            .bindPopup(popupContent);
        @endif
    @endforeach

    let batasKabupaten = [];
    let colors = ["#32b8a6", "#f5cb11", "#eb7200", "#c461eb", "#6c7000", "#bf2e2e", "#46e39c", "#9fd40c", "#ad00f2",
        "#fffb00", "#7ff2fa", "#e8a784"
    ];
    var kabupaten = [];
    var html = ``;

    getShape("kabBanjarbaru", "Banjarbaru");
    getShape("kabBanjarmasin", "Banjarmasin");
    getShape("kabBalangan", "Kabupaten Balangan");
    getShape("kabBanjar", "Banjar");
    getShape("kabBaritoKuala", "Barito Kuala");
    getShape("kabHuluSungaiSelatan", "Hulu Sungai Selatan");
    getShape("kabHuluSungaiTengah", "Hulu Sungai Tengah");
    getShape("kabHuluSungaiUtara", "Hulu Sungai Utara");
    getShape("kabKotabaru", "Kotabaru");
    getShape("kabTabalong", "Tabalong");
    getShape("kabTanahBumbu", "Tanah Bumbu");
    getShape("kabTanahLaut", "Tanah Laut");
    getShape("kabTapin", "Tapin");

    var control2 = L.control.slideMenu("", {
        position: "topleft",
    }).addTo(map);

    var legend = L.control({
        position: "bottomright",
    });
    legend.addTo(map);

    function showKabupaten(v, i) {
        if (v.checked === true) {
            map.addLayer(batasKabupaten[i]);
            map.flyTo(batasKabupaten[i].getBounds().getCenter(), 10);
        } else {
            map.removeLayer(batasKabupaten[i]);
        }
    }

    function getShape(namaFile, kab) {
        $.getJSON('/geoJSON/' + namaFile + '.geojson', (json) => {
            html += `
                <input type="checkbox" id="chk-${kab}" onclick="showKabupaten(this, ${batasKabupaten.length})">
                <label for="chk-${kab}" style="cursor:pointer;" class="kabupaten-label">
                    <b> ${kab} </b>
                </label><br>
            `;

            let geoLayer = L.geoJSON(json, {
                style: () => {
                    return {
                        fillOpacity: 0.8,
                        weight: 3,
                        opacity: 1,
                        color: 'black',
                        fillColor: colors[batasKabupaten.length]
                    };
                }
            });

            batasKabupaten.push(geoLayer);
            kabupaten.push(geoLayer);
            control2.setContents(html);
        });
    }
</script>
@endsection