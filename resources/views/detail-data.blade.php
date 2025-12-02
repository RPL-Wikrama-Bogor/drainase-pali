@extends('templates.layout')

@section('content')
<div style="background: #f3f5fa; overflow-x: hidden; margin-top: 5%" class="mb-3">
    <div class="container py-4">
        <h5><b>Jalan Menuju {{ $ruasName }}</b></h5>
    </div>
</div>
<div class="container">
    {{-- <img src="{{asset('assets/office-road.jpg')}}" alt="" class="d-block mx-auto w-75"> --}}
    <div id="map" style="height: 450px; width: 75%; display: block; margin: auto"></div>
    <br>
    <div class="table-responsive w-100 my-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><b class="bg-light">POSISI</b></th>
                    <th><b class="bg-light">SEGMEN</b></th>
                    <th><b class="bg-light">X</b></th>
                    <th><b class="bg-light">Y</b></th>
                    <th><b class="bg-light">DRN STAT</b></th>
                    <th><b class="bg-light">JNS SAL</b></th>
                    <th><b class="bg-light">JNS PNPG</b></th>
                    <th><b class="bg-light">DIM PNPG</b></th>
                    <th><b class="bg-light">JNS KONS</b></th>
                    <th><b class="bg-light">KONDISI</b></th>
                    <th><b class="bg-light">PANJANG (m)</b></th>
                    <th><b class="bg-light">Foto</b></th>
                    <th><b class="bg-light">Catatan</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($segments as $s)
                    <tr>
                        <td>{{ $s['properties']['POSISI'] }}</td>
                        <td>{{ $s['properties']['SEGMEN'] ?? '-' }}</td>
                        <td>{{ $s['properties']['X'] }}</td>
                        <td>{{ $s['properties']['Y'] }}</td>
                        <td>{{ $s['properties']['DRN_STAT'] }}</td>
                        <td>{{ $s['properties']['JNS_SAL'] }}</td>
                        <td>{{ $s['properties']['JNS_PNPG'] }}</td>
                        <td>{{ $s['properties']['DIM_PNPG'] }}</td>
                        <td>{{ $s['properties']['JNS_KONS'] }}</td>
                        <td>{{ $s['properties']['KOND_PNPG'] }}</td>
                        <td>{{ $s['properties']['PANJANG_M'] }}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener("DOMContentLoaded", () => {

    let geojsonData = @json($geojson);

    let map = L.map("map");

    // GOOGLE SATELLITE
    let googleSat = L.tileLayer(
        "https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}",
        { maxZoom: 20, subdomains: ['mt0','mt1','mt2','mt3'] }
    ).addTo(map);

    // GOOGLE LABELS
    let googleLabel = L.tileLayer(
        "https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}",
        { maxZoom: 20, subdomains: ['mt0','mt1','mt2','mt3'] }
    ).addTo(map);

    // Function warna berdasarkan jenis saluran
    function getColor(jenis) {
        if (!jenis) return "cyan";

        jenis = jenis.toLowerCase();

        if (jenis.includes("terbuka")) return "#00cc44"; // hijau
        if (jenis.includes("tertutup")) return "#0077ff"; // biru
        if (jenis.includes("tidak tersedia")) return "red"; // merah

        return "cyan"; // default
    }

    // DRAW GEOJSON + POPUP + HOVER
    let layer = L.geoJSON(geojsonData, {
        coordsToLatLng: c => L.latLng(c[1], c[0]),

        // STYLE PER FITUR
        style: function(feature) {
            let jenis = feature.properties.JNS_SAL;
            return {
                color: getColor(jenis),
                weight: 5
            };
        },

        onEachFeature: (feature, layer) => {

            // --- POPUP ---
            let p = feature.properties;
            let popup = `
                <div style="font-size:14px; line-height:1.4">
                    <b>Nama Ruas:</b> ${p.NAMA_RUAS ?? "-"}<br>
                    <b>Fungsi Jalan:</b> ${p.FUNGSI_JLN ?? "-"}<br>
                    <b>Status Jalan:</b> ${p.STATUS_JLN ?? "-"}<br>
                    <b>Posisi</b>: ${p.POSISI ?? "-"}<br>
                    <b>Segmen</b>: ${p.SEGMEN ?? "-"}<br>
                    <b>Koordinat X</b>: ${p.X ?? "-"}<br>
                    <b>Koordinat Y</b>: ${p.Y ?? "-"}<br>
                    <b>Status Drainase</b>: ${p.DRN_STAT ?? "-"}<br>
                    <b>Jenis Saluran</b>: ${p.JNS_SAL ?? "-"}<br>
                    <b>Jenis Penampang</b>: ${p.JNS_PNPG ?? "-"}<br>
                    <b>Dimensi Penampang</b>: ${p.DIM_PNPG ?? "-"}<br>
                    <b>Bahan Konstruksi</b>: ${p.JNS_KONS ?? "-"}<br>
                    <b>Kondisi Penampang</b>: ${p.KOND_PNPG ?? "-"}<br>
                    <b>Panjang (km):</b> ${p.PANJANG_KM ?? "-"}<br>
                    <b>Panjang (m):</b> ${p.PANJANG_M ?? "-"}<br>
                </div>
            `;
            layer.bindPopup(popup);

            // --- HOVER EFFECT ---

            // warna asli
            let originalStyle = {
                color: getColor(p.JNS_SAL),
                weight: 5
            };

            layer.on("mouseover", function () {
                this.setStyle({
                    color: "yellow",
                    weight: 7
                });
                this.bringToFront();
            });

            layer.on("mouseout", function () {
                this.setStyle(originalStyle);
            });
        }
    }).addTo(map);

    map.fitBounds(layer.getBounds(), { padding: [50, 50] });
});
</script>

@endpush
