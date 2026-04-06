{{-- @php
    // Dummy Data Product
    $product = (object) [
        'idmenu' => 1,
        'nama_menu' => 'Strawberry Shortcake',
        'harga' => 25000,
        'path_gambar' => asset('assets/images/menu_images/dimas_bakery/lore-schodts-8BNGxSAQd6M-unsplash.jpg'),
        'deskripsi' => 'Kue bolu super lembut dengan lapisan krim vanilla dan potongan buah strawberry segar di setiap gigitan.',
    ];
@endphp --}}

@extends('layouts.app')

@section('db-page-title', 'Edit Produk')
@section('icon-page')
    <i class="fa-solid fa-pen-to-square"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('products-vendor-show') }}">produk</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Edit Produk</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container-fluid mt-3" style="padding-left:0">
        
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-cake-candles me-2 text-primary"></i>Form Edit Data Produk</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="{{ route('products-vendor-patch', ['id' => $product->idmenu]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="idmenu" value="{{ $product->idmenu }}">
                            
                            <!-- Area Preview Foto & Input Path -->
                            <div class="row mb-5 mt-2">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <p class="fw-bold mb-2 text-start text-dark">Preview Gambar</p>
                                    <div class="img-preview-wrapper border rounded-4 d-flex align-items-center justify-content-center bg-light overflow-hidden shadow-sm" style="height: 200px; width: 100%;">
                                        <img id="image_preview" src="{{ asset($product->path_gambar) }}" alt="Preview" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3 h-100 d-flex flex-column justify-content-center">
                                        <label for="path_gambar" class="form-label fw-bold">Ubah Foto Produk *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-image text-muted"></i></span>
                                            <input type="file" class="form-control border-start-0" id="path_gambar" name="path_gambar" accept="image/*">
                                        </div>
                                        <div class="form-text mt-2">Unggah file gambar baru (JPG/PNG) untuk mengganti foto produk saat ini.</div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="text-muted opacity-25">

                            <div class="mb-4 mt-4">
                                <label for="nama_menu" class="form-label fw-bold">Nama Produk *</label>
                                <input type="text" class="form-control form-control-lg" id="nama_menu" name="nama_menu" value="{{ $product->nama_menu }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="harga" class="form-label fw-bold">Harga Produk (Rp) *</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light fw-bold text-secondary border-end-0">Rp</span>
                                    <input type="number" class="form-control border-start-0" id="harga" name="harga" value="{{ $product->harga }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-bold">Deskripsi Tambahan</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" disabled>{{ $product->deskripsi }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                                <a href="javascript:history.back()" class="btn btn-outline-secondary px-4 rounded-pill">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                                </a>
                                
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn btn-light px-4 border rounded-pill">Reset Formulir</button>
                                    <button type="submit" class="btn btn-primary px-4 shadow-sm rounded-pill fw-bold">
                                        <i class="fa-solid fa-floppy-disk me-2"></i>Update Produk
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Side Panel (Visual Information) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 bg-primary text-white text-center p-4 rounded-4" style="background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%);">
                    <i class="fa-solid fa-lightbulb fs-1 mb-3 opacity-75"></i>
                    <h5 class="fw-bold mb-3">Tips Penjualan Optimal</h5>
                    <p class="mb-0 opacity-75">Berikan gambaran jelas pada produk Anda menggunakan foto asli dan deksripsi yang jujur. Hidangan manis yang nampak cerah disukai oleh 80% pelanggan kami!</p>
                </div>
            </div>
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
            
            // JQuery Script untuk Live Preview Upload Image
            $('#path_gambar').on('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#image_preview').attr('src', '{{ $product->path_gambar }}');
                }
            });
            
            // Antisipasi Error ketika URL gambar tidak valid (broken gambar icon)
            $('#image_preview').on('error', function() {
                $(this).attr('src', 'https://via.placeholder.com/400x400?text=Gambar+Rusak/URL+Tidak+Valid');
            });

        });
    </script>
@endpush

{{-- Page Style --}}
@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .card.shadow-sm {
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05) !important;
            border-radius: 1rem;
        }
        .form-control:focus, .input-group-text {
            border-color: var(--bs-primary);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
        }
        .text-primary {
            color: #7e22ce !important; /* Tema aksen ungu kustom */
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
            border-color: #a855f7 !important;
            color: white !important;
        }
        /* Menghilangkan panah atas/bawah pada number field Harga */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush