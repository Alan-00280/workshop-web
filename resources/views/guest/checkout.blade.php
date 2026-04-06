{{-- @php
// Dummy Data Vendors
$dummy_vendors = [
(object) ['idvendor' => 1, 'nama_vendor' => 'Aira Bakery'],
(object) ['idvendor' => 2, 'nama_vendor' => 'Sweet Corner']
];

// Dummy Data Cart Items
// Data ini ditampilkan secara statis (Read-Only) pada Ringkasan Pesanan
$cart_items = collect([
(object) [
'idcart' => 101,
'idmenu' => 1,
'nama_menu' => 'Strawberry Shortcake',
'harga' => 25000,
'path_gambar' =>
'https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
'vendor' => $dummy_vendors[0],
'quantity' => 2
],
(object) [
'idcart' => 102,
'idmenu' => 5,
'nama_menu' => 'Red Velvet Muffin',
'harga' => 20000,
'path_gambar' =>
'https://images.unsplash.com/photo-1587668178277-295251f900ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
'vendor' => $dummy_vendors[1],
'quantity' => 1
],
(object) [
'idcart' => 103,
'idmenu' => 6,
'nama_menu' => 'Blueberry Cheesecake',
'harga' => 40000,
'path_gambar' =>
'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
'vendor' => $dummy_vendors[1],
'quantity' => 1
]
]);

@endphp --}}

@php
    // Kalkulasi Total Harga Dummy
    $subtotal = $cart_items->sum(function ($item) {
        return $item->menu->harga * $item->quantity;
    });

    // Biaya simulasi tambahan
    // $ongkir = 15000;
    $total_harga = $subtotal;
@endphp

@extends('layouts.guest')
@section('title', 'Checkout Pesanan - Purpily Dessert')

@push('page_style')
    <style>
        .checkout-summary {
            background-color: white;
            border-radius: 20px;
            padding: 25px;
            position: sticky;
            top: 120px;
            /* Offset to not get covered by sticky navbar */
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        }

        /* Highlight interaktif untuk Pilihan Bayar */
        .payment-option-card {
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .payment-option-card:hover {
            cursor: pointer;
            border-color: var(--bs-primary) !important;
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        /* State CSS khusus jika radio button active/terpilih */
        .payment-option-input:checked+.payment-option-card {
            border-color: var(--bs-primary) !important;
            background-color: rgba(168, 85, 247, 0.05);
            /* Sedikit ungu */
            box-shadow: 0 0 0 0.2rem rgba(168, 85, 247, 0.25);
        }
    </style>
@endpush

@section('content')
    <div class="row pt-2 pb-5">

        <!-- Bagian Header Text -->
        <div class="col-12 mb-4 text-center text-md-start">
            <h1 class="display-5 fw-bold text-primary"><i class="fa-solid fa-lock me-3"></i>Checkout Pesanan</h1>
            <p class="text-muted fs-5">Lengkapi data diri dan selesaikan pembayaran Anda secara aman.</p>
        </div>

        <!-- PENGISIAN DATA & PEMBAYARAN KIRI -->
        <div class="col-lg-7 mb-4">
            <form action="" method="POST" id="checkoutForm">
                @csrf
                <!-- Panel Informasi Meja -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-utensils me-2"></i>Informasi Pembeli
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Nama Pelanggan *</label>
                                <input type="text" class="form-control" name="nama"
                                    placeholder="Masukkan Nama Anda" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Nomor Meja *</label>
                                <input type="number" class="form-control" name="nomor_meja"
                                    placeholder="Masukkan nomor meja Anda" min="1" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Catatan Tambahan</label>
                                <input type="text" class="form-control" name="catatan"
                                    placeholder="Misal: Tidak pakai gula, atau tambah sambal.">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel Opsi Pembayaran -->
                {{-- <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-wallet me-2"></i>Metode Pembayaran</h5>
                    </div>
                    <div class="card-body p-4">

                        <div class="row g-3">

                            <!-- Opsi 1 -->
                            <div class="col-md-6 col-12">
                                <label class="w-100 h-100">
                                    <input type="radio" name="metode_pembayaran" value="transfer"
                                        class="payment-option-input d-none" checked>
                                    <div class="card border h-100 payment-option-card">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <i class="fa-solid fa-money-check-dollar fs-2 text-primary mx-2"></i>
                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-1">Transfer Bank</h6>
                                                <small class="text-muted">BCA, Mandiri, BNI, BRI</small>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Opsi 2 -->
                            <div class="col-md-6 col-12">
                                <label class="w-100 h-100">
                                    <input type="radio" name="metode_pembayaran" value="qris"
                                        class="payment-option-input d-none">
                                    <div class="card border h-100 payment-option-card">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <i class="fa-solid fa-qrcode fs-2 text-success mx-2"></i>
                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-1">QRIS Barcode</h6>
                                                <small class="text-muted">Gopay, OVO, Dana, LinkAja</small>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Opsi 3 -->
                            <div class="col-md-12 col-12">
                                <label class="w-100 h-100">
                                    <input type="radio" name="metode_pembayaran" value="cod"
                                        class="payment-option-input d-none">
                                    <div class="card border h-100 payment-option-card">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <i class="fa-solid fa-motorcycle fs-2 text-warning mx-2"></i>
                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-1">Bayar di Tempat (COD)</h6>
                                                <small class="text-muted">Bayar tunai langsung saat kurir sampai di depan
                                                    rumah Anda</small>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                        </div>

                    </div>
                </div> --}}

            </form>
        </div>

        <!-- RINGKASAN PESANAN KANAN (READ-ONLY) -->
        <div class="col-lg-5">
            <div class="checkout-summary border-0">
                <h4 class="fw-bold mb-4 pb-3 border-bottom text-dark">Pesanan Anda</h4>

                <!-- List Rincian Item Tidak Dapat Diedit Quantity-nya -->
                <div class="mb-4" style="max-height: 400px; overflow-y: auto;">
                    @foreach ($cart_items as $item)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <!-- Thumbnail Kue -->
                            <img src="{{ $item->menu->path_gambar }}" class="rounded-3 shadow-sm border"
                                style="width: 70px; height: 70px; object-fit: cover;" alt="{{ $item->menu->nama_menu }}">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="fw-bold mb-1 border-0">{{ $item->menu->nama_menu }}</h6>
                                <div class="text-muted small mb-1"><i
                                        class="fa-solid fa-store me-1"></i>{{ $item->menu->vendor->nama_vendor }}</div>
                                <div class="d-flex justify-content-between align-items-center mt-2 w-100">
                                    <span class="badge bg-light text-dark border">{{ $item->quantity }} x Rp
                                        {{ number_format($item->menu->harga, 0, ',', '.') }}</span>
                                    <span class="fw-bold text-dark">Rp
                                        {{ number_format($item->menu->harga * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between mb-2 text-secondary">
                    <span>Subtotal ({{ $cart_items->sum('quantity') }} Produk)</span>
                    <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                {{-- <div class="d-flex justify-content-between mb-2 text-secondary">
                    <span>Ongkos Kirim Estimasi</span>
                    <span class="fw-bold">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                </div> --}}

                <hr class="text-black-50 border-secondary pt-2">

                <div class="d-flex justify-content-between mb-4">
                    <h5 class="fw-bold mb-0 text-dark">Total Pembayaran</h5>
                    <h4 class="fw-bold text-primary mb-0">Rp {{ number_format($total_harga, 0, ',', '.') }}</h4>
                </div>

                <button type="button" id="pay-button"
                    class="btn btn-primary w-100 rounded-pill py-3 shadow-sm fw-bold fs-5">
                    <i class="fa-solid fa-shield-halved me-2"></i>Konfirmasi & Bayar
                </button>
                <a href="{{ route('cart-show') }}"
                    class="btn btn-light border w-100 rounded-pill py-3 shadow-sm fw-bold mt-3 text-secondary">
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    $(document).ready(function() {
        $('#pay-button').click(function(event) {
            event.preventDefault();
            
            var namaPelanggan = $('input[name="nama"]').val();
            var nomorMeja = $('input[name="nomor_meja"]').val();
            var catatan = $('input[name="catatan"]').val();

            if (!namaPelanggan || !nomorMeja) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan lengkapi Nama Pelanggan dan Nomor Meja!'
                });
                return;
            }

            snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    $.ajax({
                        url: '/checkout/save',
                        method: 'POST',
                        contentType: 'application/json',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        data: JSON.stringify({ 
                            order_id: '{{ $orderId }}',
                            nama_pelanggan: namaPelanggan,
                            nomor_meja: nomorMeja,
                            catatan: catatan,
                            payment_method: result.payment_type,
                            cart_items: {!! json_encode($cart_items) !!}
                        }),
                        success: function () {
                            window.location.href = '/checkout/sukses/{{ $orderId }}';
                        }
                    });
                },
                onPending: function (result) {
                    window.location.href = '/checkout';
                },
                onError: function (result) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: 'Pembayaran gagal diproses, silakan coba lagi.'
                    });
                },
                onClose: function () {
                    Swal.fire({
                        icon: 'info',
                        title: 'Dibatalkan',
                        text: 'Kamu menutup pop-up pembayaran sebelum selesai.'
                    });
                }
            });
        });
    });
</script>
@endpush