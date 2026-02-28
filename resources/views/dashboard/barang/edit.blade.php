@extends('layouts.form')

@section('title', 'Edit Barang')
@section('icon')
    <i class="fa-solid fa-boxes-stacked"></i>
@endsection

@section('breadcrumb-form')
    <x-ui.breadcrumb-item href="{{ route('show-barang') }}">Barang</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Edit Barang</x-ui.breadcrumb-item>
@endsection

@section('form-content')

    <!-- Header + Tombol -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('show-barang') }}" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    {{-- <x-logger :object="$barang" /> --}}
    
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Barang #{{ $barang->id_barang }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('api-edit-barang') }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" value="{{ $barang->nama }}"
                        class="form-control @error('nama_barang') is-invalid @enderror" placeholder="Masukkan Nama Barang">

                    @error('nama_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label for="harga_barang" class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" inputmode="numeric" name="harga_barang" id="harga_barang"
                            value="{{ $barang->harga }}"
                            class="form-control @error('harga_barang') is-invalid @enderror"
                            placeholder="Masukkan harga barang">

                        @error('harga_barang')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    @error('harga_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Hidden --}}
                <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">

                <!-- Tombol Submit -->
                <div class="d-flex justify-content-end">
                    <div>
                        <button type="reset" class="btn btn-warning">
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-save"></i>
                            Simpan Buku
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    

@endsection
