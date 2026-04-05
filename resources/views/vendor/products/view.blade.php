@php
    // Dummy Data Vendor
    $dummy_vendor = (object) ['idvendor' => 1, 'nama_vendor' => 'Aira Bakery'];

    // Dummy Data Products yang merujuk pada vendor Aira Bakery
    $products = collect([
        (object) [
            'idmenu' => 1,
            'nama_menu' => 'Strawberry Shortcake',
            'harga' => 25000,
            'path_gambar' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendor
        ],
        (object) [
            'idmenu' => 4,
            'nama_menu' => 'Cheese Tart',
            'harga' => 15000,
            'path_gambar' => 'https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendor
        ],
        (object) [
            'idmenu' => 7,
            'nama_menu' => 'Matcha Mille Crepes',
            'harga' => 35000,
            'path_gambar' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendor
        ],
        (object) [
            'idmenu' => 8,
            'nama_menu' => 'Classic Tiramisu',
            'harga' => 28000,
            'path_gambar' => 'https://images.unsplash.com/photo-1511381939415-e440c08212e3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendor
        ],
        (object) [
            'idmenu' => 10,
            'nama_menu' => 'Classic Tiramisu',
            'harga' => 28000,
            'path_gambar' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendor
        ],
        (object) [
            'idmenu' => 9,
            'nama_menu' => 'Classic Tiramisu',
            'harga' => 28000,
            'path_gambar' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendor
        ],
        (object) [
            'idmenu' => 11,
            'nama_menu' => 'Classic Tiramisu',
            'harga' => 28000,
            'path_gambar' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendor
        ],
        (object) [
            'idmenu' => 12,
            'nama_menu' => 'Classic Tiramisu',
            'harga' => 28000,
            'path_gambar' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendor
        ],
    ]);
@endphp

@extends('layouts.app')

@section('db-page-title', 'Daftar Produk Toko')
@section('icon-page')
    <i class="fa-solid fa-egg"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>produk</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container-fluid mt-1" style="padding-left:0">

        <!-- Header & Opsi Tambah Produk (Visual/Estetika Dashboard) -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <div>
                <h4 class="fw-bold mb-1 text-dark">Daftar Produk Anda</h4>
                <p class="text-muted mb-0">Kelola semua menu hidangan yang tersedia di etalase Anda.</p>
            </div>
            <div>
                <!-- Tambah Produk Dummy Link -->
                <a href="{{ route('products-vendor-add') }}" class="btn btn-primary rounded-pill shadow-sm px-4 fw-bold">
                    <i class="fa-solid fa-plus me-2"></i>Tambah Produk Baru
                </a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            @forelse ($products as $product)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 border-0 bg-white menu-card shadow-sm">
                        <!-- Gambar Produk -->
                        <div class="position-relative">
                            <img src="{{ $product->path_gambar }}" alt="{{ $product->nama_menu }}" class="card-img-top border-bottom border-3 border-white w-100" style="height: 200px; object-fit: cover;">
                            <!-- Harga Tag mengambang di atas gambar -->
                            <span class="badge bg-primary position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm fs-6">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="card-body d-flex flex-column text-center">
                            <!-- Nama Produk -->
                            <h5 class="card-title fw-bold text-dark mt-2 mb-2">{{ $product->nama_menu }}</h5>
                            
                            <!-- Nama Vendor (Optional Info) -->
                            <div class="mb-3">
                                <span class="badge bg-light text-secondary border border-secondary border-opacity-25 px-2 py-1"><i class="fa-solid fa-store me-1"></i>{{ $product->vendor->nama_vendor }}</span>
                            </div>
                            
                            <div class="mt-auto pt-3 border-top d-flex gap-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('products-vendor-edit', ['id' => $product->idmenu]) }}" class="btn btn-outline-primary rounded-pill w-75 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                
                                <!-- Tombol Hapus -->
                                <a href="" class="btn btn-outline-danger rounded-pill px-3 shadow-sm d-flex justify-content-center align-items-center" onclick="event.preventDefault(); alert('Dummy data tidak dapat dihapus');">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted my-5 border bg-light py-5 rounded-4 border-dashed">
                    <i class="fa-solid fa-box-open fs-1 mb-3 opacity-50"></i>
                    <h4 class="fw-bold">Belum ada produk</h4>
                    <p class="mb-0">Mulai tambahkan produk kedalam katalog toko Anda.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection

{{-- CDNs --}}
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

{{-- scripts --}}
@push('script')
    <script>
        $(document).ready(function () {
             // Opsional scripts khusus panel
        });
    </script>
@endpush

{{-- Page Style --}}
@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Styling khusus card produk di panel vendor */
        .menu-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 1rem;
            overflow: hidden;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }
        .card-img-top {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }
        .text-primary {
            color: #7e22ce !important; /* Tailwind-like purple accent used natively */
        }
        .bg-primary {
            background-color: #a855f7 !important; 
        }
        .btn-primary {
            background-color: #a855f7 !important;
            border-color: #a855f7 !important;
        }
        .btn-primary:hover {
            background-color: #9333ea !important;
            border-color: #9333ea !important;
        }
        .btn-outline-primary {
            color: #a855f7 !important;
            border-color: #a855f7 !important;
        }
        .btn-outline-primary:hover {
            background-color: #a855f7 !important;
            color: #white !important;
        }
        .border-dashed {
            border-style: dashed !important;
        }
    </style>
@endpush