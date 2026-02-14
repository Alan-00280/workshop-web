@extends('layouts.app')

@section('db-page-title', 'Kategori Buku')
@section('icon-page')
    <i class="fa-solid fa-book-bookmark"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Kategori Buku</x-ui.breadcrumb-item>
@endsection

@section('content')
    {{-- <x-logger :object="$catagories" /> --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ "#" }}" data-bs-toggle="modal" data-bs-target="#modalKategori" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambahkan Kategori
        </a>
    </div>

    <div class="container mt-1" style="padding-left: 0">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Buku</h5>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th># ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($catagories) > 0)
                            @foreach ($catagories as $category)
                                <tr>
                                    <td><span class="badge bg-dark">{{ $category->idkategori }}</span></td>
                                    <td>{{ $category->nama_kategori }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            <!-- Update Button -->
                                            <a href="" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                Update
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    No Data...
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modalKategori" tabindex="-1" aria-labelledby="modalKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ '#' }}" method="POST">
                    @csrf

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalKategoriLabel">
                            <i class="fa-solid fa-tags me-2"></i>
                            Tambah Kategori Buku
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori
                            </label>

                            <input type="text" name="nama_kategori" id="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori') }}" placeholder="Masukkan nama kategori">

                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-save"></i>
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection