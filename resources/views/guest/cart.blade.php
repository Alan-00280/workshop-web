@php
    // Dummy Data Vendors
    $dummy_vendors = [
        (object) ['idvendor' => 1, 'nama_vendor' => 'Aira Bakery']
    ];

    // Dummy Data Cart Items
    $cart_items = collect([
        (object) [
            'idcart' => 101,
            'idmenu' => 1,
            'nama_menu' => 'Strawberry Shortcake',
            'harga' => 25000,
            'path_gambar' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[0],
            'quantity' => 2
        ],
        (object) [
            'idcart' => 102,
            'idmenu' => 5,
            'nama_menu' => 'Red Velvet Muffin',
            'harga' => 20000,
            'path_gambar' => 'https://images.unsplash.com/photo-1587668178277-295251f900ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[0],
            'quantity' => 1
        ],
        (object) [
            'idcart' => 103,
            'idmenu' => 6,
            'nama_menu' => 'Blueberry Cheesecake',
            'harga' => 40000,
            'path_gambar' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'vendor' => $dummy_vendors[0],
            'quantity' => 1
        ]
    ]);

    // Kalkulasi Total Harga Dummy
    $total_harga = $cart_items->sum(function($item) {
        return $item->harga * $item->quantity;
    });
@endphp

@extends('layouts.guest')
@section('title', 'Keranjang Belanja - Purpily Dessert')

@push('page_style')
<style>
    .cart-summary {
        background-color: white;
        border-radius: 20px;
        padding: 25px;
        position: sticky;
        top: 120px; /* Offset to not get covered by sticky navbar */
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
    }
    .cart-item-card {
        border-radius: 15px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .cart-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.1) !important;
    }
    .qty-input {
        width: 60px;
        text-align: center;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-weight: 600;
        color: #495057;
    }
    /* Sembunyikan arrow up/down di input number */
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .qty-input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@section('content')
<div class="row pt-2">
    <!-- Header Page -->
    <div class="col-12 mb-4 text-center text-md-start">
        <h1 class="display-5 fw-bold text-primary"><i class="fa-solid fa-cart-shopping me-3"></i>Keranjang Belanja</h1>
        <p class="text-muted fs-5">Tinjau kembali pesanan manis favoritmu sebelum membayar.</p>
    </div>

    <!-- CART ITEMS LIST -->
    <div class="col-lg-8 mb-4">
        <div id="cart-items-container">
            @forelse ($cart_items as $item)
                <div class="card border-0 bg-white cart-item-card shadow-sm mb-3 cart-item-row" data-price="{{ $item->harga }}" data-id="{{ $item->idcart }}">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center">
                            
                            <!-- Image -->
                            <div class="col-12 col-md-2 text-center text-md-start mb-3 mb-md-0">
                                <img src="{{ $item->path_gambar }}" alt="{{ $item->nama_menu }}" class="img-fluid border-3 border-white shadow-sm" style="width: 110px; height: 110px; object-fit: cover; border-radius: 15px;">
                            </div>
                            
                            <!-- Details -->
                            <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0 px-md-3">
                                <h5 class="fw-bold mb-1 text-dark">{{ $item->nama_menu }}</h5>
                                <div class="mb-2">
                                    <span class="badge bg-light text-secondary border"><i class="fa-solid fa-store me-1"></i>{{ $item->vendor->nama_vendor }}</span>
                                </div>
                                <h6 class="text-primary fw-bold mb-0">Rp {{ number_format($item->harga, 0, ',', '.') }}</h6>
                            </div>
                            
                            <!-- Quantity Control -->
                            <div class="col-6 col-md-3 text-center mb-2 mb-md-0">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle btn-minus" style="width: 30px; height: 30px; padding: 0;"><i class="fa-solid fa-minus" style="font-size: 0.8rem;"></i></button>
                                    <input type="number" class="form-control form-control-sm mx-2 qty-input" value="{{ $item->quantity }}" min="1">
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle btn-plus" style="width: 30px; height: 30px; padding: 0;"><i class="fa-solid fa-plus" style="font-size: 0.8rem;"></i></button>
                                </div>
                            </div>
                            
                            <!-- Total Price & Actions -->
                            <div class="col-6 col-md-3 text-end d-flex flex-column align-items-end justify-content-center">
                                <p class="fw-bold fs-5 mb-2 text-dark item-total-price">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</p>
                                <button type="button" class="btn btn-sm btn-outline-danger shadow-sm rounded-pill px-3 btn-remove-item"><i class="fa-regular fa-trash-can me-1"></i>Hapus</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @empty
                <!-- Original initial empty cart block -->
            @endforelse
        </div>
        
        <!-- Placeholder Empty Cart hidden initially if items exist -->
        <div class="alert alert-light text-center py-5 shadow-sm border-0 rounded-4 mt-3" id="dynamic-empty-alert" style="display: {{ $cart_items->isEmpty() ? 'block' : 'none' }};">
            <i class="fa-solid fa-box-open fs-1 text-muted mb-3 opacity-50"></i>
            <h4 class="fw-bold text-muted">Keranjang Anda kosong</h4>
            <p>Yuk, cari hidangan manis favoritmu dulu!</p>
            <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 mt-2 shadow-sm">Belanja Sekarang</a>
        </div>
    </div>

    <!-- CART SUMMARY -->
    <div class="col-lg-4 cart-summary-container">
        <div class="cart-summary border-0">
            <h4 class="fw-bold mb-4 pb-3 border-bottom text-dark">Ringkasan Belanja</h4>
            <div class="d-flex justify-content-between mb-3 text-secondary">
                <span class="summary-total-items">Total Harga ({{ $cart_items->sum('quantity') }} Produk)</span>
                <span class="summary-subtotal-price summary-total-price">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3 text-secondary">
                <span>Diskon</span>
                <span>Rp 0</span>
            </div>
            <hr class="text-black-50 border-secondary">
            <div class="d-flex justify-content-between mb-4 mt-3">
                <h5 class="fw-bold mb-0 text-dark">Total Belanja</h5>
                <h5 class="fw-bold text-primary mb-0 summary-total-price">Rp {{ number_format($total_harga, 0, ',', '.') }}</h5>
            </div>
            <button class="btn btn-primary w-100 rounded-pill py-3 shadow-sm fw-bold btn-checkout {{ $cart_items->isEmpty() ? 'disabled' : '' }}" onclick="alert('Lanjut Checkout Dummy')">Beli Sekarang (<span class="btn-checkout-count">{{ $cart_items->sum('quantity') }}</span>)</button>
        </div>
    </div>
