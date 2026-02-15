@extends('layouts.app')

@section('db-page-title', 'Koleksi Buku')
@section('icon-page')
    <i class="fa-classic fa-solid fa-book"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Koleksi Buku</x-ui.breadcrumb-item>
@endsection

@section('content')
{{-- @dd($books) --}}
    {{-- <x-logger :object="$books" /> --}}
        <!-- Header + Tombol -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('add-book') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambahkan Buku
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
                            <th># Kode Buku</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($books) > 0)
                        @foreach ($books as $book)
                        <tr>
                            <td><span class="badge bg-dark">{{ $book->kode_buku }}</span></td>
                            <td>{{ $book->judul }}</td>
                            <td>{{ $book->pengarang }}</td>
                            <td>
                                <span class="badge {{ $book->KategoriBuku!==null?'badge-success' : 'bg-dark' }}">
                                    {{ $book->KategoriBuku->nama_kategori??'no-category' }}
                                </span>
                            </td> 
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- Update Button -->
                                    <a href="{{ route('edit-book', ['id' => $book->idbuku]) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Update
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('delete-book', ['id' => $book->idbuku]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
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