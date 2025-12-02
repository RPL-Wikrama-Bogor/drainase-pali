@extends('templates.layout')

@section('content')
<div class="container" style="margin-top: 5%">
    <div class="row pt-5">
        <div class="col-12">
            <div>
                <div>
                    <!-- Alert Notifikasi -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Informasi Tahapan -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h5 class="mb-3 text-primary">
                                <i class="fas fa-info-circle me-2"></i>Tahapan Upload Data Drainase
                            </h5>
                            <div class="row">
                                <!-- Tahap 1 -->
                                <div class="col-md-4 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0">
                                                <span class="badge bg-white text-primary me-2">1</span>
                                                Persiapkan File SHP/KMZ
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <small>
                                                    <i class="fas fa-file me-2 text-primary"></i>
                                                    Siapkan file data drainase dalam format:<br>
                                                    • <strong>SHP</strong> (ESRI Shapefile)<br>
                                                    • <strong>KMZ</strong> (Google Earth)<br>
                                                    • <strong>KML</strong> (Google Earth)
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tahap 2 -->
                                <div class="col-md-4 mb-3">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0">
                                                <span class="badge bg-white text-success me-2">2</span>
                                                Convert ke GeoJSON
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <small>
                                                    <i class="fas fa-exchange-alt me-2 text-success"></i>
                                                    Convert file ke format GeoJSON menggunakan:<br>
                                                    • <a href="https://mapshaper.org/" target="_blank" class="text-success">
                                                        <strong>mapshaper.org</strong>
                                                    </a><br>
                                                    • Pilih output format: <strong>GeoJSON</strong>
                                                </small>
                                            </p>
                                            <a href="https://mapshaper.org/" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-external-link-alt me-1"></i> Buka Mapshaper
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tahap 3 -->
                                <div class="col-md-4 mb-3">
                                    <div class="card border-warning">
                                        <div class="card-header bg-warning text-white">
                                            <h6 class="mb-0">
                                                <span class="badge bg-white text-warning me-2">3</span>
                                                Upload File JSON
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <small>
                                                    <i class="fas fa-upload me-2 text-warning"></i>
                                                    Upload file JSON hasil convert:<br>
                                                    • File akan mengganti <code>drainase.json</code><br>
                                                    • Pastikan struktur data sesuai<br>
                                                    • Max size: <strong>10MB</strong>
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Upload -->
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 text-white">
                                        <i class="fas fa-upload me-2 text-white"></i>Form Upload GeoJSON
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.drainase.import.process') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                                        @csrf

                                        <div class="mb-4">
                                            <label for="geojson_file" class="form-label">
                                                <strong>Pilih File GeoJSON</strong>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <!-- Di form upload -->
                                            <input type="file"
                                                class="form-control @error('geojson_file') is-invalid @enderror"
                                                id="geojson_file"
                                                name="geojson_file"
                                                accept=".json,.geojson"
                                                required>
                                            <small class="form-text text-muted">Hanya file .json atau .geojon yang diterima (maks. 10MB)</small>
                                            @error('geojson_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Preview File Info -->
                                        <div class="mb-4 d-none" id="filePreview">
                                            <div class="alert alert-info">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <i class="fas fa-file-code me-2"></i>
                                                            <span id="fileName">nama_file.json</span>
                                                        </h6>
                                                        <small>
                                                            Ukuran: <span id="fileSize">0 KB</span> |
                                                            Tipe: <span id="fileType">application/json</span>
                                                        </small>
                                                    </div>
                                                    <button type="button" class="btn-close" onclick="clearFile()"></button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Backup Option -->
                                        <div class="mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="create_backup" name="create_backup" value="1" checked>
                                                <label class="form-check-label" for="create_backup">
                                                    <strong>Buat backup file sebelumnya</strong>
                                                </label>
                                                <div class="form-text">
                                                    File drainase.json yang lama akan disimpan sebagai backup dengan timestamp
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Validation Info -->
                                        <div class="mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="validate_json" name="validate_json" value="1" checked>
                                                <label class="form-check-label" for="validate_json">
                                                    <strong>Validasi struktur JSON</strong>
                                                </label>
                                                <div class="form-text">
                                                    Pastikan file memiliki struktur GeoJSON yang valid (type, features, geometry, properties)
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a href="{{ route('admin.drainase.index') }}" class="btn btn-secondary me-md-2">
                                                <i class="fas fa-arrow-left me-1"></i> Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                                <i class="fas fa-upload me-1"></i> Upload & Ganti Data
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="card border-info mt-4">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-database me-2"></i>Informasi File Saat Ini
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @php
                                        $currentFile = public_path('maps/drainase.json');
                                        $fileExists = file_exists($currentFile);
                                        $fileInfo = $fileExists ? [
                                            'size' => round(filesize($currentFile) / 1024, 2),
                                            'modified' => date('d/m/Y H:i:s', filemtime($currentFile)),
                                            'content' => json_decode(file_get_contents($currentFile), true)
                                        ] : null;
                                    @endphp

                                    @if($fileExists && $fileInfo)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1">
                                                    <strong>Lokasi File:</strong><br>
                                                    <code class="text-info">public/maps/drainase.json</code>
                                                </p>
                                                <p class="mb-1">
                                                    <strong>Ukuran:</strong> {{ $fileInfo['size'] }} KB
                                                </p>
                                                {{-- <p class="mb-1">
                                                    <strong>Terakhir diubah:</strong> {{ \Carbon\Carbon::parse($fileInfo['modified'])->format('d F, Y') }}
                                                </p> --}}
                                            </div>
                                            <div class="col-md-6">
                                                @if(isset($fileInfo['content']['features']))
                                                    <p class="mb-1">
                                                        <strong>Jumlah Data:</strong> {{ count($fileInfo['content']['features']) }} fitur
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Tipe:</strong> {{ $fileInfo['content']['type'] ?? 'Unknown' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Format:</strong> GeoJSON
                                                    </p>
                                                @else
                                                    <p class="mb-1 text-warning">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Struktur file tidak valid
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            File <strong>drainase.json</strong> belum tersedia di <code>public/maps/</code>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }

    .card.border-primary .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card.border-success .card-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .card.border-warning .card-header {
        background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    #submitBtn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    code {
        background-color: #f8f9fa;
        padding: 2px 5px;
        border-radius: 3px;
        font-size: 0.9em;
    }

    .badge {
        font-size: 0.75em;
        padding: 0.25em 0.6em;
    }
</style>
@endpush

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('geojson_file');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileType = document.getElementById('fileType');
        const uploadForm = document.getElementById('uploadForm');
        const submitBtn = document.getElementById('submitBtn');

        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                // Validasi ukuran file (max 10MB)
                const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar! Maksimal 10MB.');
                    fileInput.value = '';
                    filePreview.classList.add('d-none');
                    return;
                }

                // Validasi tipe file
                const allowedTypes = ['application/json', 'text/json'];
                if (!allowedTypes.includes(file.type) && !file.name.toLowerCase().endsWith('.json') && !file.name.toLowerCase().endsWith('.geojson')) {
                    alert('Format file tidak didukung! Hanya file .json atau .geojson yang diperbolehkan.');
                    fileInput.value = '';
                    filePreview.classList.add('d-none');
                    return;
                }

                // Update preview
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileType.textContent = file.type || 'application/json';
                filePreview.classList.remove('d-none');

                // Validasi JSON structure (preview)
                validateJSONFile(file);
            } else {
                filePreview.classList.add('d-none');
            }
        });

        // Handle form submission
        uploadForm.addEventListener('submit', function(e) {
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Pilih file GeoJSON terlebih dahulu!');
                return;
            }

            // Disable submit button dan tampilkan loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...';

            // Bisa juga tambahkan delay untuk validasi final
            setTimeout(() => {
                // Submit form
                return true;
            }, 100);
        });

        // Validasi JSON structure
        function validateJSONFile(file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                try {
                    const json = JSON.parse(e.target.result);

                    // Validasi struktur GeoJSON dasar
                    if (!json.type || !json.features) {
                        showValidationError('Struktur GeoJSON tidak valid! Pastikan file memiliki "type" dan "features".');
                    } else if (!Array.isArray(json.features)) {
                        showValidationError('"features" harus berupa array!');
                    } else if (json.features.length === 0) {
                        showValidationError('Tidak ada data features dalam file!');
                    } else {
                        // Validasi setiap feature
                        let validFeatures = 0;
                        json.features.forEach((feature, index) => {
                            if (feature.type === 'Feature' && feature.geometry && feature.properties) {
                                validFeatures++;
                            }
                        });

                        if (validFeatures === 0) {
                            showValidationError('Tidak ada fitur yang valid dalam file!');
                        } else if (validFeatures < json.features.length) {
                            showWarning(`${validFeatures} dari ${json.features.length} fitur valid. Beberapa fitur mungkin tidak akan ditampilkan.`);
                        } else {
                            showSuccess(`${json.features.length} fitur valid ditemukan.`);
                        }
                    }
                } catch (error) {
                    showValidationError('File bukan JSON yang valid! Error: ' + error.message);
                }
            };

            reader.onerror = function() {
                showValidationError('Gagal membaca file!');
            };

            reader.readAsText(file);
        }

        function showValidationError(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Remove previous alerts
            const existingAlerts = document.querySelectorAll('#filePreview .alert-danger, #filePreview .alert-warning, #filePreview .alert-success');
            existingAlerts.forEach(alert => alert.remove());

            filePreview.querySelector('.alert-info').after(alertDiv);
        }

        function showWarning(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning alert-dismissible fade show mt-3';
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const existingAlerts = document.querySelectorAll('#filePreview .alert-danger, #filePreview .alert-warning, #filePreview .alert-success');
            existingAlerts.forEach(alert => alert.remove());

            filePreview.querySelector('.alert-info').after(alertDiv);
        }

        function showSuccess(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const existingAlerts = document.querySelectorAll('#filePreview .alert-danger, #filePreview .alert-warning, #filePreview .alert-success');
            existingAlerts.forEach(alert => alert.remove());

            filePreview.querySelector('.alert-info').after(alertDiv);
        }

        function clearFile() {
            fileInput.value = '';
            filePreview.classList.add('d-none');
            const existingAlerts = document.querySelectorAll('#filePreview .alert-danger, #filePreview .alert-warning, #filePreview .alert-success');
            existingAlerts.forEach(alert => alert.remove());
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    });
</script>
@endpush
