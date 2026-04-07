@extends('layouts.guest')
@section('title', 'Pesanan Gagal - Purpily Dessert')

@section('content')
    <div class="row pt-2 pb-5 justify-content-center">
        <div class="col-lg-6 col-md-8 text-center bg-white p-5 rounded-4 shadow-sm">
            <i class="fa-solid fa-circle-xmark text-error" style="font-size: 5rem;"></i>
            <h2 class="fw-bold mt-4 text-primary">Error! Pesanan Gagal</h2>
            <p class="text-muted fs-5 mb-4">Terjadi Kesalahahan</p>

            <a href="{{ route('products-page') }}"
                class="btn btn-primary rounded-pill py-3 px-4 shadow-sm fw-bold w-100 fs-5 mt-2">
                <i class="fa-solid fa-house me-2"></i>Kembali ke Halaman Utama
            </a>
        </div>
    </div>
@endsection

{{-- @push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let seconds = 8;
        const interval = setInterval(function () {
            seconds--;
            $('#countdown').text(seconds);
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = '/products';
            }
        }, 1000);
    </script>
@endpush --}}