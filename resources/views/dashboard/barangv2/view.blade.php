@extends('layouts.app')

@section('db-page-title', 'Data Barang V2')
@section('icon-page')
    <i class="fa-solid fa-boxes-stacked"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Data Barang V2</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container mt-1" style="padding-left: 0">
        <div class="card shadow mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Barang</h5>
            </div>

            <div class="card-body">
                <form id="add-barang-form" action="" method="">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                            class="form-control" placeholder="Masukkan Nama Barang" required>
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label for="harga_barang" class="form-label">Harga</label>
                        <div class="input-group" style="border-radius: 5px">
                            <span class="input-group-text">Rp</span>
                            <input type="text" inputmode="numeric" name="harga_barang" id="harga_barang"
                                value="{{ old('harga_barang') }}" class="form-control " placeholder="Masukkan harga barang"
                                required>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-end">
                        <div>
                            {{-- <button type="reset" class="btn btn-warning">
                                <i class="fa-solid fa-rotate-left"></i>
                                Reset
                            </button> --}}
                            <button id="submit-btn-add" type="submit" class="btn btn-success">
                                <i class="fa-solid fa-save"></i>
                                Simpan Barang
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="card shadow mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Barang</h5>
            </div>

            <div class="card-body">
                <table id="table-barang" class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="no-data">No Data . . .</td>
                            <td class="no-data"></td>
                            <td class="no-data"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function () {
            const form = $("#add-barang-form")
            let counter = 1

            $('#submit-btn-add').click(function (e) {
                e.preventDefault()
                let isValid = true

                const inputs = form.find("input")

                inputs.each(function () {
                    if (this.validity.valueMissing) {
                        isValid = false
                        this.classList.add('is-invalid')
                        const requiredErrSPAN = $('<span>', {
                            class: "error",
                            text: "Required"
                        })

                        if ($(this).parent().hasClass("input-group")) {
                            $(this).parent().addClass("outline-red")
                            if ($(this).parent().next(".error").length === 0) {
                                $(this).parent().after(requiredErrSPAN)
                            }
                        } else {
                            if (!$(this).next().hasClass("error")) {
                                $(this).after(requiredErrSPAN)
                            }
                        }
                    }
                })

                if (isValid) {
                    if ($('#table-barang .no-data')) {
                        $('#table-barang .no-data').each(function (i, e) {
                            this.remove()
                        })
                    }

                    // $("div.content-wrapper form input, div.content-wrapper form select").prop('readonly', true)
                    // $("div.content-wrapper form button[type='submit'], div.content-wrapper form button[type='reset']").prop('disabled', true)

                    // $(this).removeClass('btn-success')
                    // $(this).addClass('btn-secondary')
                    // $(this).html(`
                    //             <span class="spinner-border spinner-border-sm me-2"></span>
                    //             Loading...
                    //         `)

                    inputs.each(function (i, e) {
                        $(this).removeClass('is-invalid')
                    })
                    $('.error').remove()
                    $('.input-group').each(function (i, e) {
                        $(this).removeClass('outline-red')
                    })

                    let namaBarang = $('#nama_barang').val()
                    let hargaBarang = $('#harga_barang').val()
                    let hargaBarangFormated = Number(hargaBarang).toLocaleString('id-ID')

                    $('#nama_barang').val('')
                    $('#harga_barang').val('')

                    // Generate tanggal YYMMDD
                    let today = new Date()
                    let year = today.getFullYear().toString().slice(-2)
                    let month = String(today.getMonth() + 1).padStart(2, '0')
                    let day = String(today.getDate()).padStart(2, '0')

                    let datePart = year + month + day

                    // Sequence number
                    let seq = String(counter).padStart(2, '0')

                    // Final ID
                    let idBarang = `BRG-${seq}-${datePart}`

                    let newRow = `
                            <tr
                            data-bs-toggle="modal"
                            data-bs-target="#modal-edit-brg"
                            class="barang-record"
                            >
                                <td id="id-barang">${idBarang}</td>
                                <td id="nama-barang">${namaBarang}</td>
                                <td id="harga-barang">Rp ${hargaBarangFormated}</td>
                            </tr>
                        `
                    $('table tbody').append(newRow)
                    counter++
                }
            })
        })
    </script>
@endpush

