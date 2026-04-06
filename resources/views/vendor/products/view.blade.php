

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
                                <form action="{{ route('products-vendor-delete', ['id' => $product->idmenu]) }}" method="POST" class="m-0 p-0 d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="idmenu" value="{{ $product->idmenu }}">
                                    <button type="button" class="btn btn-outline-danger btn-delete rounded-pill px-3 shadow-sm d-flex justify-content-center align-items-center h-100">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
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
        <div class="d-flex justify-content-end">
            {{ $products->links() }}
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
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data produk yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
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