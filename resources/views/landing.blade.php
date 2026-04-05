<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purpily Dessert & Bakery</title>
    
    <!-- Custom Bootstrap Stylesheet with Purple Theme -->
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    
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

        /* Custom adjustments for friendly and sweet theme */
        .hero-section {
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
        }

        .menu-card {
            transition: transform 0.3s ease;
            border-radius: 20px;
            overflow: hidden;
        }

        .menu-card:hover {
            transform: translateY(-10px);
        }

        .bestseller-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--bs-warning, #ffc107); /* fallback */
            color: var(--bs-dark, #000);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            z-index: 1;
        }

        .rounded-40 {
            border-radius: 40px !important;
        }

        .step-number {
            width: 40px;
            height: 40px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: -35px; /* pull up out of card */
            position: relative;
        }
    </style>
</head>
<body class="bg-light">

    <div class="pt-4 px-5 m-0 w-100 bg-white d-flex justify-content-between flex-wrap">
        <h3 class="fw-bold text-primary mb-4">Purpily Dessert & Bakery 🍰</h3>
        <div>
            <a class="btn btn-outline-primary rounded-5 mx-1" href="{{ route('products-page') }}">
                Stores <i class="fa-solid fa-store"></i>
            </a>

            <a class="btn btn-primary rounded-5 mx-1" href="/login">
                @if(!session('user_id_role'))
                    Log in
                @else
                    Dashboard
                @endif
            </a>

            @if(session('user_id_role'))
                <a class="btn btn-outline-primary rounded-5" href="/logout">
                    Log out
                </a>
            @endif
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section bg-white shadow-sm py-5 mb-5" id="hero">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                    <h1 class="display-3 fw-bold text-primary mb-3">Manisnya Harimu Dimulai dari Sini</h1>
                    <p class="fs-5 text-muted mb-4">Beli Dessert, Bakery, dan Kue dengan mudah dan praktis untuk setiap momen spesialmu.</p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                        <a href="{{ route('products-page') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">Lihat Menu</a>
                        <a href="#order" class="btn btn-outline-primary btn-lg rounded-pill px-4">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <!-- Dummy Image placeholder -->
                    <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Berbagai macam kue dan dessert di Purpily" class="img-fluid rounded-4 shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5" id="about">
        <div class="container text-center">
            <h2 class="fw-bold text-primary mb-4">Purpily Dessert & Bakery</h2>
            <p class="fs-5 text-muted mx-auto" style="max-width: 800px;">
                Hadir untuk membawa senyum ke keseharian Anda. Kami percaya bahwa setiap potongan kue dan suapan dessert bisa menghangatkan suasana dan menjadi teman terbaik di segala situasi. Dibuat dengan bahan berkualitas dan penuh cinta, Purpily siap memanjakan lidah Anda.
            </p>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="py-5" id="menu">
        <div class="container bg-white rounded-40 shadow-sm p-4 p-md-5 my-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Produk Unggulan Kami</h2>
                <p class="text-muted fs-5">Kue favorit pelanggan yang selalu habis dipesan!</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                @foreach ( $products as $product)
                    <div class="col-md-6 col-lg-3">
                        {{-- <a href=""> --}}
                            <div class="card h-100 border-0 bg-light menu-card position-relative">
                                <div class="bestseller-badge shadow-sm">on sale</div>
                                <img src="{{ asset($product->path_gambar) }}" alt="Gambar Menu" class="card-img-top border-bottom border-3 border-white" style="height: 200px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">{{ $product->nama_menu }}</h5>
                                    <p class="card-text text-primary fw-bold fs-5 mb-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        {{-- </a> --}}
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('products-page') }}" class="btn btn-outline-primary btn-lg rounded-pill px-4">Lihat Menu Lengkapnya</a>
            </div>
        </div>
    </section>

    <!-- USP Section -->
    <section class="py-5" id="usp">
        <div class="container">
            <h2 class="fw-bold text-primary text-center mb-5">Kenapa Memilih Purpily?</h2>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="display-3 mb-3">✨</div>
                        <h4 class="fw-bold">Rasa Otentik</h4>
                        <p class="text-muted mb-0">Resep andalan yang pastinya bikin ketagihan di setiap gigitan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="display-3 mb-3">🍰</div>
                        <h4 class="fw-bold">Bahan Premium</h4>
                        <p class="text-muted mb-0">Dibuat menggunakan bahan-bahan terbaik, segar, dan berkualitas.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="display-3 mb-3">💸</div>
                        <h4 class="fw-bold">Harga Terjangkau</h4>
                        <p class="text-muted mb-0">Kualitas bintang lima, namun dengan harga yang sangat bersahabat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Section -->
    <section class="py-5" id="order">
        <div class="container bg-white rounded-40 shadow-sm p-4 p-md-5 my-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Cara Pesan Sangat Mudah</h2>
                <p class="text-muted fs-5">Tidak perlu repot, dessert kesukaanmu bisa langsung sampai di depan pintu!</p>
            </div>
            
            <div class="row g-5 justify-content-center mt-3 text-center">
                <div class="col-md-3">
                    <div class="bg-light p-4 rounded-4 h-100 mt-md-0 mt-4">
                        <div class="step-number bg-primary text-white shadow">1</div>
                        <h4 class="fw-bold mt-3">Pilih Menu</h4>
                        <p class="text-muted mb-0">Lihat berbagai pilihan kue dan dessert unggulan kami.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light p-4 rounded-4 h-100 mt-md-0 mt-4">
                        <div class="step-number bg-primary text-white shadow">2</div>
                        <h4 class="fw-bold mt-3">Tambahkan ke Keranjang</h4>
                        <p class="text-muted mb-0">Masukkan Menu Pilihanmu ke Keranjang.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light p-4 rounded-4 h-100 mt-md-0 mt-4">
                        <div class="step-number bg-primary text-white shadow">3</div>
                        <h4 class="fw-bold mt-3">Bayar</h4>
                        <p class="text-muted mb-0">Bayar dengan mudah menggunakan QRIS atau Virtual Account.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light p-4 rounded-4 h-100 mt-md-0 mt-4">
                        <div class="step-number bg-primary text-white shadow">4</div>
                        <h4 class="fw-bold mt-3">Tunggu & Nikmati</h4>
                        <p class="text-muted mb-0">Duduk manis, pesanan Anda akan segera kami antar!</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-5 d-flex gap-3 justify-content-center flex-wrap">
                <!-- Using inline colors just for the specific external brand buttons if needed, or fallback to Bootstrap btn styles -->
                <a href="#" class="btn btn-success btn-lg rounded-pill px-4 shadow-sm">
                    WhatsApp
                </a>
                <a href="#" class="btn btn-danger btn-lg rounded-pill px-4 shadow-sm">
                    GoFood
                </a>
                <a href="#" class="btn btn-success btn-lg rounded-pill px-4 shadow-sm" style="background-color: #00B14F; border-color: #00B14F;">
                    GrabFood
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="py-5" id="cta_final">
        <div class="container bg-primary text-white rounded-40 shadow p-5 text-center my-4" style="background-image: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(0,0,0,0.2));">
            <h2 class="display-5 fw-bold mb-3 text-white">Sudah Terbayang Manisnya?</h2>
            <p class="fs-5 mb-4 text-light">Jangan biarkan harimu berlalu tanpa yang manis dan melegakan. Pesan sekarang sebelum kehabisan slot harian kami!</p>
            <a href="{{ route('products-page') }}" class="btn btn-light btn-lg rounded-pill px-5 text-primary fw-bold shadow">Beli Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light border-top py-5" id="footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-primary fw-bold mb-3">Purpily Dessert & Bakery</h4>
                    <p class="text-muted">Teman manis untuk setiap ceritamu.<br> Beli Dessert, Bakery, dan Kue dengan mudah dan praktis.</p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary fw-bold mb-3">Lokasi & Waktu</h5>
                    <p class="text-muted mb-1">📍 Jl. Manis Buatan No. 99, Jakarta</p>
                    <p class="text-muted">🕒 Senin - Minggu: 08.00 - 20.00</p>
                </div>
                <div class="col-lg-4 col-md-12">
                    <h5 class="text-primary fw-bold mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">WhatsApp: +62 812 3456 7890</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Instagram: @purpily.bakery</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Email: hello@purpily.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-muted pt-3 border-top border-secondary-subtle">
                <small>&copy; {{ date('Y') }} Purpily Dessert & Bakery. All Rights Reserved.</small>
            </div>
        </div>
    </footer>

</body>
</html>
