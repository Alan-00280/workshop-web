@extends('layouts.app')

@section('db-page-title', 'Profil Toko')
@section('icon-page')
    <i class="fa-solid fa-store"></i> 
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Profil Toko</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container-fluid mt-3" style="padding-left:0">
        <div class="row">
            
            <!-- Tampilan Data Toko -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-circle-info me-2"></i>Informasi Toko</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4 mt-3">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center text-primary mb-3 shadow-sm" style="width: 100px; height: 100px; font-size: 3rem;">
                                <i class="fa-solid fa-shop"></i>
                            </div>
                            <h4 class="fw-bold mb-1 text-dark">{{ $store->nama_vendor }}</h4>
                            <span class="badge bg-success px-3 py-2 rounded-pill mt-1">Buka</span>
                        </div>
                        
                        <hr class="text-muted">

                        <div class="mb-3">
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Deskripsi Toko</p>
                            <p class="mb-0 text-dark">Menyediakan berbagai macam dessert manis yang dibuat dengan penuh cinta menggunakan bahan premium.</p>
                        </div>
                        
                        <div class="mb-3">
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Titik Lokasi</p>
                            <p class="mb-0 text-dark"><i class="fa-solid fa-location-dot me-2 text-primary"></i>Jl. Manis Buatan No. 99, Jakarta</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Edit Data Toko -->
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Data Toko</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <form action="" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="nama_vendor" class="form-label fw-bold">Nama Toko *</label>
                                <input type="text" class="form-control form-control-lg" id="nama_vendor" name="nama_vendor" value="{{ $store->nama_vendor }}" required>
                                <div class="form-text">Pastikan nama toko unik dan mudah diingat oleh pembeli.</div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-bold">Deskripsi Toko</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" disabled>Menyediakan berbagai macam dessert manis yang dibuat dengan penuh cinta menggunakan bahan premium.</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="lokasi" class="form-label fw-bold">Lokasi / Alamat</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi" value="Jl. Manis Buatan No. 99, Jakarta" disabled>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top">
                                <button type="reset" class="btn btn-light px-4 border">Batal</button>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm" onclick="event.preventDefault(); alert('Simulasi form dummy. Data tidak disimpan.')">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('page_style')
<style>
    /* Styling khusus estetika panel vendor toko */
    .card.shadow-sm {
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05) !important;
        border-radius: 1rem;
    }
    .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
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
</style>
@endpush

{{-- CDNs --}}
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush