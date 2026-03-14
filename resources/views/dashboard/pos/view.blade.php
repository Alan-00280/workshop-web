@extends('layouts.app')

@section('db-page-title', 'Point of Sales')
@section('icon-page')
    <i class="fa-solid fa-cart-shopping"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>point of sales</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container mt-1" style="padding-left:0">

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Barang</h5>
            </div>

            <div class="card-body">
                <form id="add-barang-form" action="" method="">

                    <div class="mb-3 d-flex align-items-center gap-3">
                        <label for="id_barang" class="form-label col-sm-1">ID Barang</label>
                        <input type="text" name="id_barang" id="id_barang" value="{{ old('id_barang') }}"
                            class="form-control" placeholder="Masukkan ID Barang" required>
                        <button class="btn btn-success col-sm-2">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Cari
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                            class="readonly" placeholder="Masukan ID Barang" readonly required>
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label for="harga_barang" class="form-label">Harga</label>
                        <div class="input-group" style="border-radius: 5px">
                            <span class="input-group-text">Rp</span>
                            <input type="text" inputmode="numeric" name="harga_barang" id="harga_barang"
                                value="{{ old('harga_barang') }}"
                                style="background-color: #f0f0f0; color: var(--bs-body-color); font-weight: 400;"
                                class="form-control" placeholder="Masukkan ID barang" readonly required>
                        </div>
                    </div>


                </form>
                <div class="mb-3">
                    <label for="jumlah_barang" class="form-label">Jumlah</label>
                    <input type="text" name="jumlah_barang" id="jumlah_barang" value="{{ old('jumlah_barang') }}"
                        class="form-control" placeholder="Masukkan Jumlah Barang" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button id="submit-btn-add" type="submit" class="btn btn-success" disabled="true">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Tambahkan Barang
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Checkout</h5>
            </div>

            <div class="card-body">
                <table id="table-barang" class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="no-data">No Data . . .</td>
                            <td class="no-data"></td>
                            <td class="no-data"></td>
                            <td class="no-data"></td>
                            <td class="no-data"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex gap-4 justify-content-end mt-2">
                    <h5>Total: </h5>
                    <span>Rp 0,00</span>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success">
                        <i class="fa-solid fa-cash-register"></i>
                        Pay
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

@push('script')
    <script>

        $(document).ready(function () {
            const form = $('#add-barang-form')
            const nama_field_add = $('#nama_barang')
            const harga_field_add = $('#harga_barang')
            const jumlah_field_add = $('#jumlah_barang')
            const add_barang_btn = $('#submit-btn-add')

            form.submit(function (e) {
                e.preventDefault()
                const id_barang = $(this).find('#id_barang').val()
                
                $.ajax({
                    url: "{{ route('get-barang') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_barang: id_barang
                    },
                    success: function (response) {
                        console.log(response)
                        if (response.code == "200") {
                            nama_field_add.val(response.data.barang.nama)
                            harga_field_add.val(response.data.barang.harga)
                            jumlah_field_add.val(1)
                            add_barang_btn.attr({
                                'disabled': false
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Barang Not Found",
                                text: `Barang with id ${id_barang} not exist`,
                            });
                            nama_field_add.val()
                            harga_field_add.val()
                        }
                    },
                    error: function (err) {
                        console.err(err)
                    }
                })
            })

            jumlah_field_add.on('input', function (e) {
                if (this.value > 0) {
                    add_barang_btn.attr({
                        'disabled': false
                    })
                }
            })
        });

    </script>
@endpush

@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .readonly {
            background-color: #f0f0f0;
            display: block;
            width: 100%;
            padding: 0.94rem 1.375rem;
            font-size: 0.8125rem;
            font-weight: 400;
            line-height: 1;
            color: var(--bs-body-color);
            appearance: none;
            border: 1px solid #ebedf2;
        }
    </style>
@endpush