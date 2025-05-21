@extends ("GIS.layouts.app")

<style>
    #map {
        height: 85vh;
    }

    .kabupaten-label {
        font: 14px Arial, Helvetica, sans-serif;
    }

    .legend {
        padding: 6px px;
        font: 14px Arial, Helvetica, sans-serif;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        width: 250px;
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

    .label-kabupaten {
        font-family: 'Segoe UI', Verdana, sans-serif;
        font-size: 13px;
        color: black; /* atau ubah sesuai keinginan agar kontras */
        background-color: transparent;
        padding: 0;
        border-radius: 0;
        box-shadow: none;
        white-space: nowrap;
        text-align: center;
        border: none !important;
        box-shadow: none !important;
        color: black; /* Atau sesuaikan warna teks */
        font-weight: bold;
        padding: 0 !important;
        
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 2px 0;
        padding: 4px 6px;
        border-radius: 4px;
        transition: background-color 0.2s ease;
    }

    .checkbox-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .checkbox-item input[type="checkbox"] {
        transform: scale(1.1);
        cursor: pointer;
    }

    .checkbox-item label {
        font-size: 10px;
        font-family: Arial, Helvetica, sans-serif;
        color: #333;
        cursor: pointer;
        user-select: none;
        line-height: 1.2;
    }

    .checkbox-item.all-kabupaten {
        border-bottom: 1px solid #ccc;
        margin-bottom: 4px;
        padding-bottom: 4px;
        background-color: white;
        z-index: 10;
    }

</style>

@section('content')
<h3 style="text-align: center">Persebaran Daerah Asal Mahasiswa</h3>
<div id="map"></div>
@endsection

@php
    $data = collect($biodata);
    $jumlahAlumni = $data->where('status', 'Lulus')->count();
    $jumlahMahasiswa = $data->where('status', '!=', 'Lulus')->count();
@endphp
@section('js')
<script>
    var map = L.map('map').setView([-2.90, 115.20], 8.499);
    let mahasiswaMarkers = {}; // marker mahasiswa per kabupaten
    let batasKabupaten = [], labelLayers = [], html = "";

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

    const labelKabupaten = {
        "BANJARBARU": [-3.442, 114.844],
        "BANJARMASIN": [-3.319, 114.590],
        "BALANGAN": [-2.336, 115.615],
        "BANJAR": [-3.477, 115.003],
        "BARITO KUALA": [-2.988, 114.732],
        "HULU SUNGAI SELATAN": [-2.779, 115.215],
        "HULU SUNGAI TENGAH": [-2.583, 115.519],
        "HULU SUNGAI UTARA": [-2.435, 115.003],
        "KOTABARU": [-3.298, 116.225],
        "TABALONG": [-2.129, 115.375],
        "TANAH BUMBU": [-3.460, 115.564],
        "TANAH LAUT": [-3.809, 114.846],
        "TAPIN": [-2.956, 115.020]
    };

    var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
    }).addTo(map);

    var ulmIcon = L.icon({ iconUrl: "/img/Logo_ULM.png", iconSize: [35, 35] });
    var mahasiswa = L.icon({ iconUrl: "/img/mahasiswa.png", iconSize: [35, 35] });
    var alumni = L.icon({ iconUrl: "/img/alumni.png", iconSize: [35, 35] });

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
            $kabupaten = strtoupper($data['kabupaten']);
        @endphp
        @if (count($koordinats) >= 2)
            var lat = {{ $koordinats[0] }},
                lng = {{ $koordinats[1] }},
                kab = "{{ $kabupaten }}";
            var icon = '{{ $data['status'] == 'Lulus' ? 'alumni' : 'mahasiswa' }}';

            if (!mahasiswaMarkers[kab]) mahasiswaMarkers[kab] = [];

            var marker = L.marker([lat, lng], {
                icon: (icon === 'alumni') ? alumni : mahasiswa
            }).bindPopup(`{{ $data->nama }}`);

            mahasiswaMarkers[kab].push(marker);
        @endif
    @endforeach

    tampilkanSemuaMahasiswa();

    // Label permanen kabupaten
    Object.entries(labelKabupaten).forEach(([nama, koordinat]) => {
        L.tooltip({
            permanent: true,
            direction: 'center',
            className: 'label-kabupaten',
            offset: [0, 0],
            interactive: false
        }).setLatLng(koordinat).setContent(nama).addTo(map);
    });

    // Kontrol checkbox kabupaten
    var control2 = L.control.slideMenu("", { position: "topleft" }).addTo(map);

    let colors = ["#32b8a6", "#f5cb11", "#eb7200", "#c461eb", "#6c7000", "#bf2e2e", "#46e39c", "#9fd40c", "#ad00f2",
        "#fffb00", "#7ff2fa", "#e8a784"
    ];

    let htmlHeader = `
            <div class="checkbox-item all-kabupaten">
                <input type="checkbox" id="chk-all" onclick="toggleAllKabupaten(this)">
                <label for="chk-all"><b>SEMUA KOTA/KABUPATEN</b></label>
            </div>
            `;

    kabupatenList.forEach((item, index) => {
        getShape(item.namaFile, item.label, index);
    });

    function getShape(namaFile, kab, index) {
        $.getJSON('/geoJSON/' + namaFile + '.geojson', (json) => {
            html += `
                <div class="checkbox-item">
                    <input type="checkbox" id="chk-${index}" onclick="showKabupaten(this, ${index})">
                    <label for="chk-${index}"><b>${kab}</b></label>
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

            let koordinat = labelKabupaten[kab];
            let label = L.tooltip({
                permanent: true,
                direction: 'center',
                className: 'label-kabupaten',
                offset: [0, 0]
            }).setLatLng(koordinat).setContent(kab);

            batasKabupaten[index] = geoLayer;
            labelLayers[index] = label;

            control2.setContents(`
                <div style="width: 230px;">
                    ${htmlHeader}
                    <div style="max-height: 250px; overflow-y: auto;">
                        ${html}
                    </div>
                    <div id="info-kabupaten" style="margin-top:10px; font-size:12px; padding:5px; background:#f9f9f9; border:1px solid #ccc; border-radius:4px;">
                        <b>Info Kabupaten:</b><br><span>Pilih salah satu kabupaten/kota</span>
                    </div>
                </div>
            `);
        });
    }
    

    function showKabupaten(v, i) {
        if (v.checked) {
            map.addLayer(batasKabupaten[i]);
            map.addLayer(labelLayers[i]);
            map.flyTo(batasKabupaten[i].getBounds().getCenter(), 10);

        } else {
            map.removeLayer(batasKabupaten[i]);
            map.removeLayer(labelLayers[i]);
        }

        sembunyikanSemuaMahasiswa();

        let semuaChecked = true;
        let adaYangDicek = false;

        kabupatenList.forEach((item, idx) => {
            const checkbox = document.getElementById(`chk-${idx}`);
            if (checkbox.checked) {
                adaYangDicek = true;
                if (mahasiswaMarkers[item.label]) {
                    mahasiswaMarkers[item.label].forEach(marker => marker.addTo(map));
                }
            } else {
                semuaChecked = false;
            }
        });

        // Update status checkbox "Semua Kota/Kabupaten"
        document.getElementById("chk-all").checked = semuaChecked;

        if (!adaYangDicek) {
            tampilkanSemuaMahasiswa();
        }
        updateInfoKabupaten();

    }

    function toggleAllKabupaten(checkbox) {
        let isChecked = checkbox.checked;

        kabupatenList.forEach((item, index) => {
            const kabCheckbox = document.getElementById(`chk-${index}`);
            kabCheckbox.checked = isChecked;
            showKabupaten(kabCheckbox, index);
        });
        updateInfoKabupaten();
    }

    function updateInfoKabupaten() {
        let infoDiv = document.getElementById("info-kabupaten");
        let totalMahasiswa = 0, totalAlumni = 0;
        let selectedKab = [];

        kabupatenList.forEach((item, idx) => {
            const checkbox = document.getElementById(`chk-${idx}`);
            if (checkbox.checked) {
                selectedKab.push(item.label);
                if (mahasiswaMarkers[item.label]) {
                    mahasiswaMarkers[item.label].forEach(marker => {
                        if (marker.options.icon.options.iconUrl.includes("alumni")) {
                            totalAlumni++;
                        } else {
                            totalMahasiswa++;
                        }
                    });
                }
            }
        });

        if (selectedKab.length === 0) {
            infoDiv.innerHTML = `<b>Info Kabupaten:</b><br><span>Pilih salah satu kabupaten/kota</span>`;
        } else {
            infoDiv.innerHTML = `
                <b>Info Kabupaten:</b><br>
                <span><b>Kabupaten/Kota:</b> ${selectedKab.join(', ')}</span><br>
                <span><b>Mahasiswa Aktif:</b> ${totalMahasiswa}</span><br>
                <span><b>Alumni:</b> ${totalAlumni}</span><br>
                <span><b>Total:</b> ${totalMahasiswa + totalAlumni}</span>
            `;
        }
    }



    // Legenda
    var legend = L.control({ position: "bottomright" });

    const jumlahAlumni = {{ $jumlahAlumni }};
    const jumlahMahasiswa = {{ $jumlahMahasiswa }};
    const total = {{ $jumlahMahasiswa }} + {{ $jumlahAlumni }};
    
    legend.onAdd = function(map) {
        var div = L.DomUtil.create("div", "legend");
        div.innerHTML += "<h6>Keterangan : </h6>";
        div.innerHTML += `<div><img src="/img/Logo_ULM.png" width="25"><span> : Pendidikan Komputer (${total} orang)</span></div>`;
        div.innerHTML += `<div><img src="/img/alumni.png" width="30"><span> : Alumni (${jumlahAlumni} orang)</span></div>`;
        div.innerHTML += `<div><img src="/img/mahasiswa.png" width="30"><span> : Mahasiswa Aktif (${jumlahMahasiswa} orang)</span></div>`;
        return div;
    };
    legend.addTo(map);
</script>
@endsection
