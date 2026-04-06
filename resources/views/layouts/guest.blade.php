<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Custom Bootstrap Stylesheet with Purple Theme (Same as landing page) -->
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">

    <!-- Google Fonts for rounded, friendly feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/f714303560.js" crossorigin="anonymous"></script>

    @vite([])
    @stack('page_style')

    <style>
        html,
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f8f9fa;
            /* bg-light matching landing */
            overflow-x: clip;
            /* Fix for position: sticky inside body */
        }

        .menu-card {
            transition: transform 0.3s ease;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .menu-card:hover {
            transform: translateY(-10px);
        }

        .rounded-40 {
            border-radius: 40px !important;
        }

        .filter-section {
            background-color: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        }

        .vendor-badge {
            font-size: 0.8rem;
            padding: 4px 12px;
            background-color: #e9ecef;
            color: #495057;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 10px;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-light">

    <!-- NAV BAR -->
    <div class="pt-4 px-5 m-0 w-100 bg-white d-flex justify-content-between flex-wrap shadow-sm pb-3"
        style="position: sticky; top: 0; z-index: 1030;">
        <a href="/" class="text-decoration-none">
            <h3 class="fw-bold text-primary mb-4">Kantin Purpily Dessert 🍰</h3>
        </a>
        <div>
            <a class="btn btn-outline-primary {{ request()->is('products' . '*') ? 'active' : '' }} rounded-5 mx-1"
                href="{{ route('products-page') }}">
                Stores
                <i class="fa-solid fa-store"></i>
            </a>
            <a class="btn btn-outline-primary {{ request()->is('cart' . '*') ? 'active' : '' }} rounded-5 mx-1"
                href="{{ route('cart-show') }}">
                Keranjang
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
            @if(session('user_id_role'))
                <a class="btn btn-primary rounded-5 mx-1" href="/login">
                    Dashboard
                </a>
            @endif
        </div>
    </div>

    {{-- Alert Message --}}
    <x-successAlert :message="session('success')" />
    
    @if(session('error'))
    <x-error-alert :errors="session('error')" type="global" />
    @endif
    
    <x-error-alert :errors="$errors" />
    
    <!-- MAIN CONTENT -->
    <section class="py-5">
        <div class="container">

            @yield('content')

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-light border-top py-5 mt-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-primary fw-bold mb-3">Kantin Purpily Dessert</h4>
                    <p class="text-muted">Teman manis untuk setiap ceritamu.<br> Beli Dessert, Bakery, dan Kue dengan
                        mudah dan praktis.</p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary fw-bold mb-3">Lokasi & Waktu</h5>
                    <p class="text-muted mb-1">📍 Jl. Manis Buatan No. 99, Jakarta</p>
                    <p class="text-muted">🕒 Senin - Minggu: 08.00 - 20.00</p>
                </div>
                <div class="col-lg-4 col-md-12">
                    <h5 class="text-primary fw-bold mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">WhatsApp: +62 812 3456
                                7890</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Instagram:
                                @purpily.bakery</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Email:
                                hello@purpily.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-muted pt-3 border-top border-secondary-subtle">
                <small>&copy; {{ date('Y') }} Purpily Dessert & Bakery. All Rights Reserved.</small>
            </div>
        </div>
    </footer>

    @stack('script')

</body>

</html>