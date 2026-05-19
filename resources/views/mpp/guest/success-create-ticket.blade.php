@extends('mpp.layouts.app')

@push('style_page')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background-color: #0b132b;
        color: #333333;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
    }

    .main-container {
        flex-grow: 1;
        padding: 2rem 1rem;
        background-color: #0b132b;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    .success-card {
        background: #ffffff;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        padding: 1.5rem 2rem;
        width: 100%;
        max-width: 450px;
        text-align: center;
    }

    .icon-success {
        color: #10b981; /* Green */
        font-size: 3rem;
        margin-bottom: 0.5rem;
    }

    .ticket-card {
        background-color: #fffbeb; /* Light cream */
        border: 2px dashed #f59e0b; /* Orange/Yellow */
        border-radius: 1rem;
        padding: 1rem;
        margin: 1rem 0;
    }

    .ticket-number {
        font-size: 3.5rem;
        font-weight: 800;
        color: #1e3a8a; /* Dark blue */
        line-height: 1;
        margin: 0.25rem 0 1rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .detail-label {
        color: #6b7280;
        text-align: left;
    }

    .detail-value {
        font-weight: 600;
        color: #1f2937;
        text-align: right;
    }

    .tracking-widest {
        letter-spacing: 0.1em;
    }
</style>
@endpush

@section('nav')
    <nav></nav>
@endsection

@section('content')
    <main class="main-container">
        <!-- Header -->
        <div class="text-center mb-2">
            <h2 class="fw-bold text-white mb-0">MPP Kita</h2>
            <p class="small text-white-50">Sistem Antrian Digital</p>
        </div>

        {{-- <x-logger-str object="{{ $antrian_created }}"/> --}}

        <!-- Card Container -->
        <div class="success-card">
            <!-- Icon Success -->
            <i class="fas fa-check-circle icon-success"></i>
            
            <!-- Title -->
            <h4 class="fw-bold text-dark mb-0">Pendaftaran Berhasil!</h4>

            <!-- Antrian Card -->
            <div class="ticket-card">
                <div class="text-uppercase small text-muted fw-bold tracking-widest">Nomor Antrian Anda</div>
                <div class="ticket-number">{{ str_pad($antrian_created->no_urut, 3, '0', STR_PAD_LEFT) }}</div>
                
                <div class="detail-grid border-top pt-3 border-warning border-opacity-25">
                    <div class="detail-row">
                        <span class="detail-label">Nama</span>
                        <span class="detail-value">{{ $antrian_created->nama }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Loket</span>
                        <span class="detail-value">{{ $antrian_created->layanan->kategoriLayanan->nama_kat ?? 'Loket Pendaftaran' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Layanan</span>
                        <span class="detail-value">{{ $antrian_created->layanan?->nama ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label text-nowrap">Waktu Daftar</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($antrian_created->waktu_daftar)->format('H.i.s') }}</span>
                    </div>
                </div>
            </div>

            <!-- Info Text -->
            <p class="small text-muted">
                Harap menunggu. Nomor akan dipanggil melalui pengeras suara dan papan antrian.
            </p>

            <!-- Actions -->
            <div class="d-flex justify-content-center mb-1">
                <a href="{{ route('mpp-show-create-ticket') }}" class="btn btn-success fw-bold px-4 py-2 rounded-pill d-flex align-items-center gap-2 shadow-sm">
                    <i class="fas fa-plus"></i> Daftar Lagi
                </a>
            </div>

            <a href="" class="btn btn-dark text-decoration-none rounded-pill">
                <i class="fa-regular fa-clipboard"></i>
                <span class="small text-light">
                    Lihat Papan Antrian
                </span>
            </a>
        </div>
    </main>
@endsection

@push('script')

@endpush
