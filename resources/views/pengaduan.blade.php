@extends('templates.layout')

@section('content')
<div style="background: #f3f5fa; overflow-x: hidden; margin-top: 5%" class="mb-3">
    <div class="container py-4">
        <h5><b>Daftar Laporan Pengaduan Masyarakat</b></h5>
    </div>
</div>
<div class="container">
    <div class="table-responsive w-100">
        <table class="table table-bordered" id="dataComplaint">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(function() {
            $("#dataComplaint").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pengaduan.datatables') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'location', name: 'location', orderable: false,},
                    { data: 'notes', name: 'notes', orderable: false,},
                    { data: 'status', name: 'status', orderable: false,},
                    { data: 'date', name: 'date', orderable: false,},
                    { data: 'imgSrc', name: 'imgSrc', orderable: false,},
                ]
            })
        })
    </script>
@endpush
