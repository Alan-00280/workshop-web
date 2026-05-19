<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mall Pelayanan Publik</title>

    <!-- Custom Bootstrap Stylesheet with Purple Theme -->
    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts for rounded, friendly feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/f714303560.js" crossorigin="anonymous"></script>

    @vite([])

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }

        .hidden {
            display: none;
        }

        .bg-gradient-mpp {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
        }

        .hero-section {
            padding: 100px 0;
        }

        .section-padding {
            padding: 80px 0;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(75, 108, 183, 0.1);
            color: #4b6cb7;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .bg-light-blue {
            background-color: #f8f9fa;
        }

        .navmpp {
            padding: 0.625rem !important;
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            padding: 0.625rem 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
    </style>

    {{-- STYLE FOR THIS PAGE --}}
    @stack('style_page')

</head>

<body class="bg-light">
    {{-- MODAL STACK --}}
    @stack('modal')

    {{-- Alert Message --}}
    <x-successAlert :message="session('success')" />
    @if(session('error'))
    <x-error-alert :errors="session('error')" type="global" />
    @endif
    <x-error-alert :errors="$errors" />

    @hasSection('nav')
        @yield('nav')
    @else
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top navmpp">
        <div class="container">
            <a class="nav-left text-decoration-none" href="/mpp">
                <h2 class="fw-bold mb-0 text-white">MPP Kita</h2>
                <p class="mb-0 text-muted small">Sistem Antrian Digital</p>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('mpp-show-create-ticket') }}">Daftar Antrian</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#informasi">Informasi</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-2 text-white" href="/login">Masuk</a></li>
                </ul>
            </div>
        </div>
    </nav>
    @endif

    <section style="min-height: 100vh">
        {{-- CONTENT --}}
        @yield('content')
    </section>


    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3 text-primary">MPP Kita</h5>
                    <p class="small text-white">Mall Pelayanan Publik hadir untuk memberikan kemudahan, kecepatan,
                        keterjangkauan, dan kenyamanan pelayanan kepada masyarakat.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#"
                            class="text-white bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"
                            class="text-white bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;"><i class="fab fa-twitter"></i></a>
                        <a href="#"
                            class="text-white bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;"><i class="fab fa-instagram"></i></a>
                        <a href="#"
                            class="text-white bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3">Tentang</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Visi & Misi</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Sejarah</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3">Layanan</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="    text-white text-decoration-none">Daftar Layanan</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Kategori</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Antrian Online</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">Kontak & Bantuan</h6>
                    <ul class="list-unstyled small text-white">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Jl. Pahlawan No. 1,
                            Kota Pusat</li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i> (021) 1234567</li>
                        <li class="mb-2"><i class="fab fa-whatsapp me-2 text-success"></i> 0812-3456-7890</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> info@mppkita.go.id</li>
                    </ul>
                </div>
            </div>
            <div
                class="border-top border-secondary pt-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="small text-muted mb-0">&copy; <span id="year"></span> Mall Pelayanan Publik. Hak Cipta
                    Dilindungi.</p>
                <ul class="list-inline small mb-0 mt-2 mt-md-0">
                    <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none">Kebijakan
                            Privasi</a></li>
                    <li class="list-inline-item">&middot;</li>
                    <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none">Syarat &
                            Ketentuan</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
    
    {{-- STACK FOR SCRIPT --}}
    @stack('script')

</body>

</html>