</div>
@endsection

@push('script')
<!-- Memasukkan jQuery dari CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {

    // Fungsi format rupiah tanpa backend reload
    function formatRupiah(angka) {
        let number_string = angka.toString(),
            split = number_string.split(','),
            sisa  = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
            
        if(ribuan){
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        return 'Rp ' + rupiah;
    }

    // Fungsi untuk menghitung ulang semua rincian
    function calculateTotal() {
        let grandTotal = 0;
        let totalItems = 0;
        let itemCount = 0;

        $('.cart-item-row').each(function() {
            itemCount++;
            // Mengambil base price yang kita berikan pada atribut data-price
            let price = parseFloat($(this).data('price'));
            let qty = parseInt($(this).find('.qty-input').val());
            
            // Perbarui subtotal spesifik per baris
            let itemTotal = price * qty;
            $(this).find('.item-total-price').text(formatRupiah(itemTotal));
            
            // Masukkan ke total global
            grandTotal += itemTotal;
            totalItems += qty;
        });

        // Perbarui text pada ringkasan dan tombol beli
        $('.summary-total-items').text('Total Harga (' + totalItems + ' Produk)');
        $('.summary-total-price').text(formatRupiah(grandTotal));
        $('.btn-checkout-count').text(totalItems);

        // Jika semua row terhapus, munculkan UI 'empty-cart' & kunci checkout
        if(itemCount === 0) {
            $('.btn-checkout').addClass('disabled').attr('aria-disabled', 'true');
            $('#dynamic-empty-alert').fadeIn();
        } else {
            $('.btn-checkout').removeClass('disabled').removeAttr('aria-disabled');
            $('#dynamic-empty-alert').hide();
        }
    }

    // Mendeteksi event tombol `+` 
    $(document).on('click', '.btn-plus', function() {
        let input = $(this).siblings('.qty-input');
        let currentVal = parseInt(input.val());
        input.val(currentVal + 1);
        calculateTotal();
    });

    // Mendeteksi event tombol `-`
    $(document).on('click', '.btn-minus', function() {
        let input = $(this).siblings('.qty-input');
        let currentVal = parseInt(input.val());
        // Jangan biarkan nilai dibawah 1
        if (currentVal > 1) {
            input.val(currentVal - 1);
            calculateTotal();
        }
    });

    // Mendeteksi perubahan manual lewat pengetikan/keyboard
    $(document).on('change', '.qty-input', function() {
        let val = parseInt($(this).val());
        // Proteksi misal user masukin data aneh/huruf
        if (isNaN(val) || val < 1) {
            $(this).val(1);
        }
        calculateTotal();
    });

    // Mendeteksi event klik tong sampah (Hapus item)
    $(document).on('click', '.btn-remove-item', function() {
        var button = $(this);
        if(confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
            // FadeOut row terkait lalu jalankan calculate setelah animasi beres
            button.closest('.cart-item-row').fadeOut(300, function() {
                $(this).remove();
                calculateTotal();
            });
        }
    });
});
</script>
@endpush
