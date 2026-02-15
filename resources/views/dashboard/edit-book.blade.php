@extends('layouts.form')

@section('title', 'Edit Buku')
@section('icon')
    <i class="fa-classic fa-solid fa-book"></i>
@endsection

@section('breadcrumb-form')
    <x-ui.breadcrumb-item href="{{ route('book') }}">Koleksi Buku</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Edit Buku</x-ui.breadcrumb-item>
@endsection

@section('form-content')

    <!-- Header + Tombol -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('book') }}" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Buku</h5>
        </div>

        <div class="card-body">
            <form action="{{route('update-book')}}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Judul -->
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" 
                           name="judul" 
                           id="judul"
                           value="{{ $book->judul }}"
                           class="form-control @error('judul') is-invalid @enderror"
                           placeholder="Masukkan judul buku">

                    @error('judul')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Pengarang -->
                <div class="mb-3">
                    <label for="pengarang" class="form-label">Pengarang</label>
                    <input type="text" 
                           name="pengarang" 
                           id="pengarang"
                           value="{{ $book->pengarang }}"
                           class="form-control @error('pengarang') is-invalid @enderror"
                           placeholder="Masukkan nama pengarang">

                    @error('pengarang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="idkategori" class="form-label">Kategori</label>
                    <select name="idkategori" 
                            id="idkategori"
                            class="form-select @error('idkategori') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>

                        @foreach($catagories as $item)
                            <option value="{{ $item->idkategori }}"
                                {{ $book->KategoriBuku->idkategori == $item->idkategori ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    @error('idkategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Hidden --}}
                <input type="hidden" name="idbuku" value="{{ $book->idbuku }}">

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
