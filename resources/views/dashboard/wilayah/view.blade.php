@extends('layouts.app')

@section('db-page-title', 'Pilih Wilayah')
@section('icon-page')
    <i class="fa-solid fa-map-location-dot"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Pilih Wilayah</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container mt-1" style="padding-left:0">

        <a href="{{ route('show-wilayah-axios') }}" class="btn btn-primary mb-3">
            Pindah Metode Axios
        </a>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Pilih Wilayah (AJAX)</h5>
            </div>

            <div class="card-body">
                <div class="mb-3 align-items-center">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Provinsi:</label>
                        <div class="col-sm-9">
                            <select id="select_provinsi" required>
                                <option value="0">-- Pilih Provinsi --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label">Kota:</label>
                        <div class="col-sm-9">
                            <select id="select_kota" required>
                                <option value="0">-- Pilih Provinsi Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label">Kecamatan:</label>
                        <div class="col-sm-9">
                            <select id="select_kecamatan" required>
                                <option value="0">-- Pilih Kota Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label">Kelurahan:</label>
                        <div class="col-sm-9">
                            <select id="select_kelurahan" required>
                                <option value="0">-- Pilih Kecamatan Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" id="kirim_wilayah" class="btn btn-success col-sm-3">
                            Kirim
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.js"></script>
@endpush

@push('script')
    <script>

        $(document).ready(function () {

            ['#select_provinsi', '#select_kota', '#select_kecamatan', '#select_kelurahan'].forEach(id => (new SlimSelect({ select: id })))

            let wilayah_answer = {
                prov: {
                    id: '',
                    name: ''
                },
                kota: {
                    id: '',
                    name: ''
                },
                kecamatan: {
                    id: '',
                    name: ''
                },
                kelurahan: {
                    id: '',
                    name: ''
                },
            }

            let prov_select = $('#select_provinsi')
            let kota_select = $('#select_kota')
            let kecamatan_select = $('#select_kecamatan')
            let kelurahan_select = $('#select_kelurahan')

            $.ajax({
                url: "{{ route('get-provinsi') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    // console.log(response)
                    let provinsi_list = response.data.provinsi
                    provinsi_list.forEach((p) => {
                        let opt = $("<option>", {
                            text: p.name,
                            value: p.id
                        })
                        opt.appendTo(prov_select)
                    })
                },
                error: function (err) {
                    console.err(err)
                }
            })

            // Level 1
            prov_select.change(function (e) {
                if (this.value != '0') {
                    wilayah_answer.prov.id = this.value
                    wilayah_answer.prov.name = $(this).find(`option[value=${this.value}]`).text()
                }

                let load_opt = $("<option>", {
                    text: '-- Loading... --',
                    value: '0'
                })
                if (this.value != '0') kota_select.html(load_opt)

                if (this.value == '0') {
                    let def_opt = $("<option>", {
                        text: '-- Pilih Provinsi Dahulu --',
                        value: '0'
                    })
                    kota_select.html(def_opt)
                }

                $.ajax({
                    url: "{{ route('get-kota') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_provinsi: this.value
                    },
                    success: function (response) {
                        // console.log(response)
                        let kota_list = response.data.kota
                        if (kota_list.length > 0) {
                            let def_opt = $("<option>", {
                                text: '-- Pilih Kota --',
                                value: '0'
                            })
                            kota_select.html(def_opt)

                            kota_list.forEach((k) => {
                                let opt = $("<option>", {
                                    text: k.name,
                                    value: k.id
                                })
                                opt.appendTo(kota_select)
                            })
                        }
                    },
                    error: function (err) {
                        console.err(err)
                    }
                })
            })

            kota_select.change(function (e) {
                if (this.value != '0') {
                    wilayah_answer.kota.id = this.value
                    wilayah_answer.kota.name = $(this).find(`option[value=${this.value}]`).text()
                }
                let load_opt = $("<option>", {
                    text: '-- Loading... --',
                    value: '0'
                })
                if (this.value != '0') kecamatan_select.html(load_opt)

                if (this.value == '0') {
                    let def_opt = $("<option>", {
                        text: '-- Pilih Kota Dahulu --',
                        value: '0'
                    })
                    kecamatan_select.html(def_opt)
                }

                $.ajax({
                    url: "{{ route('get-kecamatan') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_kota: this.value
                    },
                    success: function (response) {
                        // console.log(response)
                        let kecamatan_list = response.data.kecamatan
                        if (kecamatan_list.length > 0) {
                            let def_opt = $("<option>", {
                                text: '-- Pilih Kecamatan --',
                                value: '0'
                            })
                            kecamatan_select.html(def_opt)
                        }

                        kecamatan_list.forEach((k) => {
                            let opt = $("<option>", {
                                text: k.name,
                                value: k.id
                            })
                            opt.appendTo(kecamatan_select)
                        })
                    },
                    error: function (err) {
                        console.err(err)
                    }
                })
            })

            kecamatan_select.change(function (e) {
                if (this.value != '0') {
                    wilayah_answer.kecamatan.id = this.value
                    wilayah_answer.kecamatan.name = $(this).find(`option[value=${this.value}]`).text()
                }
                let load_opt = $("<option>", {
                    text: '-- Loading... --',
                    value: '0'
                })
                if (this.value != '0') kelurahan_select.html(load_opt)

                if (this.value == '0') {
                    let def_opt = $("<option>", {
                        text: '-- Pilih Kecamatan Dahulu --',
                        value: '0'
                    })
                    kelurahan_select.html(def_opt)
                }

                $.ajax({
                    url: "{{ route('get-kelurahan') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_kecamatan: this.value
                    },
                    success: function (response) {
                        // console.log(response)
                        let kelurahan_list = response.data.kelurahan
                        if (kelurahan_list.length > 0) {
                            let def_opt = $("<option>", {
                                text: '-- Pilih Kelurahan --',
                                value: '0'
                            })
                            kelurahan_select.html(def_opt)
                        }

                        kelurahan_list.forEach((k) => {
                            let opt = $("<option>", {
                                text: k.name,
                                value: k.id
                            })
                            opt.appendTo(kelurahan_select)
                        })
                    },
                    error: function (err) {
                        console.err(err)
                    }
                })
            })

            kelurahan_select.change(function (e) { 
                if (this.value != '0') {
                    wilayah_answer.kelurahan.id = this.value
                    wilayah_answer.kelurahan.name = $(this).find(`option[value=${this.value}]`).text()
                }
            })

            $('#kirim_wilayah').click(function (e) {
                e.preventDefault()

                console.log(wilayah_answer)
                Swal.fire({
                    title: "<strong>Your Answer</strong>",
                    icon: "success",
                    html: `
                            prov: ${wilayah_answer.prov.name || '(not choiced)'} <br>
                            kota: ${wilayah_answer.kota.name || '(not choiced)'} <br>
                            kecamatan: ${wilayah_answer.kecamatan.name || '(not choiced)'} <br>
                            kelurahan: ${wilayah_answer.kelurahan.name || '(not choiced)'} <br>
                        `,
                    showCloseButton: true,
                    focusConfirm: false,
                    confirmButtonText: `
                            <i class="fa fa-thumbs-up"></i> Great!
                        `,
                    confirmButtonAriaLabel: "Thumbs up, great!",
                });
            })
        });
    </script>
@endpush

@push('page_style')
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>
@endpush