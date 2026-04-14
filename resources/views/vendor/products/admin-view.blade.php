@extends('layouts.app')

@section('db-page-title', 'Daftar Semua Produk')
@section('icon-page')
    <i class="fa-solid fa-egg"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>semua_produk</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container-fluid mt-1" style="padding-left:0">

        <!-- Header & Opsi (Visual/Estetika Dashboard) -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <div>
                <h4 class="fw-bold mb-1 text-dark">Seluruh Produk Terdaftar</h4>
                <p class="text-muted mb-0">Daftar semua menu hidangan dari seluruh toko yang tersedia.</p>
            </div>
            <!-- Admin hanya bisa melihat, tidak menambah produk. Oleh karena itu, tombol Tambah Produk dihapus -->
        </div>

        <div class="row g-4 mb-5">
            @forelse ($allProducts as $product)
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
                                <span class="badge bg-light text-secondary border border-secondary border-opacity-25 px-2 py-1"><i class="fa-solid fa-store me-1"></i>{{ $product->vendor->nama_vendor ?? '-' }}</span>
                            </div>
                            
                            <div class="mt-auto pt-3 border-top d-flex justify-content-center gap-2">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 w-100">
                                    <i class="fa-solid fa-check-circle me-1"></i>Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted my-5 border bg-light py-5 rounded-4 border-dashed">
                    <i class="fa-solid fa-box-open fs-1 mb-3 opacity-50"></i>
                    <h4 class="fw-bold">Belum ada satupun produk</h4>
                    <p class="mb-0">Vendor belum menambahkan produk apapun ke dalam aplikasi.</p>
                </div>
            @endforelse
            {{ $allProducts->links() }}
        </div>
        
    </div>
@endsection

{{-- CDNs --}}
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        .border-dashed {
            border-style: dashed !important;
        }
    </style>
@endpush