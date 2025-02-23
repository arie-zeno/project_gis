{{-- @dd($provinsi); --}}
@extends ("GIS.layouts.app")
<style>
    #map {
        height: 85vh;
    }
</style>
@section('content')
    <h1>wkwk</h1>
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
            @php
                $koordinats = explode(',', $data['koordinat']);
            @endphp
            var latitude = {{ $koordinats[0] }},
                longitude = {{ $koordinats[1] }}

            L.marker([latitude, longitude], {
                })
                .addTo(map)

                .bindPopup(
                    `Nama Sekolah : {{ $data['nama_sekolah'] }} <br>
                                       `);
        @endforeach

        //   GeoJSON
        let batasKecamatan = [];
        let sub = [];
        let colors = ["#32b8a6", "#f5cb11", "#eb7200", "#c461eb", "#6c7000", "#bf2e2e", "#46e39c", "#9fd40c", "#ad00f2",
            "#fffb00", "#7ff2fa", "#e8a784"
        ];

        var kabupaten = []
        var listKabupaten = []
        var html = ``;

        getShape("kabBanjarmasin", "Banjarmasin");
        getShape("kabTapin", "Tapin");
        getShape("kabBanjarbaru", "Banjarbaru");
        getShape("kabBanjar", "Banjar");
        getShape("kabBaritoKuala", "BaritoKuala");
        getShape("kabHuluSungaiSelatan", "HuluSungaiSelatan");
        getShape("kabHuluSungaiTengah", "HuluSungaiTengah");
        getShape("kabHuluSungaiUtara", "HuluSungaiUtara");
        getShape("kabBalangan", "Balangan");
        getShape("kabTabalong", "Tabalong");
        getShape("kabTanahLaut", "TanahLaut");
        getShape("kabTanahBumbu", "TanahBumbu");
        getShape("kabKotabaru", "Kotabaru");

        var control2 = L.control.slideMenu("", {
            position: "topleft",
            menuposition: "topleft",

        }).addTo(map);

        var legend = L.control({
            position: "bottomright",
        });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create("div", "legend");

            div.style.backgroundColor = "white";
            div.style.padding = "15px";

            div.innerHTML += "<h5>Keterangan : </h5>";
            div.innerHTML += '<div><img src="/img/Logo_ULM.png" width="35"><span> : FKIP ULM</span></div>';
            div.innerHTML += '<div><img src="/img/icon_cowo.png" width="35"><span> : Alumni (Laki-laki)</span></div>';
            div.innerHTML += '<div><img src="/img/icon_cewe.png" width="35"><span> : Alumni (Perempuan)</span></div>';



            return div;
        };

        legend.addTo(map);

        function showBatas(v, i) {
            if (v.checked === true) {
                // map.removeLayer(batasKecamatan);
                map.addLayer(sub[i]);
                map.flyTo(sub[i].getBounds().getCenter());

            } else {
                map.removeLayer(sub[i]);

            }
        }

        function showKecamatan(v, i) {
            let inp = v.parentElement.querySelectorAll("." + v.id),
                span = v.parentElement.querySelector("#label" + v.id);
            console.log(span)


            if (v.checked === true) {
                // map.addLayer(batasKecamatan);
                // var class = $(".Balangan");    
                for (let i = 0; i < inp.length; i++) {
                    inp[i].style.display = "";
                }

                span.className = "fa fa-chevron-down"


                // map.flyTo(batasKecamatan[i].getBounds().getCenter());


            } else {
                for (let i = 0; i < inp.length; i++) {
                    inp[i].style.display = "none";
                }
                // map.flyTo(batasKecamatan[i].getBounds().getCenter());
            }
        }

        function getShape(namaFile, kab) {

            $.getJSON('/geoJSON/' + namaFile + '.geojson', (json) => {
                html = html + `
                                <label for="${kab}" style="cursor:pointer;" class="fs-6"><b> Kabupaten ${kab} <span id="label${kab}" class="fa fa-chevron-left"></span></b></label>
                                <input id="${kab}" style="transform:scale(0)"  type="checkbox"  onclick="showKecamatan(this, ${batasKecamatan.length})">
                                <br>
                        `;
                let i = 0;
                let j = 1;
                geoLayer = L.geoJSON(json, {

                    style: (feature) => {
                        return {
                            fillOpacity: 0.8,
                            weight: 3,
                            opacity: 1,
                            color: 'purple',
                            fillColor: colors[i]
                        };
                    },
                    onEachFeature: (feature, layer) => {
                        var iconLabel = L.divIcon({
                            className: 'label-kecamatan',
                            html: `${feature.properties.WADMKC}`

                        });
                        console.log(feature.properties.WADMKC)
                        // if(feature.properties.WADMKC){

                        html = html + `
                                <div class="${kab}" style="display:none">
                                <input id="${sub.length}" type="checkbox" class="kec" onclick="showBatas(this, ${sub.length})">  <label class="text-capitalize" for="${sub.length}">${feature.properties.WADMKC}</label> <br>
                            </div>
                            `;

                        // console.log(html)
                        sub.push(L.markerClusterGroup().addLayer(layer));
                        L.marker(layer.getBounds().getCenter(), {
                            icon: iconLabel
                        }).addTo(sub[batasKecamatan.length]);

                        // batasKecamatan.addLayer(sub[i]);
                        //  sub[i].addTo(batasKecamatan);
                        // batasKecamatan.addLayer(layer);
                        batasKecamatan.push(L.markerClusterGroup().addLayer(sub[batasKecamatan
                            .length]));
                        i++;
                        // }

                    }
                })
                // console.log(batasKecamatan.length)
                for (let i = 0; i < batasKecamatan.length; i++) {
                    kabupaten.push(L.markerClusterGroup().addLayer(batasKecamatan[i]))
                }
                control2.setContents(html);
            })
        }
    </script>
@endsection
