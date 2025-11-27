@extends('templates.layout')

@section('content')
<div style="background: #f3f5fa; overflow-x: hidden; margin-top: 5%" class="mb-3">
    <div class="container py-4">
        <h5><b>Jalan Menuju Kantor Camat Talang Ubi</b></h5>
    </div>
</div>
<div class="container">
    <img src="{{asset('assets/office-road.jpg')}}" alt="" class="d-block mx-auto w-75">
    <div class="table-responsive w-100 my-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="bg-light">POSISI</th>
                    <th class="bg-light">SEGMEN</th>
                    <th class="bg-light">X</th>
                    <th class="bg-light">Y</th>
                    <th class="bg-light">DRN STAT</th>
                    <th class="bg-light">JNS SAL</th>
                    <th class="bg-light">JNS PNPG</th>
                    <th class="bg-light">DIM PNPG</th>
                    <th class="bg-light">JNS KONS</th>
                    <th class="bg-light">KOND PNPG</th>
                    <th class="bg-light">PANJANG (m)</th>
                    <th class="bg-light">FOTO</th>
                    <th class="bg-light">CATATAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($officeRoad as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item['position'] }}</td>
                        <td>{{ $item['segment'] }}</td>
                        <td>{{ $item['loc_x'] }}</td>
                        <td>{{ $item['loc_y'] }}</td>
                        <td>{{ $item['status'] }}</td>
                        <td>{{ $item['type_of_shape'] }}</td>
                        <td>{{ $item['dimension'] }}</td>
                        <td>{{ $item['material'] }}</td>
                        <td>{{ $item['material_condition'] }}</td>
                        <td>{{ $item['length'] }}</td>
                        <td>
                            <img src="{{asset('assets/'.$item['image'])}}" width="150">
                        </td>
                        <td>{{ $item['notes'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
