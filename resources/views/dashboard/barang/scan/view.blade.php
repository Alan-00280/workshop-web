@extends('layouts.app')

@section('db-page-title', 'Scan Barcode')
@section('icon-page')
    <i class="fa-solid fa-barcode"></i>
@endsection

@section('vite')
    @vite(['resources/js/scan.js'])
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('show-barang') }}">Barang</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Scan Barcode</x-ui.breadcrumb-item>
@endsection

@section('content')
    <button class="btn btn-primary mb-5" id="btn-camera-toggle">Open Scanner</button>
    <div id="reader" width="600px"></div>
@endsection

{{-- Modal Show Detil Barang --}}
@push('modal')
    <div class="modal fade" id="modalBarang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="row align-items-center">
                        <!-- Sisi Kiri: Icon Placeholder -->
                        <div class="col-4 text-center">
                            <div class="bg-light rounded-3 py-4">
                                <i class="fas fa-box fa-3x text-secondary"></i>
                            </div>
                        </div>
                        <!-- Sisi Kanan: Detail -->
                        <div class="col-8">
                            <small class="text-muted d-block mb-2" id="res_id_barang"></small>
                            <h4 class="fw-bold mb-2" id="res_nama_barang"></h5>
                            <h3 class="text-primary fw-bold" id="res_harga_barang"></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary w-100 rounded-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary w-100 rounded-3" id="btn-scan-again">Scan Lagi</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>

    </script>
@endpush

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('page_style')
    <style>
        .hide {
            display: none
        }
    </style>
@endpush