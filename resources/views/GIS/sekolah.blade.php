{{-- @dd($provinsi); --}}
@extends("GIS.layouts.app")

<style>
    #map {
        height: 88vh;
    }

    .kabupaten-label {
        font-size: 14px;
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
</style>

@section('content')
    {{-- <h3>Persebaran Sekolah Asal Mahasiswa</h3> --}}
    {{-- <div style="padding: 28px">
    </div> --}}
    <div id="map"></div>
@endsection

@php
    $data = collect($sekolah);
    $jumlahSMA = $data->where('jenis', 'SMA')->count();
    $jumlahSMK = $data->where('jenis', 'SMK')->count();
    $jumlahMA = $data->where('jenis', 'MA')->count();
    $lainnya = $data->where('jenis', 'Lainnya')->count();
@endphp


@php
    $schoolDataPerKab = $data->groupBy('kabupaten')->map(function ($items) {
        return [
            'SMA' => $items->where('jenis', 'SMA')->count(),
            'SMK' => $items->where('jenis', 'SMK')->count(),
            'MA' => $items->where('jenis', 'MA')->count(),
            'Lainnya' => $items->where('jenis', 'Lainnya')->count(),
        ];
    })->toArray();
@endphp





@section('js')
<script>

    const schoolData = @json($schoolDataPerKab);

    var map = L.map('map', {
        zoomControl: false
    }).setView([-2.90, 115.20], 8.499);

    L.control.zoom({ position: 'topright' }).addTo(map);

    var ulmIcon = L.icon({ iconUrl: "/img/Logo_ULM.png", iconSize: [50, 50] });
    var sekolah = L.icon({ iconUrl: "/img/sekolah.png", iconSize: [35, 35] });
    var SMA = L.icon({ iconUrl: "/img/SMA.png", iconSize: [35, 35] });
    var SMK = L.icon({ iconUrl: "/img/SMK.png", iconSize: [35, 35] });
    var MA = L.icon({ iconUrl: "/img/MA.png", iconSize: [35, 35] });

    var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
    }).addTo(map);

    var markerGroups = {};

    @foreach ($sekolah as $data)

        @php
            $koordinats = explode(',', $data->koordinat);
            $jenis = strtoupper($data->jenis);
        @endphp

        @if (count($koordinats) === 2 && is_numeric($koordinats[0]) && is_numeric($koordinats[1]))
            var latitude = {{ $koordinats[0] }},
                longitude = {{ $koordinats[1] }};
            var popupContent = `<b>{{ $data->nama_sekolah }}</b><br>Mahasiswa:<ul>`;


            @foreach ($data->biodata as $mhs)
                
                popupContent += `<li>{{ $mhs->nama }} ({{ $mhs->angkatan }})</li>`;
            @endforeach

            popupContent += `</ul>`;

            var selectedIcon;
            switch ("{{ $jenis }}") {
                case "SMA": selectedIcon = SMA; break;
                case "SMK": selectedIcon = SMK; break;
                case "MA": selectedIcon = MA; break;
                default: selectedIcon = sekolah;
            }

            @if (!empty($data->kabupaten))
                if (!markerGroups["{{ $data->kabupaten }}"]) {
                    markerGroups["{{ $data->kabupaten }}"] = L.layerGroup().addTo(map);
                }

                L.marker([latitude, longitude], { icon: selectedIcon })
                    .bindPopup(popupContent)
                    .addTo(markerGroups["{{ $data->kabupaten }}"]);
            @else
                L.marker([latitude, longitude], { icon: selectedIcon })
                    .bindPopup(popupContent)
                    .addTo(map);
            @endif

        @endif
    @endforeach

    let batasKabupaten = [];
    let colors = ["#32b8a6", "#f5cb11", "#eb7200", "#c461eb", "#6c7000", "#bf2e2e", "#46e39c", "#9fd40c", "#ad00f2", "#fffb00", "#7ff2fa", "#e8a784"];
    var kabupaten = [];
    var html = ``;

    html += `
        <input type="checkbox" id="chk-all" onclick="toggleAllKabupaten(this)">
        <label for="chk-all" style="cursor:pointer;" class="kabupaten-label"><b> Semua Kabupaten/Kota </b></label><br>
    `;

    const kabupatenList = [
        { namaFile: 'kabBanjarbaru', label: 'Banjarbaru' },
        { namaFile: 'kabBanjarmasin', label: 'Banjarmasin' },
        { namaFile: 'kabBalangan', label: 'Balangan' },
        { namaFile: 'kabBanjar', label: 'Banjar' },
        { namaFile: 'kabBaritoKuala', label: 'Barito Kuala' },
        { namaFile: 'kabHuluSungaiSelatan', label: 'Hulu Sungai Selatan' },
        { namaFile: 'kabHuluSungaiTengah', label: 'Hulu Sungai Tengah' },
        { namaFile: 'kabHuluSungaiUtara', label: 'Hulu Sungai Utara' },
        { namaFile: 'kabKotabaru', label: 'Kotabaru' },
        { namaFile: 'kabTabalong', label: 'Tabalong' },
        { namaFile: 'kabTanahBumbu', label: 'Tanah Bumbu' },
        { namaFile: 'kabTanahLaut', label: 'Tanah Laut' },
        { namaFile: 'kabTapin', label: 'Tapin' },
    ];

    var control2 = L.control.slideMenu("", { position: "topleft" }).addTo(map);

    kabupatenList.forEach((item, index) => {
        getShape(item.namaFile, item.label, index);
    });

    // Setelah semua `getShape` dipanggil, tambahkan `school-stats`
    setTimeout(() => {
        html += `<div id="school-stats" style="margin-top: 10px;"></div>`;
        control2.setContents(html);
    }, 1000); // timeout kecil untuk pastikan semua shape selesai load

    let kabupatenCheckboxStates = {};


    function getShape(namaFile, kab, index) {
        $.getJSON('/geoJSON/' + namaFile + '.geojson', (json) => {
            html += `
                <input type="checkbox" id="chk-${kab}" onclick="showKabupaten(this, ${index})">
                <label for="chk-${kab}" style="cursor:pointer;" class="kabupaten-label"><b> ${kab} </b></label><br>
            `;


            let geoLayer = L.geoJSON(json, {
                style: () => ({
                    fillOpacity: 0.5,
                    weight: 3,
                    opacity: 1,
                    color: 'black',
                    fillColor: colors[index % colors.length]
                })
            });

            geoLayer.options.name = kab;
            batasKabupaten[index] = geoLayer;
            kabupaten[index] = geoLayer;
            control2.setContents(html);
        });
    }

    function showKabupaten(checkbox, index) {
        const kabupatenName = kabupaten[index].options.name;
        kabupatenCheckboxStates[kabupatenName] = checkbox.checked;

        if (checkbox.checked) {
            map.addLayer(batasKabupaten[index]);
            if (markerGroups[kabupatenName]) {
                map.addLayer(markerGroups[kabupatenName]);
            }

            // Zoom ke tengah kabupaten
            const bounds = batasKabupaten[index].getBounds();
            map.flyTo(bounds.getCenter(), 10); // Zoom level bisa disesuaikan
        } else {
            map.removeLayer(batasKabupaten[index]);
            if (markerGroups[kabupatenName]) {
                map.removeLayer(markerGroups[kabupatenName]);
            }
        }

        updateMarkersVisibility();
        updateSchoolStats();
    }


    function updateMarkersVisibility() {
        const anyChecked = Object.values(kabupatenCheckboxStates).some(v => v === true);

        for (const [kabName, group] of Object.entries(markerGroups)) {
            if (!anyChecked) {
                map.addLayer(group); // Show all if none selected
            } else if (kabupatenCheckboxStates[kabName]) {
                map.addLayer(group); // Show only checked
            } else {
                map.removeLayer(group);
            }
        }
    }

    function updateSchoolStats() {
        const selected = Object.keys(kabupatenCheckboxStates).filter(k => kabupatenCheckboxStates[k]);

        let totalSMA = 0, totalSMK = 0, totalMA = 0, totalLainnya = 0;

        if (selected.length === 0) {
            // Jika tidak ada yang dipilih, tampilkan semua
            for (const kab in schoolData) {
                totalSMA += schoolData[kab]?.SMA || 0;
                totalSMK += schoolData[kab]?.SMK || 0;
                totalMA += schoolData[kab]?.MA || 0;
                totalLainnya += schoolData[kab]?.Lainnya || 0;
            }
        } else {
            // Hitung dari kabupaten yang dicentang
            selected.forEach(kab => {
                totalSMA += schoolData[kab]?.SMA || 0;
                totalSMK += schoolData[kab]?.SMK || 0;
                totalMA += schoolData[kab]?.MA || 0;
                totalLainnya += schoolData[kab]?.Lainnya || 0;
            });
        }

        const statsHTML = `
            <div class="legend" style="margin-top: 10px;">
                <div><img src="/img/SMA.png" width="20"><span> : SMA (${totalSMA} Sekolah)</span></div>
                <div><img src="/img/SMK.png" width="20"><span> : SMK (${totalSMK} Sekolah)</span></div>
                <div><img src="/img/MA.png" width="20"><span> : MA (${totalMA} Sekolah)</span></div>
                <div><img src="/img/sekolah.png" width="20"><span> : Lainnya (${totalLainnya} Sekolah)</span></div>
            </div>
        `;

        document.getElementById("school-stats").innerHTML = statsHTML;
    }




    function toggleAllKabupaten(masterCheckbox) {
        const isChecked = masterCheckbox.checked;

        kabupaten.forEach((layer, i) => {
            const kabName = layer.options.name;
            const checkbox = document.getElementById(`chk-${kabName}`);
            if (checkbox) {
                checkbox.checked = isChecked;
                kabupatenCheckboxStates[kabName] = isChecked;
            }

            if (isChecked) {
                map.addLayer(batasKabupaten[i]);
            } else {
                map.removeLayer(batasKabupaten[i]);
            }
        });

        updateMarkersVisibility();
        updateSchoolStats();
    }


    // Legenda
    var legend = L.control({ position: "bottomright" });

    var jumlahSMA = {{ $jumlahSMA }};
    var jumlahSMK = {{ $jumlahSMK }};
    var jumlahMA = {{ $jumlahMA }};
    var lainnya = {{ $lainnya }};

    legend.onAdd = function(map) {
        var div = L.DomUtil.create("div", "legend");
        div.innerHTML += "<h6>Keterangan : </h6>";
        div.innerHTML += `<div><img src="/img/SMA.png" width="30"><span> : SMA (${jumlahSMA} Sekolah)</span></div>`;
        div.innerHTML += `<div><img src="/img/SMK.png" width="30"><span> : SMK (${jumlahSMK} Sekolah)</span></div>`;
        div.innerHTML += `<div><img src="/img/MA.png" width="30"><span> : MA (${jumlahMA} Sekolah)</span></div>`;
        div.innerHTML += `<div><img src="/img/sekolah.png" width="30"><span> : Lainnya (${lainnya} Sekolah)</span></div>`;
        return div;
    };
    legend.addTo(map);
</script>
@endsection
