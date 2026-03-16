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
                    {{-- Id --}}
                    <div class="mb-3 d-flex align-items-center gap-3">
                        <label for="id_barang" class="form-label col-sm-1">ID Barang</label>
                        <input type="text" name="id_barang" id="id_barang" value="{{ old('id_barang') }}"
                            class="form-control" placeholder="Masukkan ID Barang" required>
                        <button class="btn btn-success col-sm-2">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Cari
                        </button>
                    </div>

                    {{-- Nama --}}
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
                    <span>Rp <span id="total_checkout">0,00</span></span>
                </div>
                <div class="d-flex justify-content-end">
                    <button id="pay-btn" class="btn btn-success">
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
        const form = $('#add-barang-form')
        const id_barang_field = $('#id_barang')
        const nama_field_add = $('#nama_barang')
        const harga_field_add = $('#harga_barang')
        const jumlah_field_add = $('#jumlah_barang')
        const add_barang_btn = $('#submit-btn-add')
        const total_checkout_dom = $('#total_checkout')

        let final_checkout = []
        let total_checkout = 0

        function countTotal() {
            total_checkout = final_checkout.reduce((accu, curr) => accu + curr.subtotal, 0)
            total_checkout_dom.text(Number(total_checkout).toLocaleString('id-ID'))
        }

        $(document).ready(function () {
            /*  [
                    {
                        id_barang:
                        nama:
                        harga:
                        jumlah:
                        subtotal:
                    },
                    ...
                ]
            */

            function searchBarang(e, form) {
                e.preventDefault()
                const id_barang = $(form).find('#id_barang').val()
                add_barang_btn.attr({
                    'disabled': 'true'
                })
                add_barang_btn.text('Loading . . .')

                let isValid = true
                const inputs = $(form).find("input")
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
                    inputs.each(function (i, e) {
                        $(this).removeClass('is-invalid')
                    })
                    $(form).find('.error').remove()
                    $(form).find('.input-group').each(function (i, e) {
                        $(this).removeClass('outline-red')
                    })

                    $.ajax({
                        url: "{{ route('get-barang') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_barang: id_barang
                        },
                        success: function (response) {
                            // console.log(response)
                            if (response.code == "200") {
                                nama_field_add.val(response.data.barang.nama)
                                harga_field_add.val(response.data.barang.harga)
                                jumlah_field_add.val(1)
                                add_barang_btn.attr({
                                    'disabled': false
                                })
                                countTotal()
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Barang Not Found",
                                    text: `Barang with id ${id_barang} not exist`,
                                });
                                nama_field_add.val('')
                                harga_field_add.val('')
                                jumlah_field_add.val('')
                                add_barang_btn.attr({
                                    'disabled': 'true'
                                })
                            }
                            add_barang_btn.html(`<i class="fa-solid fa-cart-shopping"></i> Tambahkan Barang`)
                        },
                        error: function (err) {
                            console.log(err)
                        }
                    })
                } else {
                    add_barang_btn.html(`<i class="fa-solid fa-cart-shopping"></i> Tambahkan Barang`)
                }
            }

            form.submit(function (e) {
                e.preventDefault()
                searchBarang(e, this)
            })

            id_barang_field.on('blur', function (e) {
                searchBarang(e, form)
            })

            id_barang_field.on('focus', function (e) {
                add_barang_btn.attr({
                    'disabled': 'true'
                })
            })

            jumlah_field_add.on('input', function (e) {
                if (this.value > 0) {
                    add_barang_btn.attr({
                        'disabled': false
                    })
                } else {
                    add_barang_btn.attr({
                        'disabled': true
                    })
                }
            })

            $('#submit-btn-add').click(function (e) {
                if ($('#table-barang .no-data')) {
                    $('#table-barang .no-data').each(function (i, e) {
                        this.remove()
                    })
                }

                const barang_record_json = {
                    id_barang: $('#id_barang').val(),
                    nama: $('#nama_barang').val(),
                    harga: $('#harga_barang').val(),
                    jumlah: $('#jumlah_barang').val(),
                    subtotal: Number($('#harga_barang').val()) * Number($('#jumlah_barang').val())
                }
                const hargaBarangFormated = Number(barang_record_json.harga).toLocaleString('id-ID')

                if ($(`#table-barang tbody tr#${barang_record_json.id_barang}`).length > 0) {
                    final_checkout = final_checkout.map((brg) => {
                        if (brg.id_barang === barang_record_json.id_barang) {
                            return {
                                ...brg,
                                jumlah: barang_record_json.jumlah,
                                subtotal: barang_record_json.subtotal
                            }
                        }
                        return brg
                    })
                    // 

                    const record = $(`#table-barang tbody tr#${barang_record_json.id_barang}`)
                    record.find('.jumlah-barang').text(barang_record_json.jumlah)
                    record.find('.subtotal-barang').text(`Rp ${Number(barang_record_json.subtotal).toLocaleString('id-ID')}`)

                } else {
                    final_checkout.push(barang_record_json)
                    let newRow = `
                    <tr
                            data-bs-toggle="modal"
                            data-bs-target="#modal-edit-brg"
                            class="barang-record"
                            id=${barang_record_json.id_barang}
                            >
                                <td class="id-barang">${barang_record_json.id_barang}</td>
                                <td class="nama-barang">${barang_record_json.nama}</td>
                                <td class="harga-barang">Rp ${hargaBarangFormated}</td>
                                <td class="jumlah-barang">${barang_record_json.jumlah}</td>
                                <td class="subtotal-barang">Rp ${Number(barang_record_json.subtotal).toLocaleString('id-ID')}</td>
                            </tr>
                        `
                    $('#table-barang tbody').append(newRow)
                }
                countTotal()

            })
        });

    </script>
