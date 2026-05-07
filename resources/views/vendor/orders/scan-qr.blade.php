@extends('layouts.app')

@section('db-page-title', 'Scan QR Pesanan')
@section('icon-page')
    <i class="fa-solid fa-qrcode"></i>
@endsection

@section('vite')
    @vite(['resources/js/qrscanorder.js'])
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('orders-vendor-show') }}">Pesanan</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Scan QR Pesanan</x-ui.breadcrumb-item>
@endsection

@section('content')
    <button class="btn btn-primary mb-3" id="btn-camera-toggle"> 
        <i class="fa-solid fa-camera"></i> 
        Open QR
    </button>
    
    <div style="width: 100%;">
        <div style="margin: auto; width: 600px">
            <div id="reader" width="100px"></div>
        </div>
    </div>
@endsection

@push('modal')
<div class="modal fade" id="modalDetailJS" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-receipt me-2 text-primary"></i>Detail Pesanan <span class="text-primary" id="md-order-id"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <!-- Informasi Pelanggan -->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <p class="text-muted mb-1 small">Nama Pelanggan:</p>
                        <h6 class="fw-bold" id="md-nama"></h6>
                    </div>
                    <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                        <p class="text-muted mb-1 small">Status Pembayaran:</p>
                        <div id="md-status-badge"></div>
                    </div>
                </div>

                <!-- Tabel Items Rincian -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="40%">Item Produk</th>
                                <th width="15%" class="text-center">Harga</th>
                                <th width="15%" class="text-center">Qty</th>
                                <th width="30%" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="md-table-body">
                            <!-- JS akan mengisi di sini -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end border-0">Total Keseluruhan :</th>
                                <th class="text-end border-0 fs-5 text-primary" id="md-total"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary rounded-3" id="btn-scan-again">Scan Lagi</button>
            </div>
        </div>
    </div>
</div>
@endpush

{{-- CDNs Datatable & jQuery (Required) --}}
@push('page_style')
    <!-- Datatable CSS CDN -->
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.css" rel="stylesheet">
    <style>
        .card.shadow-sm {
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.05) !important;
        }
        .text-primary { color: #7e22ce !important; }
        .bg-primary { background-color: #a855f7 !important; }
        .btn-primary { background-color: #a855f7 !important; border-color: #a855f7 !important; }
        .btn-primary:hover { background-color: #9333ea !important; border-color: #9333ea !important; }
        .btn-outline-primary { color: #a855f7 !important; border-color: #a855f7 !important; }
        .btn-outline-primary:hover { background-color: #a855f7 !important; border-color: #a855f7 !important; color: white !important;}
        
        /* Custom Pagination Datatables Bootstrap 5 */
        div.dt-container .dt-paging .pagination .page-item.active .page-link {
            background-color: #a855f7;
            border-color: #a855f7;
            border-radius: 5px;
        }
    </style>
@endpush

@push('script')
    <!-- jQuery dan Datatable JS CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#ordersTable').DataTable({
                responsive: true,
                language: {
                    // ID localization untuk Datatable (Opsional, agar bahasanya Bahasa Indonesia)
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                },
                columnDefs: [
                    { orderable: false, targets: [6] } // Matikan sortir untuk kolom Aksi
                ]
            });
        });
    </script>
@endpush