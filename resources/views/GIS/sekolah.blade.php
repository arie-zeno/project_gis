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
    <h3>Persebaran Asal Sekolah Mahasiswa</h3>
    <div id="map"></div>
@endsection

@section('js')
<script>
    var map = L.map('map').setView([-2.90,115.50], 8.49);

    var ulmIcon = L.icon({
        iconUrl: "/img/Logo_ULM.png",
        iconSize: [50, 50],
    });

    var manIcon = L.icon({
        iconUrl: "/img/school_icon.png",
        iconSize: [50, 50],
    });

    var ceweIcon = L.icon({
        iconUrl: "/img/sekolah.png",
        iconSize: [35, 35],
    });

    var cowoIcon = L.icon({
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

    @foreach ($biodata as $data)
        @php
            $koordinats = explode(',', $data['koordinat']);
        @endphp
        @if (count($koordinats) === 2 && is_numeric($koordinats[0]) && is_numeric($koordinats[1]))
            var latitude = {{ $koordinats[0] }},
                longitude = {{ $koordinats[1] }};
            @if ($data['jenis_kelamin'] == 'laki-laki')
                var icon = cowoIcon;
            @else
                var icon = ceweIcon;
            @endif

            L.marker([latitude, longitude], {
                    icon: icon
                })
                .addTo(map)
                .bindPopup(`{{ $data['nama_sekolah'] }}`);
        @endif
    @endforeach

    let batasKabupaten = [];
    let colors = ["#32b8a6", "#f5cb11", "#eb7200", "#c461eb", "#6c7000", "#bf2e2e", "#46e39c", "#9fd40c", "#ad00f2",
        "#fffb00", "#7ff2fa", "#e8a784"
    ];
    var kabupaten = [];
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
