@extends('layouts.app')

@section('db-page-title', 'Daftar Semua Toko')
@section('icon-page')
    <i class="fa-solid fa-store"></i> 
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Daftar Toko</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container-fluid mt-3" style="padding-left:0">
        <div class="row">
            @if($stores->isEmpty())
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm border-0" style="border-radius: 1rem;">
                        <i class="fa-solid fa-circle-info me-2"></i>Belum ada data toko.
                    </div>
                </div>
            @endif

            @foreach($stores as $store)
            <!-- Tampilan Data Toko -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-info-circle me-2"></i>Informasi Toko</h5>
                        <span class="badge bg-light text-primary rounded-pill shadow-sm">ID: {{ $store->idvendor }}</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-4 mt-3">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center text-primary mb-3 shadow-sm" style="width: 100px; height: 100px; font-size: 3rem;">
                                <i class="fa-solid fa-shop"></i>
                            </div>
                            <h4 class="fw-bold mb-1 text-dark">{{ $store->nama_vendor }}</h4>
                            {{-- <span class="badge bg-success px-3 py-2 rounded-pill mt-1">Buka</span> --}}
                        </div>
                        
                        <hr class="text-muted">

                        <div class="mb-3">
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Pemilik (User ID)</p>
                            <p class="mb-0 text-dark"><i class="fa-solid fa-user me-2 text-primary"></i>User ID: {{ $store->iduser }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Titik Lokasi</p>
                            <p class="mb-0 text-dark"><i class="fa-solid fa-location-dot me-2 text-primary"></i>Lokasi belum diatur</p>
                        </div>

                        <div class="mt-auto pt-3 pb-1 d-flex justify-content-end gap-2 border-top">
                            <button class="btn btn-outline-primary px-3 shadow-sm w-100" onclick="alert('Fitur lihat detail belum tersedia')">
                                <i class="fa-solid fa-eye me-2"></i>Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection

@push('page_style')
<style>
    /* Styling khusus estetika panel vendor toko */
    .card.shadow-sm {
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05) !important;
        border-radius: 1rem;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card.shadow-sm:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    .text-primary {
        color: #7e22ce !important; /* Tailwind-like purple accent used natively */
    }
    .bg-primary {
        background-color: #a855f7 !important; 
    }
    .btn-outline-primary {
        color: #a855f7 !important;
        border-color: #a855f7 !important;
    }
    .btn-outline-primary:hover {
        background-color: #a855f7 !important;
        color: #fff !important;
    }
</style>
@endpush

{{-- CDNs --}}
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush