@extends('templates.layout')

@section('content')
<div style="background: #f3f5fa; overflow-x: hidden; padding-top: 5%">
    <div class="container">
        <div class="row py-5 w-100">
            <div class="col-12 col-md-3 d-flex justify-content-center">
                <img src="{{asset('assets/logo.png')}}" class="w-100">
            </div>
            <div class="col-12 col-md-8 pt-4">
                <h5 style="color: #283a5ae6"><b>PEMERINTAH KABUPATEN PANUKAL ABAB LEMATANG ILIR</b></h5>
                <h4 style="color: #283a5ae6"><b>DINAS PEKERJAAN UMUM DAN TATA RUANG</b></h4>
            </div>
        </div>
    </div>
</div>
<div style="background: #283a5ae6; overflow-x: hidden; color: white">
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-sm-8">
                <h3><b>SELAMAT DATANG</b></h3>
                <h4><b>Di WebGIS Database Drainase Kabupaten Pali</b></h4>
                <p class="my-3">Portal informasi visual dan data teknis infrastuktur drainase untuk mendukung perencanaan dan pengelolaan wilayah.</p>
                <div class="d-flex">
                    <a href="" class="btn btn-warning rounded-3 me-3">Lihat Peta Drainase</a>
                    <a href="" class="btn btn-warning rounded-3">Lihat Data Drainase</a>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <img src="{{asset('assets/peta-adm-pali.webp')}}" class="w-100">
            </div>
        </div>
    </div>
</div>
<div style="background: #f3f5fa; overflow-x: hidden">
    <div class="container pt-5">
        <div class="row">
            <div class="col-12 col-md-4">
                <img src="{{asset('assets/bupati.png')}}" class="w-100" style="height: 400px">
            </div>
            <div class="col-12 col-md-7 pt-5">
                <h2 style="color: black !important"><b>SAMBUTAN BUPATI PALI</b></h2>
                <h4 style="color: black !important"><b>Asgianto, ST</b></h4>
                <p style="text-align: justify; color: black !important"> Saya menyambut baik hadirnya WebGIS Database Drainase Kabupaten PALI sebagai langkah penting dalam penyediaan data infrastruktur yang akurat dan mudah diakses. Sistem ini diharapkan dapat mendukung perencanaan, pengelolaan, dan pelayanan publik yang lebih efektif serta transparan.Terima kasih kepada seluruh pihak yang berperan dalam pengembangannya. Semoga WebGIS ini menjadi sarana yang bermanfaat bagi pembangunan Kabupaten PALI ke depan.</p>
            </div>
        </div>
    </div>
</div>
<div style="background: #283a5ae6; overflow-x: hidden; color: white">
    <div class="container pt-5 pb-4 text-center">
        <h5><b>Total Panjang Ruas Drainase Kabupate PALI</b></h5>
        <h3><b>142.700,35 meter</b></h3>
        <p>Berdasarkan Hasil Survey Tahun 2025</p>
    </div>
</div>
<div class="container my-5">
    <div id="carouselExampleControls" class="carousel slide" data-mdb-ride="carousel" data-mdb-carousel-init>
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img src="{{asset('assets/slider1.jpg')}}" class="d-block w-100" />
        </div>
        <div class="carousel-item">
        <img src="{{asset('assets/slider2.jpg')}}" class="d-block w-100" />
        </div>
        <div class="carousel-item">
        <img src="{{asset('assets/slider3.jpg')}}" class="d-block w-100" alt="Exotic Fruits"/>
        </div>
        <div class="carousel-item">
        <img src="{{asset('assets/slider4.jpg')}}" class="d-block w-100" alt="Exotic Fruits"/>
        </div>
        <div class="carousel-item">
        <img src="{{asset('assets/slider5.jpg')}}" class="d-block w-100" alt="Exotic Fruits"/>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleControls" data-mdb-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleControls" data-mdb-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    </div>
</div>
<div style="background: #f3f5fa; overflow-x: hidden">
    <div class="container py-5">
        <h4 class="text-center" style="color: black !important"><b>Berita Terbaru</b></h4>
        <hr style="background-color: #283a5ae6 !important; border: none; height: 3px">
        <p class="text-center" style="color: black !important">Lihat dan Baca Berita Terbaru Seputar Drainase Kabupaten PALI</p>
        <div class="d-flex justify-content-center mb-3 flex-wrap">
            @foreach ($news as $item)
                <div class="card p-3 m-3" style="width: 45%">
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ asset('assets/' . $item['image']) }}" class="w-100 h-100">
                        </div>
                        <div class="col-6">
                            <b>{{ $item['title'] }}</b>
                            <br>
                            <small class="text-secondary">{{ $item['content'] }}</small>
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-user pt-2"></i>
                                </div>
                                <div class="ms-2">
                                    <small>{{ $item['author'] }}</small>
                                    <br>
                                    <small class="text-secondary">{{ \Carbon\Carbon::parse($item['date'])->format('d F, Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-block mx-auto p-5" style="background: #EBF7FF;  width: 80%">
            <div class="d-flex justify-content-between w-100">
                <div>
                    <h5 style="color: black !important"><b>Infografis Terkini</b></h5>
                </div>
                <div class="d-flex">
                    <div class="bg-white px-3 py-1 rounded-circle me-2" style="border 1px solid black">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <div class="bg-white px-3 py-1 rounded-circle" style="border 1px solid black">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div>
                    <a href="" class="btn btn-primary rounded-3">Lihat Semua</a>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap mt-4">
                @foreach ($infografis as $info)
                    <div class="ms-2" style="height: 250px; width: 30%">
                        <img src="{{ asset('assets/' . $info['image']) }}" style="width: 100%; height: 100%">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
