@php
    // Dummy Data Vendors
    $dummy_vendors = [
        (object) ['idvendor' => 1, 'nama_vendor' => 'Aira Bakery'],
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
            'vendor' => $dummy_vendors[0]
        ],
        (object) [
            'idmenu' => 3,
            'nama_menu' => 'Matcha Mille Crepes',
            'harga' => 35000,
            'path_gambar' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[0]
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
            'vendor' => $dummy_vendors[0]
        ],
        (object) [
            'idmenu' => 6,
            'nama_menu' => 'Blueberry Cheesecake',
            'harga' => 40000,
            'path_gambar' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[0]
        ],
    ]);

    // Apply random order and take 4 dummy elements 
    // This is the simulation of: MenuModel::with('vendor')->inRandomOrder()->take(4)->get()
    // $products = $all_products->shuffle()->take(4);
    $products = $all_products;

    // Vendor List
    // This is the simulation of: VendorModel::all()
    $vendors = collect($dummy_vendors);
@endphp

@extends('layouts.guest')
@section('title', 'Our Products - Purpily Dessert')

@push('page_style')
<style>
    /* Page Style Here */
</style>
@endpush

@section('content')
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Pilihan Untukmu</h1>
        <p class="text-muted fs-5">Pesan hidangan manis untuk harimu</p>
    </div>

    <!-- Filters & Sorting Options -->
    {{-- <div class="filter-section mb-5">
        <form action="" method="GET" class="row g-3 align-items-end">
            <!-- Search by Name -->
            <div class="col-md-3">
                <label for="search" class="form-label fw-bold text-muted">Cari Nama Produk</label>
                <input type="text" class="form-control rounded-pill px-3" id="search" name="search"
                    placeholder="Contoh: Cheesecake">
            </div>

            <!-- Filter by Vendor -->
            <div class="col-md-3">
                <label for="vendor" class="form-label fw-bold text-muted">Pilih Vendor</label>
                <select class="form-select rounded-pill px-3" id="vendor" name="vendor">
                    <option value="">Semua Vendor</option>
                    @foreach($vendors as $v)
                    <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter by Price Range -->
            <div class="col-md-3">
                <label class="form-label fw-bold text-muted">Rentang Harga (Maksimal)</label>
                <div class="input-group">
                    <span class="input-group-text rounded-start-pill bg-light border-end-0">Rp</span>
                    <input type="number" class="form-control rounded-end-pill border-start-0 px-2" id="max_price"
                        name="max_price" placeholder="50000">
                </div>
            </div>

            <!-- Sorting Options -->
            <div class="col-md-2">
                <label for="sort" class="form-label fw-bold text-muted">Urutkan</label>
                <select class="form-select rounded-pill px-3" id="sort" name="sort">
                    <option value="">Pilih</option>
                    <option value="price_asc">Harga Terendah</option>
                    <option value="price_desc">Harga Tertinggi</option>
                    <option value="name_asc">Nama (A-Z)</option>
                </select>
            </div>

            <div class="col-md-1 d-flex">
                <button type="button" class="btn btn-primary rounded-pill w-100 shadow-sm"
                    onclick="alert('Ini hanya data dummy. Filter belum aktif.')">Terapkan</button>
            </div>
        </form>
    </div> --}}

    <!-- Product Cards Grid (4 columns) -->
    <div class="row g-4 justify-content-center mb-5">
        @foreach ($products as $product)
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
                                {{-- <!-- Tombol ke Toko -->
                                <a class="btn btn-outline-primary p-2 rounded-pill shadow-sm fw-bold text-decoration-none d-flex align-items-center" href="{{ route('store-show', [$product->vendor->idvendor]) }}">
                                    <i class="fa-solid fa-store"></i>
                                </a> --}}

                                <!-- Tombol Tambah ke Keranjang -->
                                <button type="button" class="btn btn-primary p-2 rounded-pill shadow-sm fw-bold w-100">Tambah ke
                                    Keranjang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Our Stores</h1>
        <p class="text-muted fs-5">Buka Store Purpily Dessert & Bakery Kami</p>
    </div>

    <div class="row g-4 justify-content-center mb-5">
        @foreach ($vendors as $vendor)
            <div class="col-md-4">
                <a href="{{ route('store-show', ['id' => $vendor->idvendor]) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 bg-white menu-card shadow-sm p-4 text-center">
                        <div class="display-3 mb-3 text-primary"><i class="fa-solid fa-store"></i></div>
                        <h4 class="card-title fw-bold text-dark mb-2">{{ $vendor->nama_vendor }}</h4>
                        <p class="text-muted fs-6 mb-0">Kunjungi Toko <i class="fa-solid fa-arrow-right ms-1"></i></p>
                    </div>
                </a>
            </div>
        @endforeach
    </div> --}}
@endsection