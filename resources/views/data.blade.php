@extends('templates.layout')

@section('content')
    <div class="container mb-5" style="margin-top: 7%">
        <h5 class="text-center" style="color: black !important"><b>Data Drainase</b></h5>
        <hr style="background-color: #283a5ae6 !important; border: none; height: 3px">
        <p class="text-center" style="color: black !important">Lihat Data Drainase Kabupaten PALI Dalam Bentuk Tubular Data
        </p>
        <div class="table-responsive w-100">
            <table class="table table-light table-bordered" id="dataDrainage">
                <thead>
                    <tr class="text-center">
                        <th rowspan="2" class="align-middle">No.</th>
                        <th rowspan="2" class="align-middle">Nama Ruas Jalan</th>
                        <th rowspan="2" class="align-middle">Fungsi Jalan</th>
                        <th rowspan="2" class="align-middle">Panjang Sesuai SK (Km)</th>
                        <th colspan="2">Panjang Sesuai Wilayah Kajian</th>
                        <th rowspan="2"></th>
                    </tr>
                    <tr class="text-center">
                        <th class="align-middle">Km</th>
                        <th class="align-middle">M</th>
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

            $("#dataDrainage").DataTable({
                ajax: "{{ route('data.datatables') }}",
                serverSide: false,
                processing: true,
                columns: [{
                        data: null,
                        className: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // nomor otomatis
                        }
                    },
                    {
                        data: 'nama_ruas'
                    },
                    {
                        data: 'fungsi_jalan'
                    },
                    {
                        data: 'panjang_sk_km'
                    },
                    {
                        data: 'panjang_kajian_km'
                    },
                    {
                        data: 'panjang_kajian_m'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ]
            });

        });
    </script>
@endpush
