{{-- @php
    $pesanans = [
        ['nama' => 'Budi Santoso', 'total' => 41000, 'metode_bayar' => 'cash', 'status_bayar' => 'lunas'],
        ['nama' => 'Siti Rahayu', 'total' => 35000, 'metode_bayar' => 'transfer', 'status_bayar' => 'lunas'],
        ['nama' => 'Andi Wijaya', 'total' => 58000, 'metode_bayar' => 'cash', 'status_bayar' => 'lunas'],
        ['nama' => 'Dewi Lestari', 'total' => 26000, 'metode_bayar' => 'transfer', 'status_bayar' => 'belum_lunas'],
        ['nama' => 'Rizky Pratama', 'total' => 47000, 'metode_bayar' => 'cash', 'status_bayar' => 'lunas'],
        ['nama' => 'Maya Putri', 'total' => 33000, 'metode_bayar' => 'transfer', 'status_bayar' => 'lunas'],
        ['nama' => 'Fajar Nugroho', 'total' => 62000, 'metode_bayar' => 'cash', 'status_bayar' => 'belum_lunas'],
        ['nama' => 'Laila Fitriani', 'total' => 29000, 'metode_bayar' => 'transfer', 'status_bayar' => 'lunas'],
    ];

    $detailPesanans = [
        // Pesanan 1 - Budi Santoso (total: 41000)
        ['idmenu' => 1, 'nama_menu' => 'Strawberry Shortcake', 'idpesanan' => 1, 'jumlah' => 1, 'harga' => 15000, 'subtotal' => 15000, 'catatan' => ''],
        ['idmenu' => 3, 'nama_menu' => 'Choco Berry Layer', 'idpesanan' => 1, 'jumlah' => 2, 'harga' => 13000, 'subtotal' => 26000, 'catatan' => 'tanpa mentega'],

        // Pesanan 2 - Siti Rahayu (total: 35000)
        ['idmenu' => 4, 'nama_menu' => 'Cheese Tart', 'idpesanan' => 2, 'jumlah' => 1, 'harga' => 25000, 'subtotal' => 25000, 'catatan' => ''],
        ['idmenu' => 9, 'nama_menu' => 'Kue Kering', 'idpesanan' => 2, 'jumlah' => 1, 'harga' => 8000, 'subtotal' => 8000, 'catatan' => ''],
        ['idmenu' => 2, 'nama_menu' => 'Coklat Batang', 'idpesanan' => 2, 'jumlah' => 1, 'harga' => 13000, 'subtotal' => 13000, 'catatan' => ''],

        // Pesanan 3 - Andi Wijaya (total: 58000)
        ['idmenu' => 5, 'nama_menu' => 'Muffin Coklat', 'idpesanan' => 3, 'jumlah' => 1, 'harga' => 20000, 'subtotal' => 20000, 'catatan' => 'buahnya pisang'],
        ['idmenu' => 6, 'nama_menu' => 'Roti Isi', 'idpesanan' => 3, 'jumlah' => 1, 'harga' => 18000, 'subtotal' => 18000, 'catatan' => ''],
        ['idmenu' => 8, 'nama_menu' => 'Classic Tiramisu', 'idpesanan' => 3, 'jumlah' => 1, 'harga' => 22000, 'subtotal' => 22000, 'catatan' => 'extra topping'],

        // Pesanan 4 - Dewi Lestari (total: 26000)
        ['idmenu' => 2, 'nama_menu' => 'Coklat Batang', 'idpesanan' => 4, 'jumlah' => 2, 'harga' => 13000, 'subtotal' => 26000, 'catatan' => ''],

        // Pesanan 5 - Rizky Pratama (total: 47000)
        ['idmenu' => 7, 'nama_menu' => 'Matcha Mille Crepes', 'idpesanan' => 5, 'jumlah' => 1, 'harga' => 12000, 'subtotal' => 12000, 'catatan' => ''],
        ['idmenu' => 4, 'nama_menu' => 'Cheese Tart', 'idpesanan' => 5, 'jumlah' => 1, 'harga' => 25000, 'subtotal' => 25000, 'catatan' => 'well done'],
        ['idmenu' => 9, 'nama_menu' => 'Kue Kering', 'idpesanan' => 5, 'jumlah' => 1, 'harga' => 8000, 'subtotal' => 8000, 'catatan' => ''],
        ['idmenu' => 1, 'nama_menu' => 'Strawberry Shortcake', 'idpesanan' => 5, 'jumlah' => 1, 'harga' => 15000, 'subtotal' => 15000, 'catatan' => ''],

        // Pesanan 6 - Maya Putri (total: 33000)
        ['idmenu' => 6, 'nama_menu' => 'Roti Isi', 'idpesanan' => 6, 'jumlah' => 1, 'harga' => 18000, 'subtotal' => 18000, 'catatan' => 'coklat extra'],
        ['idmenu' => 9, 'nama_menu' => 'Kue Kering', 'idpesanan' => 6, 'jumlah' => 1, 'harga' => 8000, 'subtotal' => 8000, 'catatan' => ''],
        ['idmenu' => 3, 'nama_menu' => 'Choco Berry Layer', 'idpesanan' => 6, 'jumlah' => 1, 'harga' => 13000, 'subtotal' => 13000, 'catatan' => ''],

        // Pesanan 7 - Fajar Nugroho (total: 62000)
        ['idmenu' => 8, 'nama_menu' => 'Classic Tiramisu', 'idpesanan' => 7, 'jumlah' => 2, 'harga' => 22000, 'subtotal' => 44000, 'catatan' => ''],
        ['idmenu' => 5, 'nama_menu' => 'Muffin Coklat', 'idpesanan' => 7, 'jumlah' => 1, 'harga' => 20000, 'subtotal' => 20000, 'catatan' => 'buah campuran'],

        // Pesanan 8 - Laila Fitriani (total: 29000)
        ['idmenu' => 7, 'nama_menu' => 'Matcha Mille Crepes', 'idpesanan' => 8, 'jumlah' => 1, 'harga' => 12000, 'subtotal' => 12000, 'catatan' => 'manis'],
        ['idmenu' => 9, 'nama_menu' => 'Kue Kering', 'idpesanan' => 8, 'jumlah' => 1, 'harga' => 8000, 'subtotal' => 8000, 'catatan' => ''],
        ['idmenu' => 1, 'nama_menu' => 'Strawberry Shortcake', 'idpesanan' => 8, 'jumlah' => 1, 'harga' => 15000, 'subtotal' => 15000, 'catatan' => ''],
    ];

    // Fungsi helper lokal untuk mengelompokkan detail
    $groupedDetails = [];
    foreach ($detailPesanans as $detail) {
        $groupedDetails[$detail['idpesanan']][] = $detail;
    }
@endphp --}}

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
                            {{ count(array_filter($pesanans, fn($p) => $p['status_bayar'] === 'lunas')) }}
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
                                $orderId = $index + 1; // mapping ke idpesanan dummy
                                $badgeClass = $order['status_bayar'] === 'lunas' ? 'bg-success' : 'bg-warning text-dark';
                                $statusText = $order['status_bayar'] === 'lunas' ? 'Lunas' : 'Belum Lunas';
                                $metodeText = strtoupper($order['metode_bayar']);
                            @endphp
                            <tr>
                                <td class="text-center">{{ $orderId }}</td>
                                <td class="fw-bold text-secondary">INV-{{ str_pad($orderId, 5, "0", STR_PAD_LEFT) }}</td>
                                <td class="fw-bold text-dark">{{ $order['nama'] }}</td>
                                <td>Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                                <td>
                                    @if($order['metode_bayar'] == 'cash')
                                        <i class="fa-solid fa-money-bill-wave text-success me-1"></i> 
                                    @else
                                        <i class="fa-solid fa-money-check-dollar text-primary me-1"></i> 
                                    @endif
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
            $orderId = $index + 1;
            $details = $groupedDetails[$orderId] ?? [];
        @endphp
        <div class="modal fade" id="modalDetail{{ $orderId }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $orderId }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">
                    
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold" id="modalDetailLabel{{ $orderId }}">
                            <i class="fa-solid fa-receipt me-2 text-primary"></i>Detail Pesanan <span class="text-primary">INV-{{ str_pad($orderId, 5, "0", STR_PAD_LEFT) }}</span>
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
                                <span class="badge {{ $order['status_bayar'] === 'lunas' ? 'bg-success' : 'bg-warning text-dark' }} px-3 rounded-pill">
                                    {{ $order['status_bayar'] === 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}
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
                                        <th class="text-end border-0 fs-5 text-primary">Rp {{ number_format($order['total'], 0, ',', '.') }}</th>
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