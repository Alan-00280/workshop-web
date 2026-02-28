@extends('layouts.app')

@section('db-page-title', 'Preview Cetak Label')
@section('icon-page')
    <i class="fa-solid fa-boxes-stacked"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Preview Cetak</x-ui.breadcrumb-item>
@endsection

@section('content')
    {{-- @dd($books) --}}
    {{-- <x-logger :object="$books" /> --}}
    <!-- Header + Tombol -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('show-barang') }}" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Barang akan Dicetak</h5>
        </div>
        <ul class="list-group list-group-flush">
            @foreach ($items as $item)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong><?= $item['nama']; ?></strong><br>
                            <small class="text-muted">
                                ID: <?= $item['id_barang']; ?> |
                                <?= $item['timestamp']; ?>
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary">
                                Rp <?= number_format($item['harga'], 0, ',', '.'); ?>
                            </span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Preview</h5>
        </div>

        <x-label-printed-preview :items="$items"  />
    </div> --}}

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">X - Y Starting Point</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('cetak-labelBarang-final') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="x_start" class="form-label">X-Start</label>
                    <input type="number" inputmode="numeric" name="x_start" id="x_start" value="1" min="1" max="5" step="1"
                        class="form-control @error('x_start') is-invalid @enderror" placeholder="Masukkan X Dimulai">

                    @error('x_start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="y_start" class="form-label">Y-Start</label>
                    <input type="number" inputmode="numeric" value="1" min="1" max="8" step="1" name="y_start" id="y_start" class="form-control @error('y_start') is-invalid @enderror"
                        placeholder="Masukkan Y Dimulai">

                    @error('y_start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <input type="hidden" name="items" value='@json($items)'>

                <button type="submit" class="btn btn-primary" id="cetak-btn">
                    <i class="fa-solid fa-arrow-right"></i>
                    Cetak
                </button>
            </form>
        </div>

    </div>

@endsection