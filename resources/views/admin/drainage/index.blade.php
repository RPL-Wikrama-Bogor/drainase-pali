@extends('templates.layout')

@push('style')
    <style>
        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }
        .img-thumbnail {
            width: 100px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
        }
        .img-thumbnail:hover {
            border-color: #0d6efd;
            transform: scale(1.05);
        }
        .no-image {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 1px dashed #dee2e6;
            border-radius: 0.375rem;
            color: #6c757d;
        }
        .modal-img {
            max-width: 100%;
            max-height: 70vh;
            object-fit: contain;
        }
        .badge-status {
            font-size: 0.8em;
        }
        .preview-container {
            margin-top: 10px;
            text-align: center;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
            display: none;
        }
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="container" style="margin-top: 5%">
        <!-- Alert Notifikasi -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-water me-2"></i>Data Drainase
                            </h3>
                            <span class="badge bg-light text-dark">
                                Total: {{ $features->count() }} Data
                            </span>
                            <div>
                                <a href="{{route('admin.drainase.import')}}" class="btn btn-light"><i class="fas fa-file-import me-2"></i> Import Drainase</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="drainaseTable" class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Ruas</th>
                                        <th>Fungsi Jalan</th>
                                        <th>Foto</th>
                                        <th>Catatan</th>
                                        <th></th>
                                        <th>POSISI</th>
                                        <th>SEGMEN</th>
                                        <th>X</th>
                                        <th>Y</th>
                                        <th>DRN STAT</th>
                                        <th>JNS SAL</th>
                                        <th>JNS PNPG</th>
                                        <th>DIM PNPG</th>
                                        <th>JNS KONS</th>
                                        <th>KONDISI</th>
                                        <th>PANJANG (m)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($features as $index => $feature)
                                        @php
                                            $props = $feature['properties'];
                                            $identifier = $props['SEGMEN'] ?? ($props['NAMA_RUAS'] ?? 'feature_' . $index);
                                            $namaRuas = $props['NAMA_RUAS'] ?? 'Tidak Ada Nama';
                                            $hasImage = $images->has($identifier);
                                            $imageData = $hasImage ? $images[$identifier] : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $namaRuas }}</td>
                                            <td>{{ $props['FUNGSI_JLN'] }}</td>
                                            <td>
                                                @if($hasImage && $imageData)
                                                    <div class="text-center">
                                                        <img src="{{ $imageData->image_url }}"
                                                             alt="Gambar {{ $namaRuas }}"
                                                             class="img-thumbnail"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#imageModal"
                                                             data-image="{{ $imageData->image_url }}"
                                                             data-description="{{ $imageData->description ?? 'Tidak ada deskripsi' }}"
                                                             data-filename="{{ $imageData->original_name }}"
                                                             data-size="{{ round($imageData->size / 1024, 2) }} KB">
                                                        <small class="d-block mt-1 text-muted">
                                                            {{ $imageData->original_name }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <div class="no-image">
                                                        <i class="fas fa-image fa-2x"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{$imageData->description ?? 'Tidak ada deskripsi'}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($hasImage)
                                                        <button class="btn btn-warning btn-sm me-1 edit-image-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editImageModal"
                                                                data-id="{{ $imageData->id }}"
                                                                data-identifier="{{ $identifier }}"
                                                                data-nama-ruas="{{ $namaRuas }}"
                                                                data-description="{{ $imageData->description ?? '' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm delete-image-btn"
                                                                data-id="{{ $imageData->id }}"
                                                                data-nama-ruas="{{ $namaRuas }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <a href="{{ route('admin.drainase.download-image', $imageData->id) }}"
                                                           class="btn btn-info btn-sm ms-1"
                                                           title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-primary btn-sm upload-image-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#uploadImageModal"
                                                                data-identifier="{{ $identifier }}"
                                                                data-nama-ruas="{{ $namaRuas }}">
                                                            <i class="fas fa-upload"></i> Upload
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $props['POSISI'] }}</td>
                                            <td>{{ $props['SEGMEN'] ?? '-' }}</td>
                                            <td>{{ $props['X'] }}</td>
                                            <td>{{ $props['Y'] }}</td>
                                            <td>{{ $props['DRN_STAT'] }}</td>
                                            <td>{{ $props['JNS_SAL'] }}</td>
                                            <td>{{ $props['JNS_PNPG'] }}</td>
                                            <td>{{ $props['DIM_PNPG'] }}</td>
                                            <td>{{ $props['JNS_KONS'] }}</td>
                                            <td>{{ $props['KOND_PNPG'] }}</td>
                                            <td>{{ $props['PANJANG_M'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Upload Gambar -->
    <div class="modal fade" id="uploadImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Upload Gambar Drainase</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="uploadImageForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="identifier" id="uploadIdentifier">
                        <input type="hidden" name="nama_ruas" id="uploadNamaRuas">

                        <div class="mb-3">
                            <label for="image" class="form-label">Pilih Gambar *</label>
                            <input type="file" class="form-control" id="image" name="image"
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" required>
                            <div class="form-text">Maksimal 5MB. Format: JPG, PNG, GIF, WebP</div>
                            <div class="error-message" id="imageError"></div>
                        </div>

                        <div class="preview-container">
                            <img id="imagePreview" class="image-preview img-thumbnail" alt="Preview">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                      placeholder="Masukkan deskripsi gambar..."></textarea>
                            <div class="error-message" id="descriptionError"></div>
                        </div>

                        <div class="loading-spinner" id="uploadLoading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Mengupload gambar...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="uploadBtn">
                            <i class="fas fa-upload me-1"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Gambar -->
    <div class="modal fade" id="editImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Gambar Drainase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editImageForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editImageId">
                        <input type="hidden" name="identifier" id="editIdentifier">

                        <div class="mb-3">
                            <label class="form-label">Nama Ruas</label>
                            <input type="text" class="form-control" id="editNamaRuas" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="editImage" class="form-label">Gambar Baru</label>
                            <input type="file" class="form-control" id="editImage" name="image"
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            <div class="form-text">Kosongkan jika tidak ingin mengganti gambar</div>
                            <div class="error-message" id="editImageError"></div>
                        </div>

                        <div class="preview-container">
                            <img id="editImagePreview" class="image-preview img-thumbnail" alt="Preview">
                        </div>

                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                            <div class="error-message" id="editDescriptionError"></div>
                        </div>

                        <div class="loading-spinner" id="editLoading">
                            <div class="spinner-border text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Mengupdate gambar...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning" id="editBtn">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Gambar Drainase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="modal-img img-fluid rounded">
                    <div class="mt-3">
                        <p id="modalDescription" class="text-muted"></p>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>Nama File:</strong> <span id="modalFilename"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Ukuran:</strong> <span id="modalSize"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="modalDownloadBtn" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Download
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#drainaseTable').DataTable({
                "pageLength": 25,
                "lengthMenu": [10, 25, 50, 100],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari total _MAX_ data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "order": [[0, 'asc']],
                "responsive": true
            });

            // Preview gambar sebelum upload
            function previewImage(input, previewElement) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewElement).attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Handle upload image modal
            $('#uploadImageModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var identifier = button.data('identifier');
                var namaRuas = button.data('nama-ruas');

                $('#uploadIdentifier').val(identifier);
                $('#uploadNamaRuas').val(namaRuas);
                $('#imagePreview').hide();
                $('#imageError').text('');
                $('#descriptionError').text('');
            });

            // Preview gambar di modal upload
            $('#image').change(function() {
                previewImage(this, '#imagePreview');
            });

            // Handle edit image modal
            $('#editImageModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var identifier = button.data('identifier');
                var namaRuas = button.data('nama-ruas');
                var description = button.data('description');

                $('#editImageId').val(id);
                $('#editIdentifier').val(identifier);
                $('#editNamaRuas').val(namaRuas);
                $('#editDescription').val(description || '');
                $('#editImagePreview').hide();
                $('#editImageError').text('');
                $('#editDescriptionError').text('');
            });

            // Preview gambar di modal edit
            $('#editImage').change(function() {
                previewImage(this, '#editImagePreview');
            });

            // Handle image preview modal
            $('#imageModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var imageSrc = button.data('image');
                var description = button.data('description');
                var filename = button.data('filename');
                var size = button.data('size');
                var id = button.closest('tr').find('.edit-image-btn').data('id');

                $('#modalImage').attr('src', imageSrc);
                $('#modalDescription').text(description || 'Tidak ada deskripsi');
                $('#modalFilename').text(filename);
                $('#modalSize').text(size);

                if (id) {
                    $('#modalDownloadBtn').attr('href', `/drainase/image/${id}/download`);
                } else {
                    $('#modalDownloadBtn').hide();
                }
            });

            // Submit upload form
            $('#uploadImageForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var uploadBtn = $('#uploadBtn');
                var loadingSpinner = $('#uploadLoading');

                // Reset error messages
                $('.error-message').text('');

                // Disable button dan show loading
                uploadBtn.prop('disabled', true);
                loadingSpinner.show();

                $.ajax({
                    url: '{{ route("admin.drainase.upload-image") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Gambar berhasil diupload!');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + 'Error').text(value[0]);
                            });
                        } else {
                            alert('Terjadi kesalahan saat mengupload gambar');
                        }
                        uploadBtn.prop('disabled', false);
                        loadingSpinner.hide();
                    }
                });
            });

            // Submit edit form
            $('#editImageForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var id = $('#editImageId').val();
                var editBtn = $('#editBtn');
                var loadingSpinner = $('#editLoading');

                // Reset error messages
                $('.error-message').text('');

                // Disable button dan show loading
                editBtn.prop('disabled', true);
                loadingSpinner.show();

                $.ajax({
                    url: '/drainase/update-image/' + id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Gambar berhasil diupdate!');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#edit' + key.charAt(0).toUpperCase() + key.slice(1) + 'Error').text(value[0]);
                            });
                        } else {
                            alert('Terjadi kesalahan saat mengupdate gambar');
                        }
                        editBtn.prop('disabled', false);
                        loadingSpinner.hide();
                    }
                });
            });

            // Handle delete image
            $(document).on('click', '.delete-image-btn', function() {
                if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                    var id = $(this).data('id');
                    var namaRuas = $(this).data('nama-ruas');
                    var button = $(this);

                    button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: '/drainase/delete-image/' + id,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                alert('Gambar berhasil dihapus!');
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan saat menghapus gambar');
                            button.prop('disabled', false).html('<i class="fas fa-trash"></i>');
                        }
                    });
                }
            });

            // Add CSRF token to all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endpush