@endpush

{{-- Modal Edit --}}
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
                        {{-- id barang --}}
                        <div class="mb-3">
                            <label for="id_barang_edit" class="form-label">ID Barang</label>
                            <input type="text" name="id_barang_edit" id="id_barang_edit" class="readonly" readonly>
                        </div>

                        {{-- nama --}}
                        <div class="mb-3">
                            <label for="nama_barang_edit" class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang_edit" id="nama_barang_edit"
                                value="{{ old('nama_barang_edit') }}" class="readonly" placeholder="Masukkan Nama Barang"
                                required readonly>
                        </div>

                        <!-- Harga -->
                        <div class="mb-3">
                            <label for="harga_barang_edit" class="form-label">Harga</label>
                            <div class="input-group" style="border-radius: 5px">
                                <span class="input-group-text">Rp</span>
                                <input type="text" inputmode="numeric" name="harga_barang_edit" id="harga_barang_edit"
                                    value="{{ old('harga_barang_edit') }}"
                                    style="background-color: #f0f0f0; color: var(--bs-body-color); font-weight: 400;"
                                    class="form-control" placeholder="Masukkan harga barang" required readonly>
                            </div>
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-3">
                            <label for="jumlah_barang_edit" class="form-label">Jumlah</label>
                            <input type="text" inputmode="numeric" name="jumlah_barang_edit" id="jumlah_barang_edit"
                                value="{{ old('jumlah_barang_edit') }}" class="form-control"
                                placeholder="Masukkan harga barang" required>
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

                const idBarang = $(this).find('.id-barang').text()
                const namaBarang = $(this).find('.nama-barang').text()
                const hargaBarang = ($(this).find('.harga-barang').text()).replace(/[^0-9]/g, '')
                const jumlahBarang = $(this).find('.jumlah-barang').text()


                modalEditDOM = $('#modal-edit-brg')
                const idBarangField = $(modalEditDOM).find('#id_barang_edit')
                const namaBarangField = $(modalEditDOM).find('#nama_barang_edit')
                const hargaBarangField = $(modalEditDOM).find('#harga_barang_edit')
                const jumlahBarangField = $(modalEditDOM).find('#jumlah_barang_edit')

                $(idBarangField).val(idBarang)
                $(namaBarangField).val(namaBarang)
                $(hargaBarangField).val(hargaBarang)
                $(jumlahBarangField).val(jumlahBarang)

            })

            $('#submit-btn-edit').click(function (e) {
                e.preventDefault()
                let idBarangField = null
                let namaBarangField = null
                let hargaBarangField = null
                let jumlahBarangField = null

                if (modalEditDOM) {
                    idBarangField = $(modalEditDOM).find('#id_barang_edit').val()
                    hargaBarangField = $(modalEditDOM).find('#harga_barang_edit').val()
                    jumlahBarangField = $(modalEditDOM).find('#jumlah_barang_edit').val()
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
                    const new_subtotal = jumlahBarangField * hargaBarangField
                    final_checkout = final_checkout.map((barang) => {
                        if (barang.id_barang == idBarangField) {
                            return {
                                ...barang,
                                jumlah: jumlahBarangField,
                                subtotal: new_subtotal
                            }
                        }
                        return barang
                    })
                    countTotal()
                    selectedRow.find('.jumlah-barang').text(jumlahBarangField)
                    selectedRow.find('.subtotal-barang').text(`Rp ${Number(new_subtotal).toLocaleString('id-ID')}`)
                    $(modalEditDOM).modal('hide')
                }

            })
            $('#delete-btn').click(function (e) {
                e.preventDefault()
                idBarangField = $(modalEditDOM).find('#id_barang_edit').val()

                Swal.fire({
                    title: "Yakin Menghapus?",
                    text: `Konfirmasi Hapus Baris: ${idBarangField}`,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Jangan Hapus",
                    denyButtonText: `<i class="fa-solid fa-trash-can"></i> Hapus!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire("Barang Not Deleted", "", "info");
                    } else if (result.isDenied) {
                        if (selectedRow) {
                            final_checkout = final_checkout.filter((barang) => barang.id_barang !== idBarangField)
                            countTotal()


                            $(selectedRow).remove()
                            $(modalEditDOM).modal('hide')
                            Swal.fire("Barang Deleted", "", "info");

                            const records = $('#table-barang tbody .barang-record')
                            if (records.length <= 0) {
                                $('#table-barang tbody').append(
                                    `
                                                                                        <tr>
                                                                                            <td class="no-data">No Data . . .</td>
                                                                                            <td class="no-data"></td>
                                                                                            <td class="no-data"></td>
                                                                                            <td class="no-data"></td>
                                                                                            <td class="no-data"></td>
                                                                                        </tr>
                                                                                    `
                                )
                            }
                        }
                    }
                });
            })
        })
    </script>
@endpush

{{-- Handle Submit Payment --}}
@push('script')
    <script>
        $('#pay-btn').click(function (e) {

            if (final_checkout.length == 0) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'data penjualan kosong'
                })
            }

            $(this).attr({
                'disabled': true
            })
            $(this).html(`<span class="spinner-border spinner-border-sm me-2"></span> Loading...`)

            $.ajax({
                url: "{{ route('post-penjualan') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    total: total_checkout,
                    barang_checkout: final_checkout
                },
                success: function (response) {
                    if (response.success) {
                        $(form).trigger('reset')

                        jumlah_field_add.val('')
                        id_barang_field.val('')
                        nama_field_add.val('')
                        harga_field_add.val('')

                        total_checkout = 0
                        final_checkout = []
                        countTotal()

                        $("#table-barang tbody").remove()
                        $("#table-barang").append(
                            `<tbody>
                                <tr>
                                    <td class="no-data">No Data . . .</td>
                                    <td class="no-data"></td>
                                    <td class="no-data"></td>
                                    <td class="no-data"></td>
                                    <td class="no-data"></td>
                                </tr>
                            </tbody>`
                        )

                        $('#pay-btn').attr({
                            'disabled': false
                        })
                        $('#pay-btn').html(`<i class="fa-solid fa-cash-register"></i> Pay`)
                        Swal.fire({
                            icon: "success",
                            text: "Sukses menyimpan penjualan!"
                        })
                    } else {
                        $('#pay-btn').attr({
                            'disabled': false
                        })
                        $('#pay-btn').html(`<i class="fa-solid fa-cash-register"></i> Pay`)
                        Swal.fire({
                            icon: "error",
                            title: "Gagal menyimpan penjualan",
                            text: `${response.message}`
                        })
                    }

                },
                error: function (err) {
                    $('#pay-btn').attr({
                        'disabled': false
                    })
                    $('#pay-btn').html(`<i class="fa-solid fa-cash-register"></i> Pay`)
                    console.log(`Error: ${JSON.stringify(err)}`)

                    if (err.responseJSON && err.responseJSON.message) {
                        message = err.responseJSON.message;
                    } else if (err.responseText) {
                        try {
                            const parsed = JSON.parse(err.responseText);
                            message = parsed.message || err.responseText;
                        } catch (e) {
                            message = err.responseText;
                        }
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Gagal menyimpan penjualan",
                        text: `Error: ${message}`
                    })
                }
            })
        })
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

        .barang-record:hover {
            cursor: pointer;

            td {
                background-color: #ededed;
            }
        }
    </style>
@endpush