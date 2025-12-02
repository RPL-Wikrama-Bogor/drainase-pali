<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <title>Drainase Kabupaten PALI</title>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- jquery CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        /* Tombol Prev & Next jadi lingkaran */
        .carousel-control-prev,
        .carousel-control-next {
            width: 55px;
            height: 55px;
            background-color: #fff;
            border: 2px solid #000;
            border-radius: 50%;
            opacity: 1 !important;

            display: flex;
            justify-content: center;
            align-items: center;

            top: 50%;                   /* POSISI TENGAH VERTICAL */
            transform: translateY(-50%); /* AGAR BENAR2 TENGAH */
        }

        /* Icon panah jadi hitam */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }

        /* Sedikit hover */
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: #f3f3f3;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
        }

        .table-responsive {
            overflow-x: auto !important;
        }

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md fixed-top" style="background: #283a5ae6 !important;">
        <!-- Container wrapper -->
        <div class="container">
            <!-- Toggle button -->
            <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarButtonsExample"
                aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#"><b>WEBGIS DATABASE DRAINASE</b></a>
                    </li>
                </ul>
                <!-- Left links -->

                <div class="d-flex align-items-center">
                    <a href="{{route('home')}}" class="text-white px-3 me-2">
                        Home
                    </a>
                    <a href="{{ route('peta') }}" class="text-white px-3 me-2">
                        Peta
                    </a>
                    <a href="{{ route('data_drainase') }}" class="text-white px-3 me-2">
                        Data
                    </a>
                    <a href="{{ route('pengaduan') }}" class="text-white px-3 me-2">
                        Laporan Pengaduan
                    </a>
                    <a href="{{ route('login') }}" class="text-white btn btn-outline-warning rounded-pill px-3 me-2">
                        Masuk
                    </a>
                </div>
            </div>
            <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->

    @yield('content')

    <footer class="text-start py-3" style="background: #283a5ae6">
        <!-- Grid container -->
        <div class="container p-4">
            <!--Grid row-->
            <div class="row">
            <!--Grid column-->
            <div class="col-6 mb-4 mb-md-0 text-white">
                <img src="{{ asset('assets/logo.png') }}" width="120">
                <br>
                <br>
                <b>Alamat :</b>
                <br>
                <b>Phone :</b>
                <br>
                <b>Email :</b>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-6 mb-4 mb-md-0 text-white">
                <b>Sosial Media</b>
                <br>
                <small>Temukan kami di Media Instagram dibawah ini</small>
                <br>
                <br>
                <i class="bg-warning p-2 fab fa-instagram text-white rounded-circle mb-3"></i>
                <br>
                <i class="bg-warning p-2 fab fa-instagram text-white rounded-circle"></i>
            </div>
            <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
        <!-- Grid container -->
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous">
    </script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @stack('script')
</body>

</html>
