

@extends('layouts.app')

@section('db-page-title', 'Daftar Pesanan Toko')
@section('icon-page')
    <i class="fa-solid fa-clipboard-list"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Pesanan</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container-fluid mt-2" style="padding-left:0">
        
        <!-- Header Laporan Card -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-primary text-white rounded-3">
                    <div class="card-body">
                        <h6 class="mb-1 opacity-75">Total Pesanan</h6>
                        <h3 class="fw-bold mb-0">{{ count($pesanans) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <h6 class="mb-1 text-muted">Pesanan Lunas</h6>
                        <h3 class="fw-bold mb-0 text-success">
                            {{ count(array_filter($pesanans, fn($p) => $p['status_bayar'] === 1)) }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 mb-5">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-list-check me-2 text-primary"></i>Tabel Riwayat Pesanan</h5>
            </div>
            
            <div class="card-body p-4">
                <table id="ordersTable" class="table table-hover table-bordered w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="15%">No. Pesanan</th>
                            <th width="20%">Nama Pelanggan</th>
                            <th width="15%">Total Tagihan</th>
                            <th width="15%">Metode</th>
                            <th width="15%">Status Pembayaran</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanans as $index => $order)
                            @php
                                $orderId = $order['idpesanan'];
                                $orderIdText = $order['order_id'];
                                $badgeClass = $order['status_bayar'] === 1 ? 'bg-success' : 'bg-warning text-dark';
                                $statusText = $order['status_bayar'] === 1 ? 'Lunas' : 'Belum Lunas';
                                $metodeText = strtoupper($order['metode_bayar']);
                                $vendorTotal = $vendorTotals[$orderId] ?? 0;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $orderId }}</td>
                                <td class="fw-bold text-secondary">{{ $order['order_id'] }}</td>
                                <td class="fw-bold text-dark">{{ $order['nama'] }}</td>
                                <td>Rp {{ number_format($vendorTotal, 0, ',', '.') }}</td>
                                <td>
                                    <i class="fa-solid fa-money-check-dollar text-primary me-1"></i>
                                    {{ $metodeText }}
                                </td>
                                <td>
                                    <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">{{ $statusText }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $orderId }}">
                                        <i class="fa-solid fa-eye me-1"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Area Modal Detail Pesanan -->
    @foreach($pesanans as $index => $order)
        @php
            $orderId = $order['idpesanan'];
            $details = $groupedDetails[$orderId] ?? [];
            $vendorTotal = $vendorTotals[$orderId] ?? 0;
        @endphp
        <div class="modal fade" id="modalDetail{{ $orderId }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $orderId }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">
                    
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold" id="modalDetailLabel{{ $orderId }}">
                            <i class="fa-solid fa-receipt me-2 text-primary"></i>Detail Pesanan <span class="text-primary">{{ $order['order_id'] }}</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body p-4">
                        <!-- Informasi Pelanggan -->
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <p class="text-muted mb-1 small">Nama Pelanggan:</p>
                                <h6 class="fw-bold">{{ $order['nama'] }}</h6>
                            </div>
                            <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                                <p class="text-muted mb-1 small">Status Pembayaran:</p>
                                <span class="badge {{ $order['status_bayar'] === 1 ? 'bg-success' : 'bg-warning text-dark' }} px-3 rounded-pill">
                                    {{ $order['status_bayar'] === 1 ? 'LUNAS' : 'BELUM LUNAS' }}
                                </span>
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
                                <tbody>
                                    @forelse($details as $d)
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $d['nama_menu'] ?? 'Item #'.$d['idmenu'] }}</div>
                                                @if(!empty($d['catatan']))
                                                    <div class="text-muted small mt-1"><i class="fa-solid fa-quote-left me-1"></i>{{ $d['catatan'] }}</div>
                                                @endif
                                            </td>
                                            <td class="text-center">Rp {{ number_format($d['harga'], 0, ',', '.') }}</td>
                                            <td class="text-center">x {{ $d['jumlah'] }}</td>
                                            <td class="text-end fw-bold">Rp {{ number_format($d['subtotal'], 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Tidak ada rincian item.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end border-0">Total Keseluruhan :</th>
                                        <th class="text-end border-0 fs-5 text-primary">Rp {{ number_format($vendorTotal, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light border-top">
                        <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary px-4 rounded-pill fw-bold" onclick="alert('Print nota akan diproses...');"><i class="fa-solid fa-print me-2"></i>Cetak Nota</button>
                    </div>
                    
                </div>
            </div>
        </div>
    @endforeach

@endsection

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