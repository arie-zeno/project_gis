@extends ("GIS.layouts.app")
<style>
    #map {
        height: 85vh;
    }

    .kabupaten-label {
        font: 14px Arial, Helvetica, sans-serif;
    }

    .legend {
        padding: 6px 8px;
        font: 14px Arial, Helvetica, sans-serif;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        width: 200px;
        border-radius: 5px;
        line-height: 24px;
        color: #555;
    }

    .legend h4 {
        text-align: center;
        font-size: 16px;
        margin: 2px 12px 8px;
        color: #777;
    }

    .legend div {
        display: flex;
        align-items: center
    }

    .legend span {
        position: relative;
        bottom: 3px;
        color: black
    }

    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin: 0 8px 0 0;
        opacity: 0.7;
    }

    .legend i.icon {
        background-size: 18px;
        background-color: rgba(255, 255, 255, 1);
    }
</style>

@section('content')
<h3 style="text-align: center">Persebaran Daerah Asal Mahasiswa</h3>
<div id="map"></div>
@endsection

@section('js')
<script>
    var map = L.map('map').setView([-2.90, 115.50], 8.49);

    let mahasiswaMarkers = {}; // Menyimpan marker per kabupaten

    var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
    }).addTo(map);

    var ulmIcon = L.icon({ iconUrl: "/img/Logo_ULM.png", iconSize: [35, 35] });
    var mahasiswa = L.icon({ iconUrl: "/img/Mahasiswa.png", iconSize: [35, 35] });
    var alumni = L.icon({ iconUrl: "/img/Alumni.png", iconSize: [35, 35] });

    var marker = L.marker([-3.298618801108944, 114.58542404981114], { icon: ulmIcon }).addTo(map);
    marker.bindPopup('FKIP ULM');

    function tampilkanSemuaMahasiswa() {
        Object.keys(mahasiswaMarkers).forEach(kab => {
            mahasiswaMarkers[kab].forEach(marker => marker.addTo(map));
        });
    }
    
    function sembunyikanSemuaMahasiswa() {
        Object.keys(mahasiswaMarkers).forEach(kab => {
            mahasiswaMarkers[kab].forEach(marker => map.removeLayer(marker));
        });
    }

    @foreach ($biodata as $data)
        @php
            $koordinats = explode(',', $data['koordinat']);
            $kabupaten = strtoupper($data['kabupaten']); // Pastikan ini cocok dengan `label` di kabupatenList
        @endphp
        @if (count($koordinats) >= 2)
            var latitude = {{ $koordinats[0] }},
                longitude = {{ $koordinats[1] }},
                kabupaten = "{{ $kabupaten }}";
            var icon = '{{ $data['status'] == 'Lulus' ? 'alumni' : 'mahasiswa' }}';

            if (!mahasiswaMarkers[kabupaten]) mahasiswaMarkers[kabupaten] = [];

            var marker = L.marker([latitude, longitude], {
                icon: (icon === 'alumni') ? alumni : mahasiswa
            }).bindPopup(`Nama : {{ $data->nama }}`);
            
            mahasiswaMarkers[kabupaten].push(marker);
        @endif
    @endforeach

    tampilkanSemuaMahasiswa();

    // Tambahkan semua marker mahasiswa saat pertama kali halaman diakses
//     Object.keys(mahasiswaMarkers).forEach(kab => {
//         mahasiswaMarkers[kab].forEach(marker => marker.addTo(map));
//    });



    let batasKabupaten = [];
    let html = ``;
    let colors = ["#32b8a6", "#f5cb11", "#eb7200", "#c461eb", "#6c7000", "#bf2e2e", "#46e39c", "#9fd40c", "#ad00f2",
        "#fffb00", "#7ff2fa", "#e8a784"
    ];

    const kabupatenList = [
        { namaFile: 'kabBanjarbaru', label: 'BANJARBARU' },
        { namaFile: 'kabBanjarmasin', label: 'BANJARMASIN' },
        { namaFile: 'kabBalangan', label: 'BALANGAN' },
        { namaFile: 'kabBanjar', label: 'BANJAR' },
        { namaFile: 'kabBaritoKuala', label: 'BARITO KUALA' },
        { namaFile: 'kabHuluSungaiSelatan', label: 'HULU SUNGAI SELATAN' },
        { namaFile: 'kabHuluSungaiTengah', label: 'HULU SUNGAI TENGAH' },
        { namaFile: 'kabHuluSungaiUtara', label: 'HULU SUNGAI UTARA' },
        { namaFile: 'kabKotabaru', label: 'KOTABARU' },
        { namaFile: 'kabTabalong', label: 'TABALONG' },
        { namaFile: 'kabTanahBumbu', label: 'TANAH BUMBU' },
        { namaFile: 'kabTanahLaut', label: 'TANAH LAUT' },
        { namaFile: 'kabTapin', label: 'TAPIN' },
    ];

    var control2 = L.control.slideMenu("", {
        position: "topleft",
    }).addTo(map);

    kabupatenList.forEach((item, index) => {
        getShape(item.namaFile, item.label, index);
    });

    function getShape(namaFile, kab, index) {
        $.getJSON('/geoJSON/' + namaFile + '.geojson', (json) => {
            html += `
                <div style="margin-bottom: 7px;">
                <input type="checkbox" id="chk-${index}" onclick="showKabupaten(this, ${index})">
                <label for="chk-${index}" class="kabupaten-label" style="cursor:pointer;">
                    <b>${kab}</b>
                </label>
                </div>
            `;

            let geoLayer = L.geoJSON(json, {
                style: {
                    fillOpacity: 0.5,
                    weight: 1,
                    color: 'black',
                    fillColor: colors[index % colors.length]
                }
            });

            batasKabupaten[index] = geoLayer;
            control2.setContents(html);
        });
    }

    function showKabupaten(v, i) {
        const kabupatenName = kabupatenList[i].label;

        if (v.checked) {
            map.addLayer(batasKabupaten[i]);
            map.flyTo(batasKabupaten[i].getBounds().getCenter(), 10);

            // Sembunyikan semua marker
            sembunyikanSemuaMahasiswa();

            // Tampilkan hanya marker kabupaten ini
            if (mahasiswaMarkers[kabupatenName]) {
                mahasiswaMarkers[kabupatenName].forEach(marker => marker.addTo(map));
            }
        } else {
            map.removeLayer(batasKabupaten[i]);

            // Cek apakah tidak ada yang dicentang
            const tidakAdaYangDicek = kabupatenList.every((_, idx) => !document.getElementById(`chk-${idx}`).checked);

            if (tidakAdaYangDicek) {
                // Tampilkan semua mahasiswa jika tidak ada kabupaten yang dicek
                tampilkanSemuaMahasiswa();
            } else {
                // Hanya hapus marker kabupaten yang di-uncheck
                if (mahasiswaMarkers[kabupatenName]) {
                    mahasiswaMarkers[kabupatenName].forEach(marker => map.removeLayer(marker));
                }
            }
        }
    }

    var legend = L.control({ position: "bottomright" });

    legend.onAdd = function(map) {
        var div = L.DomUtil.create("div", "legend");
        div.innerHTML += "<h6>Keterangan : </h6>";
        div.innerHTML += '<div><img src="/img/Logo_ULM.png" width="25"><span> : FKIP ULM</span></div>';
        div.innerHTML += '<div><img src="/img/alumni.png" width="30"><span> : Alumni</span></div>';
        div.innerHTML += '<div><img src="/img/mahasiswa.png" width="30"><span> : Mahasiswa Aktif</span></div>';
    
        return div;
    };
    legend.addTo(map);
</script>
@endsection
