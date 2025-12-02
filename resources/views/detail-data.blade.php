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
                    @foreach ($segments as $index => $s)
                        @php
                            $props = $s['properties'];

                            // Tentukan identifier dengan urutan prioritas yang konsisten
                            if (!empty($props['SEGMEN'])) {
                                $identifier = $props['SEGMEN'];
                            } elseif (!empty($props['NAMA_RUAS'])) {
                                $identifier = $props['NAMA_RUAS'];
                            } else {
                                $identifier = 'feature_' . $index;
                            }

                            $namaRuas = $props['NAMA_RUAS'] ?? $ruasName;
                            $hasImage = $images->has($identifier);
                            $imageData = $hasImage ? $images[$identifier] : null;
                        @endphp
                        <tr>
                            <td>{{ $props['POSISI'] ?? '-' }}</td>
                            <td>{{ $props['SEGMEN'] ?? '-' }}</td>
                            <td>{{ $props['X'] ?? '-' }}</td>
                            <td>{{ $props['Y'] ?? '-' }}</td>
                            <td>{{ $props['DRN_STAT'] ?? '-' }}</td>
                            <td>{{ $props['JNS_SAL'] ?? '-' }}</td>
                            <td>{{ $props['JNS_PNPG'] ?? '-' }}</td>
                            <td>{{ $props['DIM_PNPG'] ?? '-' }}</td>
                            <td>{{ $props['JNS_KONS'] ?? '-' }}</td>
                            <td>{{ $props['KOND_PNPG'] ?? '-' }}</td>
                            <td>{{ number_format($props['PANJANG_M'] ?? 0, 2) }}</td>
                            <td>
                                @if ($hasImage && $imageData && $imageData->image_url)
                                    <img src="{{ $imageData->image_url }}"
                                        alt="Gambar {{ $namaRuas }}"
                                        class="img-thumbnail"
                                        style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        data-image="{{ $imageData->image_url }}"
                                        data-description="{{ $imageData->description ?? 'Tidak ada deskripsi' }}"
                                        title="Klik untuk melihat">
                                @else
                                    <div style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 0.375rem; color: #6c757d;">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $imageData->description ?? 'Tidak ada deskripsi' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal untuk Preview Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Gambar Drainase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid rounded" style="max-height: 70vh;">
                    <div class="mt-3">
                        <p id="modalDescription" class="text-muted"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
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
                "https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}", {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }
            ).addTo(map);

            // GOOGLE LABELS
            let googleLabel = L.tileLayer(
                "https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}", {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }
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

                    layer.on("mouseover", function() {
                        this.setStyle({
                            color: "yellow",
                            weight: 7
                        });
                        this.bringToFront();
                    });

                    layer.on("mouseout", function() {
                        this.setStyle(originalStyle);
                    });
                }
            }).addTo(map);

            map.fitBounds(layer.getBounds(), {
                padding: [50, 50]
            });
        });
    </script>
    <!-- Script untuk Modal -->
    <script>
        $(document).ready(function() {
            $('#imageModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var imageSrc = button.data('image');
                var description = button.data('description');

                $('#modalImage').attr('src', imageSrc);
                $('#modalDescription').text(description || 'Tidak ada deskripsi');
            });
        });
    </script>
@endpush
