{{-- @php
    // Dummy Data Vendors
    $dummy_vendors = [
        (object) ['idvendor' => 1, 'nama_vendor' => 'Aira Bakery'],
        (object) ['idvendor' => 2, 'nama_vendor' => 'Sweet Corner'],
        (object) ['idvendor' => 3, 'nama_vendor' => 'Dessert Hub']
    ];

    // Dummy Data Products
    $all_products = collect([
        (object) [
            'idmenu' => 1,
            'nama_menu' => 'Strawberry Shortcake',
            'harga' => 25000,
            'path_gambar' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[0]
        ],
        (object) [
            'idmenu' => 2,
            'nama_menu' => 'Chocolate Lava',
            'harga' => 30000,
            'path_gambar' => 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[1]
        ],
        (object) [
            'idmenu' => 3,
            'nama_menu' => 'Matcha Mille Crepes',
            'harga' => 35000,
            'path_gambar' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[2]
        ],
        (object) [
            'idmenu' => 4,
            'nama_menu' => 'Cheese Tart',
            'harga' => 15000,
            'path_gambar' => 'https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[0]
        ],
        (object) [
            'idmenu' => 5,
            'nama_menu' => 'Red Velvet Muffin',
            'harga' => 20000,
            'path_gambar' => 'https://images.unsplash.com/photo-1587668178277-295251f900ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[1]
        ],
        (object) [
            'idmenu' => 6,
            'nama_menu' => 'Blueberry Cheesecake',
            'harga' => 40000,
            'path_gambar' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[2]
        ],
    ]);

    // Simulasi mengambil 1 toko berdasarkan data dummy
    $store = $dummy_vendors[0]; // Hanya ambil Aira Bakery
    
    // Ambil semua produk yang dimiliki toko ini
    $store_products = $all_products->where('vendor.idvendor', $store->idvendor);
@endphp

@extends('layouts.guest')
@section('title', $store->nama_vendor . ' - Purpily Dessert')

@push('page_style')
<style>
    .store-hero {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #a855f7 100%);
        color: white;
        border-radius: 20px;
        padding: 50px 20px;
        text-align: center;
        margin-bottom: 50px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .store-icon-large {
        font-size: 5rem;
        margin-bottom: 20px;
        text-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .menu-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
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
@endpush

@section('content')
    <!-- Store Header Section -->
    <div class="store-hero">
        <div class="store-icon-large"><i class="fa-solid fa-store"></i></div>
        <h1 class="display-3 fw-bold mb-3">{{ $store->nama_vendor }}</h1>
        <p class="fs-4 mb-0 opacity-75">Toko Pilihan Purpily Dessert & Bakery</p>
    </div>

    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-primary">Semua Produk</h2>
        <p class="text-muted fs-5">Daftar menu lezat dari {{ $store->nama_vendor }}</p>
    </div>

    <!-- Product Cards Grid -->
    <div class="row g-4 justify-content-center mb-5">
        @forelse ($store_products as $product)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 bg-white menu-card shadow-sm">
                    <!-- Gambar Produk -->
                    <img src="{{ $product->path_gambar }}" alt="{{ $product->nama_menu }}"
                        class="card-img-top border-bottom border-3 border-white" style="height: 220px; object-fit: cover;">

                    <div class="card-body d-flex flex-column text-center">
                        <!-- Nama Vendor -->
                        <div>
                            <span class="vendor-badge"><i class="bi bi-shop me-1"></i>{{ $product->vendor->nama_vendor }}</span>
                        </div>

                        <!-- Nama Produk -->
                        <h5 class="card-title fw-bold text-dark mb-2">{{ $product->nama_menu }}</h5>

                        <div class="mt-auto">
                            <!-- Harga Produk Format -->
                            <p class="card-text text-primary fw-bold fs-5 mb-3">Rp
                                {{ number_format($product->harga, 0, ',', '.') }}</p>

                            <div class="d-flex justify-content-between">
                                <!-- Tombol ke Toko (Dinonaktifkan / styling dimatikan sedikit karena sudah di halaman toko) -->
                                <button type="button" class="btn btn-outline-secondary p-2 rounded-pill shadow-sm fw-bold disabled" aria-disabled="true"><i
                                        class="fa-solid fa-store"></i></button>

                                <!-- Tombol Tambah ke Keranjang -->
                                <button type="button" class="btn btn-primary p-2 rounded-pill shadow-sm fw-bold w-75">Tambah ke
                                    Keranjang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center my-5">
                <p class="fs-4 text-muted">Belum ada produk yang tersedia di toko ini.</p>
            </div>
        @endforelse
    </div>
    
    <div class="text-center my-5">
        <a href="javascript:history.back()" class="btn btn-outline-primary rounded-pill px-4 py-2">Kembali ke Halaman Sebelumnya</a>
    </div>
@endsection --}}
