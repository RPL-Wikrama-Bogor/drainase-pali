@extends('templates.layout')

@push('style')
    <style>
        /* Custom scrollbar untuk sidebar */
        .col-3::-webkit-scrollbar {
            width: 6px;
        }

        .col-3::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .col-3::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .col-3::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Hover effect untuk badge filter - DIHAPUS */
        .filter-badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        /* Hapus efek hover pada badge */
        /* .filter-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        } */

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .col-3 {
                width: 100%;
                height: auto;
                max-height: 50vh;
            }

            .col-9 {
                width: 100%;
                height: 50vh;
            }

            .row {
                flex-direction: column;
            }
        }

        /* Smooth transitions */
        #activeFilters {
            transition: all 0.3s ease;
        }
    </style>
@endpush

@section('content')
    <div class="row g-0">
        <div class="col-3" style="height: 100vh; overflow-y: auto; background-color: #f8f9fa; margin-top: 5%">
            <div class="d-flex justify-content-between px-4 py-3 border-bottom">
                <div class="d-flex">
                    <img src="{{ asset('assets/logo-drainase.png') }}" width="50">
                    <div class="ms-2">
                        <b class="text-primary">DRAINASE</b>
                        <br>
                        <small class="text-secondary"><b>Digital</b></small>
                    </div>
                </div>
                <div class="pt-3">
                    <i class="fas fa-user text-secondary"></i>
                </div>
            </div>

            <div class="d-flex justify-content-between px-4 py-3 border-bottom">
                <div>
                    <p class="text-primary mb-0"><i class="fas fa-layer-group text-primary me-1"></i>Layer</p>
                </div>
                <div>
                    <p class="text-secondary mb-0"><i class="text-secondary fas fa-gear me-1"></i>Pengaturan</p>
                </div>
                <div>
                    <p class="text-secondary mb-0"><i class="text-secondary fas fa-screwdriver-wrench me-1"></i>Alat</p>
                </div>
            </div>

            <div class="px-4 py-3">
                <!-- Filter Ketersediaan -->
                <div class="mb-4">
                    <small class="d-block mb-2"><b>Ketersediaan</b></small>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge border border-dark text-dark filter-badge" data-filter="DRN_STAT"
                            data-value="Tersedia" style="cursor: pointer; font-size: 0.8rem;">Tersedia</span>
                        <span class="badge border border-dark text-dark filter-badge" data-filter="DRN_STAT"
                            data-value="Tidak Tersedia" style="cursor: pointer; font-size: 0.8rem;">Tidak Tersedia</span>
                        <span class="badge border border-dark text-dark filter-badge" data-filter="DRN_STAT"
                            data-value="Belum Disurvey" style="cursor: pointer; font-size: 0.8rem;">Belum Disurvey</span>
                    </div>
                </div>

                <!-- Filter Jenis Saluran -->
                <div class="mb-4">
                    <small class="d-block mb-2"><b>Jenis Saluran</b></small>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_SAL"
                            data-value="Terbuka" style="cursor: pointer; font-size: 0.8rem;">Terbuka</span>
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_SAL"
                            data-value="Tertutup" style="cursor: pointer; font-size: 0.8rem;">Tertutup</span>
                    </div>
                </div>

                <!-- Filter Jenis Penampang -->
                <div class="mb-4">
                    <small class="d-block mb-2"><b>Jenis Penampang</b></small>
                    <div class="d-flex flex-wrap gap-1 mb-1">
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_PNPG"
                            data-value="Trapesium" style="cursor: pointer; font-size: 0.8rem;">Trapesium</span>
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_PNPG"
                            data-value="Segi Empat" style="cursor: pointer; font-size: 0.8rem;">Segi Empat</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_PNPG"
                            data-value="Segitiga" style="cursor: pointer; font-size: 0.8rem;">Segitiga</span>
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_PNPG"
                            data-value="1/2 Lingkaran" style="cursor: pointer; font-size: 0.8rem;">½ Lingkaran</span>
                    </div>
                </div>

                <!-- Filter Jenis Konstruksi -->
                <div class="mb-4">
                    <small class="d-block mb-2"><b>Jenis Konstruksi</b></small>
                    <div class="d-flex flex-wrap gap-1 mb-1">
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_KONS"
                            data-value="Tanah" style="cursor: pointer; font-size: 0.8rem;">Tanah</span>
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_KONS"
                            data-value="Pasangan Batu" style="cursor: pointer; font-size: 0.8rem;">Pasangan Batu</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge border border-dark text-dark filter-badge" data-filter="JNS_KONS"
                            data-value="Beton" style="cursor: pointer; font-size: 0.8rem;">Beton</span>
                    </div>
                </div>

                <!-- Filter Kondisi -->
                <div class="mb-4">
                    <small class="d-block mb-2"><b>Kondisi</b></small>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge border border-dark text-dark filter-badge" data-filter="KOND_PNPG"
                            data-value="Baik" style="cursor: pointer; font-size: 0.8rem;">Baik</span>
                        <span class="badge border border-dark text-dark filter-badge" data-filter="KOND_PNPG"
                            data-value="Rusak Ringan" style="cursor: pointer; font-size: 0.8rem;">Rusak Ringan</span>
                        <span class="badge border border-dark text-dark filter-badge" data-filter="KOND_PNPG"
                            data-value="Rusak Berat" style="cursor: pointer; font-size: 0.8rem;">Rusak Berat</span>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-4">
                    <button class="btn btn-primary w-100 mb-2" id="applyFilter">
                        <i class="fas fa-filter me-1"></i> Terapkan Filter
                    </button>
                    <button class="btn btn-outline-secondary w-100" id="resetFilter">
                        <i class="fas fa-undo me-1"></i> Reset Filter
                    </button>
                </div>

                <!-- Info Filter Aktif -->
                <div class="mt-4 p-3 bg-light rounded border" id="activeFilters" style="display: none;">
                    <small class="d-block mb-2"><b>Filter Aktif:</b></small>
                    <div id="activeFiltersList"></div>
                </div>
            </div>
        </div>

        <div class="col-9">
            <div id="map" style="height: 100vh;"></div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let map = L.map('map').setView([-2.98, 104.75], 13);
        let drainLayer;
        let allFeatures = [];
        let activeFilters = {};

        // Base Google Satellite
        L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '© Google Hybrid'
        }).addTo(map);

        // Load GeoJSON Drainase
        fetch("/maps/drainase.json")
            .then(res => res.json())
            .then(data => {
                allFeatures = data.features;
                renderMap();
            })
            .catch(err => console.error('Error loading GeoJSON:', err));

        function renderMap() {
            // Hapus layer lama jika ada
            if (drainLayer) {
                map.removeLayer(drainLayer);
            }

            // Filter features berdasarkan filter aktif
            let filteredFeatures = allFeatures.filter(feature => {
                for (let filter in activeFilters) {
                    let property = feature.properties[filter];
                    let filterValue = activeFilters[filter];

                    if (filterValue !== 'all') {
                        if (!property || property !== filterValue) {
                            return false;
                        }
                    }
                }
                return true;
            });

            drainLayer = L.geoJSON({
                type: 'FeatureCollection',
                features: filteredFeatures
            }, {
                style: function(feature) {
                    // Warna berdasarkan jenis saluran
                    let color = '#ff0000'; // default merah untuk tidak tersedia

                    if (feature.properties.JNS_SAL === 'Terbuka') {
                        color = '#00cc44'; // hijau untuk terbuka
                    } else if (feature.properties.JNS_SAL === 'Tertutup') {
                        color = '#0077ff'; // biru untuk tertutup
                    }

                    return {
                        color: color,
                        weight: 4,
                        opacity: 0.9,
                        dashArray: feature.properties.JNS_SAL === 'Tidak Tersedia' ? '5, 5' : 'none'
                    };
                },

                onEachFeature: function(feature, layer) {
                    let props = feature.properties;

                    // Format key untuk display
                    function formatKey(key) {
                        return key.replace(/_/g, ' ')
                            .replace(/\b\w/g, l => l.toUpperCase())
                            .replace('Jns', 'Jenis')
                            .replace('Pnp', 'Penampang')
                            .replace('Drn', 'Drainase')
                            .replace('Stat', 'Status');
                    }

                    // Pisahkan properties menjadi 2 kolom
                    let leftColumn = '';
                    let rightColumn = '';
                    let propertyCount = 0;

                    for (let key in props) {
                        if (props[key] && props[key] !== '' && key !== 'styleUrl') {
                            let formattedKey = formatKey(key);
                            let value = props[key];

                            let propertyHtml = `
                        <div class="mb-2">
                            <div class="text-muted" style="font-size: 0.75rem; font-weight: 600;">${formattedKey}</div>
                            <div style="font-size: 0.85rem; color: #212529;">${value}</div>
                        </div>
                    `;

                            if (propertyCount % 2 === 0) {
                                leftColumn += propertyHtml;
                            } else {
                                rightColumn += propertyHtml;
                            }
                            propertyCount++;
                        }
                    }

                    // Popup content - dua kolom
                    let popup = `
                <div style="width: 500px; max-width: 90vw;">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 15px; border-radius: 8px 8px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 style="margin: 0; font-size: 1rem;">
                                    <i class="fas fa-water me-1"></i>${props.NAMA_RUAS || 'Drainase'}
                                </h5>
                                <small style="opacity: 0.9;">${props.SEGMEN ? 'Segmen: ' + props.SEGMEN : ''}</small>
                            </div>
                            <div style="background: rgba(255,255,255,0.2); padding: 3px 8px; border-radius: 20px; font-size: 0.75rem;">
                                ${props.DRN_STAT || 'Status'}
                            </div>
                        </div>
                    </div>

                    <div style="padding: 15px; background: #fff;">
                        <div class="row">
                            <div class="col-6" style="border-right: 1px solid #e9ecef; padding-right: 15px;">
                                ${leftColumn}
                            </div>
                            <div class="col-6" style="padding-left: 15px;">
                                ${rightColumn}
                            </div>
                        </div>

                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>${props.X || ''} ${props.Y ? '| ' + props.Y : ''}
                                </small>
                                <small class="text-muted">
                                    Panjang: ${props.PANJANG_M ? parseFloat(props.PANJANG_M).toFixed(2) + ' m' : '0 m'}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                    layer.bindPopup(popup, {
                        maxWidth: 500,
                        className: 'drainase-popup',
                        autoPanPadding: [50, 50]
                    });

                    // Hapus hover highlight - hanya klik untuk popup
                    // Hover effect dihapus sesuai permintaan
                }
            }).addTo(map);

            // Auto focus peta jika ada data
            if (filteredFeatures.length > 0) {
                map.fitBounds(drainLayer.getBounds(), {
                    padding: [50, 50],
                    maxZoom: 16
                });
            }
        }

        // Update tampilan filter aktif
        function updateActiveFiltersDisplay() {
            const activeFiltersDiv = document.getElementById('activeFilters');
            const activeFiltersList = document.getElementById('activeFiltersList');

            if (Object.keys(activeFilters).length === 0) {
                activeFiltersDiv.style.display = 'none';
            } else {
                activeFiltersDiv.style.display = 'block';
                let html = '';

                for (let filter in activeFilters) {
                    let filterName = '';
                    switch (filter) {
                        case 'DRN_STAT':
                            filterName = 'Ketersediaan';
                            break;
                        case 'JNS_SAL':
                            filterName = 'Jenis Saluran';
                            break;
                        case 'JNS_PNPG':
                            filterName = 'Jenis Penampang';
                            break;
                        case 'JNS_KONS':
                            filterName = 'Jenis Konstruksi';
                            break;
                        case 'KOND_PNPG':
                            filterName = 'Kondisi';
                            break;
                        default:
                            filterName = filter;
                    }

                    html += `
                <span class="badge bg-primary me-1 mb-1" style="font-size: 0.7rem;">
                    ${filterName}: ${activeFilters[filter]}
                    <span class="ms-1" onclick="removeFilter('${filter}')" style="cursor: pointer;">×</span>
                </span>
            `;
                }

                activeFiltersList.innerHTML = html;
            }
        }

        // Fungsi remove filter individual
        function removeFilter(filter) {
            // Hapus filter
            delete activeFilters[filter];

            // Update badge styling
            document.querySelectorAll(`.filter-badge[data-filter="${filter}"]`).forEach(badge => {
                badge.classList.remove('bg-primary', 'text-white');
                badge.classList.add('border', 'border-dark', 'text-dark');
            });

            // Update display
            updateActiveFiltersDisplay();
            renderMap();
        }

        // Filter badge functionality
        document.querySelectorAll('.filter-badge').forEach(badge => {
            badge.addEventListener('click', function() {
                const filter = this.dataset.filter;
                const value = this.dataset.value;

                // Toggle active state
                if (this.classList.contains('bg-primary')) {
                    // Remove active state
                    this.classList.remove('bg-primary', 'text-white');
                    this.classList.add('border', 'border-dark', 'text-dark');
                    delete activeFilters[filter];
                } else {
                    // Remove active state from other badges in same filter group
                    document.querySelectorAll(`.filter-badge[data-filter="${filter}"]`).forEach(b => {
                        b.classList.remove('bg-primary', 'text-white');
                        b.classList.add('border', 'border-dark', 'text-dark');
                    });

                    // Add active state to clicked badge
                    this.classList.remove('border', 'border-dark', 'text-dark');
                    this.classList.add('bg-primary', 'text-white');
                    activeFilters[filter] = value;
                }

                updateActiveFiltersDisplay();
            });
        });

        // Terapkan filter
        document.getElementById('applyFilter').addEventListener('click', function() {
            renderMap();

            // Tampilkan notifikasi
            const filteredFeatures = allFeatures.filter(feature => {
                for (let filter in activeFilters) {
                    let property = feature.properties[filter];
                    let filterValue = activeFilters[filter];

                    if (!property || property !== filterValue) {
                        return false;
                    }
                }
                return true;
            });

            L.popup()
                .setLatLng(map.getCenter())
                .setContent(`
            <div style="padding: 10px; min-width: 200px;">
                <h6 style="margin: 0 0 10px 0; color: #007bff; font-size: 0.9rem;">
                    <i class="fas fa-filter me-1"></i>Filter Diterapkan
                </h6>
                <p style="margin: 0; font-size: 0.8rem;">
                    Menampilkan <b>${filteredFeatures.length}</b> dari <b>${allFeatures.length}</b> drainase
                </p>
            </div>
        `)
                .openOn(map);

            // Auto close popup setelah 3 detik
            setTimeout(() => {
                map.closePopup();
            }, 3000);
        });

        // Reset filter
        document.getElementById('resetFilter').addEventListener('click', function() {
            // Reset semua badge
            document.querySelectorAll('.filter-badge').forEach(badge => {
                badge.classList.remove('bg-primary', 'text-white');
                badge.classList.add('border', 'border-dark', 'text-dark');
            });

            // Reset filter aktif
            activeFilters = {};

            // Update display
            updateActiveFiltersDisplay();

            // Render ulang peta
            renderMap();

            // Tampilkan notifikasi
            L.popup()
                .setLatLng(map.getCenter())
                .setContent(`
            <div style="padding: 10px; min-width: 200px;">
                <h6 style="margin: 0 0 10px 0; color: #28a745; font-size: 0.9rem;">
                    <i class="fas fa-check-circle me-1"></i>Filter Direset
                </h6>
                <p style="margin: 0; font-size: 0.8rem;">
                    Menampilkan semua <b>${allFeatures.length}</b> drainase
                </p>
            </div>
        `)
                .openOn(map);

            // Auto close popup setelah 3 detik
            setTimeout(() => {
                map.closePopup();
            }, 3000);
        });

        // Tambahkan custom CSS untuk popup
        const style = document.createElement('style');
        style.innerHTML = `
    .drainase-popup .leaflet-popup-content-wrapper {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        padding: 0;
        overflow: hidden;
    }

    .drainase-popup .leaflet-popup-content {
        margin: 0;
        line-height: 1.4;
    }

    .drainase-popup .leaflet-popup-tip-container {
        margin-top: -1px;
    }

    .leaflet-popup-content h5 {
        font-weight: 600;
    }

    .leaflet-popup-content .text-muted {
        color: #6c757d !important;
    }

    .leaflet-popup-content small {
        opacity: 0.8;
    }

    /* Style untuk filter sidebar - hover dihapus */
    .filter-badge {
        transition: all 0.2s ease;
        user-select: none;
    }

    /* Hapus efek hover */
    /* .filter-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    } */

    .filter-badge.bg-primary {
        border-color: #007bff !important;
    }
`;
        document.head.appendChild(style);
    </script>
@endpush
