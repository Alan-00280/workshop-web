@extends('layouts.app')

@section('db-page-title', 'Barang')
@section('icon-page')
    <i class="fa-solid fa-boxes-stacked"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Barang</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('add-barang') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambahkan Barang
        </a>
    </div>
    {{-- <x-logger :object="$barangs" /> --}}
    <div class="container mt-1" style="padding-left: 0">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Barang</h5>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th># Kode Barang</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Ditambahkan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($barangs) > 0)
                        @foreach ($barangs as $barang)
                        <tr>
                            <td><span class="badge bg-dark">{{ $barang->id_barang }}</span></td>
                            <td>{{ $barang->nama }}</td>
                            <td>Rp. {{ $barang->harga }}</td>
                            <td>{{ \Carbon\Carbon::parse($barang->timestamp)->format('l, d - m - Y \a\t H:i:s') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- Update Button -->
                                    <a href="{{ route('edit-barang', ['id' => $barang->id_barang]) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Update
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('api-delete-barang') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
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