@push('modal')
    <!-- Modal Edit Barang -->
    <div class="modal fade" id="modal-edit-brg" tabindex="-1" aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="edit-barang-form" action="" method="">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalEditKategoriLabel">
                            <i class="fa-solid fa-tags me-2"></i>
                            Edit Barang
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_barang" class="form-label">ID Barang</label>
                            <input type="text" name="id_barang" id="id_barang" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="nama_barang_edit" class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang_edit" id="nama_barang_edit"
                                value="{{ old('nama_barang_edit') }}" class="form-control"
                                placeholder="Masukkan Nama Barang" required>
                        </div>

                        <!-- Harga -->
                        <div class="mb-3">
                            <label for="harga_barang_edit" class="form-label">Harga</label>
                            <div class="input-group" style="border-radius: 5px">
                                <span class="input-group-text">Rp</span>
                                <input type="text" inputmode="numeric" name="harga_barang_edit" id="harga_barang_edit"
                                    value="{{ old('harga_barang_edit') }}" class="form-control "
                                    placeholder="Masukkan harga barang" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <!-- Tombol Submit -->
                        <button id="delete-btn" class="btn btn-danger">
                            <i class="fa-solid fa-trash"></i>
                            Hapus
                        </button>
                        <button id="submit-btn-edit" type="submit" class="btn btn-success">
                            <i class="fa-solid fa-save"></i>
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endpush
@push('script')
    <script>
        $(document).ready(function () {
            let selectedRow = null
            let modalEditDOM = null
            $('#table-barang tbody').on('click', '.barang-record', function () {
                selectedRow = $(this)

                const idBarang = $(this).find('#id-barang').text()
                const namaBarang = $(this).find('#nama-barang').text()
                let hargaBarang = $(this).find('#harga-barang').text()
                hargaBarang = (hargaBarang.replace(/[^0-9]/g, ''))

                modalEditDOM = $('#modal-edit-brg')
                const idBarangField = $(modalEditDOM).find('#id_barang')
                const namaBarangField = $(modalEditDOM).find('#nama_barang_edit')
                const hargaBarangField = $(modalEditDOM).find('#harga_barang_edit')

                $(idBarangField).val(idBarang)
                $(idBarangField).prop('readonly', true)
                $(idBarangField).removeClass('form-control')
                $(idBarangField).addClass('readonly')

                $(namaBarangField).val(namaBarang)
                $(hargaBarangField).val(hargaBarang)
            })

            $('#submit-btn-edit').click(function (e) {
                e.preventDefault()
                let idBarangField = null
                let namaBarangField = null
                let hargaBarangField = null

                if (modalEditDOM) {
                    idBarangField = $(modalEditDOM).find('#id_barang').val()
                    namaBarangField = $(modalEditDOM).find('#nama_barang_edit').val()
                    hargaBarangField = $(modalEditDOM).find('#harga_barang_edit').val()
                    hargaBarangField = Number(hargaBarangField).toLocaleString('id-ID')
                }

                let isValid = true
                const inputs = modalEditDOM.find("input")
                inputs.each(function () {
                    if (this.validity.valueMissing) {
                        isValid = false
                        this.classList.add('is-invalid')
                        const requiredErrSPAN = $('<span>', {
                            class: "error",
                            text: "Required"
                        })

                        if ($(this).parent().hasClass("input-group")) {
                            $(this).parent().addClass("outline-red")
                            if ($(this).parent().next(".error").length === 0) {
                                $(this).parent().after(requiredErrSPAN)
                            }
                        } else {
                            if (!$(this).next().hasClass("error")) {
                                $(this).after(requiredErrSPAN)
                            }
                        }
                    }
                })

                if (isValid && selectedRow) {
                    selectedRow.find('#nama-barang').text(namaBarangField)
                    selectedRow.find('#harga-barang').text(`Rp ${hargaBarangField}`)
                    $(modalEditDOM).modal('hide')
                }
            })
            $('#delete-btn').click(function (e) {
                e.preventDefault()
                if (confirm('Apakah yakin menghapus?')) {
                    if (selectedRow) {
                        $(selectedRow).remove()
                        $(modalEditDOM).modal('hide')
                        alert('Data telah dihapus')

                        const records = $('#table-barang tbody .barang-record')
                        if (records.length <= 0) {
                            $('#table-barang tbody').append(
                            `
                                <tr>
                                    <td class="no-data">No Data . . .</td>
                                    <td class="no-data"></td>
                                    <td class="no-data"></td>
                                </tr>
                            `
                            )
                        }
                    }
                }
            })
        })
    </script>
@endpush

@push('page_style')
    <style>
        .barang-record:hover {
            cursor: pointer;

            td {
                background-color: #ededed;
            }
        }

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