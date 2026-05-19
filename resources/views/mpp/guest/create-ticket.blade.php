@extends('mpp.layouts.app')

@push('style_page')
<style>
        body {
            font-family: 'Quicksand', sans-serif;
            /* background-color: #0b132b; Dark background to match the contrast */
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Main Container */
        .main-container {
            flex-grow: 1;
            padding: 1rem;
            /* display: flex;
            flex-direction: column;
            justify-content: center; */
            background-color: #0b132b;
            min-height: 100vh;
        }

        .text-input::placeholder {
            color: #cccccc
        }
    </style>
@endpush

@section('content')
    <!-- Main Container -->
    <main class="main-container d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card bg-dark text-white shadow-lg border-secondary rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="fw-bold text-center mb-4 text-warning">Buat Antrian</h3>
                            
                            <form action="{{ route('mpp-post-ticket-antree') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label text-white-50">Nama Lengkap</label>
                                    <input type="text" class="form-control bg-dark text-white border-secondary text-input" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="select-kategori-layanan" class="form-label text-white-50">Kategori Layanan</label>
                                    <select class="form-select bg-dark text-white border-secondary" name="id_kat_layanan" id="select-kategori-layanan" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @forelse ($kategori_layanans as $item)    
                                            <option value="{{ $item->id }}">{{ $item->nama_kat }}</option>
                                        @empty
                                            <option value="" disabled>Belum Ada Kategori</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="select-layanan" class="form-label text-white-50">Layanan</label>
                                    <select class="form-select bg-dark text-white border-secondary" name="id_layanan" id="select-layanan" required>
                                        <option value="">Pilih kategori terlebih dahulu</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-warning w-100 fw-bold py-2 rounded-pill text-dark">Ambil Tiket Antrian</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#select-kategori-layanan').on('change', function() {
                let kategoriId = $(this).val();
                let layananSelect = $('#select-layanan');
                
                layananSelect.empty();
                layananSelect.append('<option value="">Memuat...</option>');
                
                if (kategoriId) {
                    $.ajax({
                        url: '/layanan/kategori/' + kategoriId,
                        type: 'GET',
                        success: function(response) {
                            layananSelect.empty();
                            // console.log(response)
                            if (response.success && response.data.layanans.length > 0) {
                                layananSelect.append('<option value="">-- Pilih Layanan --</option>');
                                $.each(response.data.layanans, function(key, layanan) {
                                    layananSelect.append('<option value="' + layanan.id + '">' + layanan.nama + '</option>');
                                });
                            } else {
                                layananSelect.append('<option value="">Tidak ada layanan di kategori ini</option>');
                            }
                        },
                        error: function() {
                            layananSelect.empty();
                            layananSelect.append('<option value="">Gagal memuat data layanan</option>');
                        }
                    });
                } else {
                    layananSelect.empty();
                    layananSelect.append('<option value="">Pilih kategori terlebih dahulu</option>');
                }
            });
        });
    </script>
@endpush
