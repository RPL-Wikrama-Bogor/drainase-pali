@extends('templates.layout')

@section('content')
<div class="row">
    <div class="col-3 pb-3" style="padding-top: 5%">
        <div class="d-flex justify-content-between px-4 py-3">
            <div class="d-flex">
                <img src="{{asset('assets/logo-drainase.png')}}" width="50">
                <div class="ms-2">
                    <b class="text-primary">DRAINASE</b>
                    <br>
                    <small class="text-secondary"><b>Digital</b></small>
                </div>
            </div>
            <div class="pt-3">
                <i class="fas fa-user"></i>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between px-4">
            <div>
                <p class="text-primary"><i class="fas fa-layer-group text-primary me-1"></i>Layer</p>
            </div>
            <div>
                <p class="text-secondary"><i class="text-secondary fas fa-gear me-1"></i>Pengaturan</p>
            </div>
            <div>
                <p class="text-secondary"><i class="text-secondary fas fa-screwdriver-wrench me-1"></i>Alat</p>
            </div>
        </div>
        <hr>
        <div style="color: black !important" class="px-4">
            <small class="ps-2">Pilih <b>Ketersediaan</b></small>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Tersedia</small></button>
                <button class="btn btn-outline-dark ms-2"><small>Tidak Tersedia</small></button>
            </div>
            <small class="ps-2">Pilih <b>Jenis Saluran</b></small>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Terbuka</small></button>
                <button class="btn btn-outline-dark ms-2"><small>Tertutup</small></button>
            </div>
            <small class="ps-2">Pilih <b>Jenis Penampangan</b></small>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Trapesium</small></button>
                <button class="btn btn-outline-dark ms-2"><small>Segi Empat</small></button>
            </div>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Segitiga</small></button>
                <button class="btn btn-outline-dark ms-2"><small><small>1/2</small> Lingkaran</small></button>
            </div>
            <small class="ps-2">Pilih <b>Jenis Konstruksi</b></small>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Tanah</small></button>
                <button class="btn btn-outline-dark ms-2"><small>Pasangan Batu</small></button>
            </div>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Beton</small></button>
            </div>
            <small class="ps-2">Pilih <b>Jenis Penampangan</b></small>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Trapesium</small></button>
                <button class="btn btn-outline-dark ms-2"><small>Segi Empat</small></button>
            </div>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Segitiga</small></button>
                <button class="btn btn-outline-dark ms-2"><small><small>1/2</small> Lingkaran</small></button>
            </div>
            <small class="ps-2">Pilih <b>Kondisi</b></small>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Baik</small></button>
                <button class="btn btn-outline-dark ms-2"><small>Rusak Ringan</small></button>
            </div>
            <div class="d-flex mb-2">
                <button class="btn btn-outline-dark"><small>Rusak Berat</small></button>
            </div>
        </div>
        <button class="btn btn-primary btn-block btn-lg mx-4 mt-3">Terapkan Layer</button>
    </div>
    <div class="col-9">
        {{-- <img src="{{ asset('assets/peta.jpg') }}" class="w-100" style="height: 100%"> --}}
        <div id="map" style="height: 100vh;"></div>
    </div>
</div>
@endsection

@push('script')
<script>
var map = L.map('map').setView([-2.98, 104.75], 13); // sesuaikan pusatnya

// Base Google Satellite (lebih mirip Google Earth)
L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(map);

// Load GeoJSON Drainase
fetch("/maps/drainase.json")
    .then(res => res.json())
    .then(data => {

        let drainLayer = L.geoJSON(data, {
            style: function (feature) {
                return {
                    color: "red",
                    weight: 2
                };
            },

            onEachFeature: function (feature, layer) {

                // --- POPUP ---
                let popup = "";
                for (let key in feature.properties) {
                    popup += `<b>${key}</b>: ${feature.properties[key]}<br>`;
                }
                layer.bindPopup(popup);

                // --- HOVER HIGHLIGHT ---
                const defaultStyle = {
                    color: "red",
                    weight: 2
                };

                layer.on("mouseover", function () {
                    this.setStyle({
                        color: "yellow",
                        weight: 4
                    });
                    this.bringToFront();
                });

                layer.on("mouseout", function () {
                    this.setStyle(defaultStyle);
                });
            }
        }).addTo(map);

        // --- AUTO FOCUS PETA KE DATA ---
        map.fitBounds(drainLayer.getBounds(), {
            padding: [40, 40],   // memberi jarak agar tidak terlalu mepet
            maxZoom: 18          // batasi zoom agar tidak terlalu dekat
        });

    });

</script>
@endpush
