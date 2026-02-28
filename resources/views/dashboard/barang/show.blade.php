@extends('layouts.app')

@section('db-page-title', 'Barang')
@section('icon-page')
    <i class="fa-solid fa-boxes-stacked"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Barang</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3" style="margin-right: 12px">
        <a href="{{ route('add-barang') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambahkan Barang
        </a>

        <!-- Hidden checkbox -->
        <input type="checkbox" id="cetak-label-toggle" class="btn-check">
        <label for="cetak-label-toggle" class="btn btn-primary">
            <i class="fa-solid fa-tag"></i>
            Cetak Label
        </label>
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
                            <th class="hide" id="pick-column-th">Pick</th>
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
                                            <a href="{{ route('edit-barang', ['id' => $barang->id_barang]) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                Update
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('api-delete-barang') }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus?')">
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
                                    <td class="hide pick-column-td">
                                        <input
                                        value="{{ $barang->id_barang }}"
                                        name="to_be_print[]"
                                        type="checkbox" 
                                        class="pick-to-print">
                                    </td>
                                </tr>
                            @endforeach
                            <form id="print-form" action="{{ route('cetak-labelBarang-preview') }}" method="POST">
                            @csrf

                            </form>
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
                <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                    <button 
                     type="submit"
                     form="print-form"
                     class="hide btn-primary" 
                     id="cetak-btn"
                    >
                        <i class="fa-solid fa-arrow-right"></i>
                        Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>

        const pickCheckboxTH = document.getElementById('pick-column-th')
        const pickCheckboxTDs = document.querySelectorAll('td.pick-column-td')
        const pickCetakToggleBtn = document.querySelector('input#cetak-label-toggle')
        const redirectCetakBtn = document.querySelector('button#cetak-btn')
        const pickCheckboxINPUTs = document.querySelectorAll("input.pick-to-print");
        const printForm = document.querySelector('form#print-form')
        var toPrinted = []

        pickCetakToggleBtn.addEventListener('change', (e) => {
            // console.log(e.target)
            if (e.target.checked) {
                pickCheckboxTDs.forEach((td) => { td.classList.remove('hide') })
                pickCheckboxTH.classList.remove('hide')
            } else {
                pickCheckboxTDs.forEach((td) => { td.classList.add('hide') })
                pickCheckboxTH.classList.add('hide')
                redirectCetakBtn.classList.remove('btn')
                toPrinted = []
                pickCheckboxINPUTs.forEach((checkbox) => {
                    checkbox.checked = false
                })
            }

        })

        pickCheckboxINPUTs.forEach((checkbox) => {
            checkbox.addEventListener("change", function () {
                // const data_brg = {
                //     id_barang: this.dataset.id_barang,
                //     nama: this.dataset.nama,
                //     harga: this.dataset.harga,
                // }

                if (this.checked) {
                    // console.log(data_brg, `Checkbox aktif`);
                    toPrinted.push(this.value)
                } else {
                    // console.log(data_brg, `Checkbox tidak aktif`);
                    toPrinted = toPrinted.filter(i => i !== this.value)
                }
                // console.log(toPrinted);

                if (toPrinted.length > 0) {
                    redirectCetakBtn.classList.add('btn')
                } else {
                    redirectCetakBtn.classList.remove('btn')
                }

                const toBePrinted = this.cloneNode(true)
                printForm.appendChild(toBePrinted)
                console.log(printForm)
            });
        })

    </script>
@endpush

@push('page_style')
    <style>
        .hide {
            display: none
        }
    </style>
@endpush