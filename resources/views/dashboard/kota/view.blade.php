@extends('layouts.app')

@section('db-page-title', 'Daftar Kota')
@section('icon-page')
    <i class="fa-solid fa-city"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Daftar Kota</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container mt-1" style="padding-left:0">

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Select</h5>
            </div>

            <div class="card-body">

                <div class="mb-3 row align-items-center">
                    <label class="col-sm-2 col-form-label">Kota:</label>

                    <div class="col-sm-7">
                        <input type="text" id="kota_input" class="form-control" placeholder="Masukkan nama kota">
                    </div>

                    <div class="col-sm-3">
                        <button type="button" id="btn_tambah_kota" class="btn btn-success w-100">
                            Tambahkan
                        </button>
                    </div>
                </div>

                {{-- Select Kota --}}
                <div class="mb-3 row align-items-center">
                    <label class="col-sm-2 col-form-label">Select Kota:</label>

                    <div class="col-sm-10">
                        <select id="select_kota" class="form-select">
                            <option value="">-- Pilih Kota --</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <strong>Kota Terpilih :</strong>
                        <span id="kota_terpilih" class="text-primary"></span>
                    </div>
                </div>

            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Select2</h5>
            </div>

            <div class="card-body">

                {{-- Input Kota --}}
                <div class="mb-3 row align-items-center">
                    <label class="col-sm-2 col-form-label">Kota:</label>

                    <div class="col-sm-7">
                        <input type="text" id="kota_input2" class="form-control" placeholder="Masukkan nama kota">
                    </div>

                    <div class="col-sm-3">
                        <button type="button" id="btn_tambah_kota2" class="btn btn-success w-100">
                            Tambahkan
                        </button>
                    </div>
                </div>

                {{-- Select2 --}}
                <div class="mb-3 row align-items-center">
                    <label class="col-sm-2 col-form-label">Select Kota:</label>

                    <div class="col-sm-10">
                        <select id="select_kota2" class="form-select">
                            <option value="">-- Pilih Kota --</option>
                        </select>
                    </div>
                </div>

                {{-- Kota Terpilih --}}
                <div class="row">
                    <div class="col-sm-12">
                        <strong>Kota Terpilih :</strong>
                        <span id="kota_terpilih2" class="text-primary"></span>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

@push('script')
    <script>

        $(document).ready(function () {

            // init select2
            $('#select_kota2').select2({
                placeholder: 'Pilih Kota'
            });


            // tambah kota ke select biasa
            $('#btn_tambah_kota').click(function () {

                let kota = $('#kota_input').val().trim();

                if (kota !== '') {

                    $('#select_kota').append(
                        `<option value="${kota}">${kota}</option>`
                    );

                    $('#kota_input').val('');
                }

            });


            // tambah kota ke select2
            $('#btn_tambah_kota2').click(function () {

                let kota = $('#kota_input2').val().trim();

                if (kota !== '') {

                    let newOption = new Option(kota, kota, false, false);
                    $('#select_kota2').append(newOption).trigger('change');

                    $('#kota_input2').val('');
                }

            });


            // tampilkan kota terpilih (select biasa)
            $('#select_kota').change(function () {

                let kota = $(this).val();

                $('#kota_terpilih').text(kota);

            });


            // tampilkan kota terpilih (select2)
            $('#select_kota2').change(function () {

                let kota = $(this).val();

                $('#kota_terpilih2').text(kota);

            });


        });

    </script>
@endpush

@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush