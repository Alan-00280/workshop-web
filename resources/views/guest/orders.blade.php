@extends('layouts.guest')
@section('title', 'Daftar Pesanan - Purpily Dessert')

@push('page_style')
    <style>
        .card-order {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid rgba(0,0,0,0.05) !important;
        }
        .card-order:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            background-color: #f8f9fa;
        }
        .small-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4" style="height: 100%;">
        <div class="d-flex align-items-center mb-4">
            <i class="fas fa-clipboard-list fa-2x text-primary me-3"></i>
            <h4 class="fw-bold m-0">Daftar Pesanan</h4>
        </div>

        <div class="row g-3">
            @forelse($orders as $order)
                <div class="col-12">
                    <a href="{{ route('checkout-sukses', $order->order_id) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-order">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 mb-2">
                                            {{ $order->order_id }}
                                        </span>
                                        <h6 class="text-muted small mb-0">
                                            <i class="far fa-clock me-1"></i>
                                            {{ date('d M Y, H:i', strtotime($order->timestamp)) }}
                                        </h6>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold text-dark d-block">Rp
                                            {{ number_format($order->total, 0, ',', '.') }}</span>
                                        <span class="badge bg-success small">Meja {{ $order->nomor_meja }}</span>
                                    </div>
                                </div>

                                <hr class="text-muted opacity-25">

                                <div class="row g-2 mt-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block small-label">Metode Bayar</small>
                                        <span class="text-dark fw-medium">
                                            <i class="fas fa-wallet me-1 text-secondary"></i>
                                            {{ $order->metode_bayar == 5 ? 'E-Wallet / QRIS' : 'Tunai' }}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block small-label">Catatan</small>
                                        <span class="text-dark fw-medium italic text-truncate d-block">
                                            "{{ $order->catatan ?? '-' }}"
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-3x text-light mb-3"></i>
                    <p class="text-muted">Belum ada pesanan masuk.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('script')
    <!-- Memasukkan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    </script>
@endpush