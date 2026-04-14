@extends('layouts.app')

@section('db-page-title', 'Tambah Customer v2')
@section('icon-page')
    <i class="fa-solid fa-user-plus"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('show-customer') }}">Data Customer</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Tambah Customer v2</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container-fluid mt-2" style="padding-left:0">
        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-user-plus me-2 text-primary"></i>Formulir Tambah Customer</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('store-v2-customer') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="nama" class="form-label fw-bold">Nama Lengkap*</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama..." required>
                        </div>
                        <div class="col-md-6">
                            <label for="kode_pos" class="form-label fw-bold">Kode Pos*</label>
                            <input type="text" class="form-control" id="kode_pos" name="kode_pos" placeholder="Mis. 12940" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label fw-bold">Jalan / Alamat Detail*</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Nama Jalan, RT/RW, Blok, No. Rumah" required></textarea>
                    </div>
                    
                    <hr class="mb-4 text-muted">
                    <h6 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-map-location-dot me-2"></i>Pemilihan Wilayah Geografis (AJAX)</h6>

                    <div class="mb-3 row align-items-center">
                        <label class="col-sm-3 col-form-label">Provinsi:</label>
                        <div class="col-sm-9">
                            <select id="select_provinsi" required>
                                <option value="0">-- Pilih Provinsi --</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-sm-3 col-form-label">Kota/Kabupaten:</label>
                        <div class="col-sm-9">
                            <select id="select_kota" required>
                                <option value="0">-- Pilih Provinsi Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-sm-3 col-form-label">Kecamatan:</label>
                        <div class="col-sm-9">
                            <select id="select_kecamatan" required>
                                <option value="0">-- Pilih Kota Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-sm-3 col-form-label">Kelurahan:</label>
                        <div class="col-sm-9">
                            <!-- This field passes kelurahan_id out -->
                            <select id="select_kelurahan" name="kelurahan_id" required>
                                <option value="0">-- Pilih Kecamatan Dahulu --</option>
                            </select>
                            {{-- <div class="form-text mt-1 text-muted">Akan menyimpan value <code>kelurahan_id</code> saat disubmit.</div> --}}
                        </div>
                    </div>

                    <hr class="mb-4 text-muted">
                    <h6 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-camera me-2"></i>Foto Customer</h6>

                    {{-- Hidden input yang menyimpan hasil capture/upload sebagai base64 --}}
                    <input type="hidden" name="foto_base64" id="foto_base64">

                    {{-- File input tersembunyi — dipicu oleh tombol "Upload Foto" --}}
                    <input type="file" id="input-upload-foto" accept="image/*" class="d-none">

                    <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
                        {{-- Preview foto --}}
                        <div id="foto-preview-wrap" class="border rounded-3 d-flex align-items-center justify-content-center bg-light"
                             style="width:120px;height:120px;overflow:hidden;flex-shrink:0;">
                            <span id="foto-placeholder" class="text-muted small text-center px-2">
                                <i class="fa-solid fa-image fa-2x d-block mb-1"></i>Belum ada foto
                            </span>
                            <img id="foto-preview-img" src="" alt="Preview Foto"
                                 class="img-fluid d-none" style="width:100%;height:100%;object-fit:cover;">
                        </div>

                        <div class="d-flex flex-column gap-2">
                            {{-- Grup dua tombol sejajar --}}
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                        id="btn-ambil-foto" data-bs-toggle="modal" data-bs-target="#modalKamera">
                                    <i class="fa-solid fa-camera me-2"></i>Ambil Foto
                                </button>
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                        id="btn-upload-foto">
                                    <i class="fa-solid fa-upload me-2"></i>Upload Foto
                                </button>
                            </div>
                            <button type="button" class="btn btn-outline-danger rounded-pill px-4 d-none"
                                    id="btn-hapus-foto">
                                <i class="fa-solid fa-trash me-2"></i>Hapus Foto
                            </button>
                            <small class="text-muted">Foto opsional. Ambil via kamera atau upload dari file.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5 pt-3 border-top gap-2">
                        <button type="reset" class="btn btn-light border px-4 shadow-sm rounded-pill" id="btn-batal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm rounded-pill">
                            <i class="fa-regular fa-floppy-disk me-2"></i>Simpan Data Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ====== MODAL KAMERA ====== --}}
    <div class="modal fade" id="modalKamera" tabindex="-1" aria-labelledby="modalKameraLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalKameraLabel">
                        <i class="fa-solid fa-camera me-2 text-primary"></i>Ambil Foto Customer
                    </h5>
                    <button type="button" class="btn-close" id="btn-close-modal" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center py-3">
                    {{-- Video live stream --}}
                    <div class="position-relative d-inline-block">
                        <video id="camera-video" autoplay playsinline muted
                               class="rounded-3 border"
                               style="width:100%;max-width:560px;background:#000;"></video>
                        <canvas id="camera-canvas" class="d-none"></canvas>
                    </div>

                    {{-- Pesan error kamera --}}
                    <div id="camera-error" class="alert alert-danger mt-3 d-none">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <span id="camera-error-msg">Tidak dapat mengakses kamera.</span>
                    </div>

                    {{-- Preview hasil capture --}}
                    <div id="capture-preview-wrap" class="mt-3 d-none">
                        <p class="text-muted small mb-1">Hasil capture:</p>
                        <img id="capture-preview-img" src="" alt="Hasil Capture"
                             class="rounded-3 border" style="max-width:320px;max-height:240px;object-fit:cover;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-between">
                    <button type="button" class="btn btn-light border rounded-pill px-4" id="btn-retake" style="display:none!important;">
                        <i class="fa-solid fa-rotate-left me-2"></i>Ulangi
                    </button>
                    <div class="ms-auto d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal" id="btn-cancel-modal">
                            Batal
                        </button>
                        <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" id="btn-capture">
                            <i class="fa-solid fa-camera me-2"></i>Ambil Foto
                        </button>
                        <button type="button" class="btn btn-success rounded-pill px-4 fw-bold d-none" id="btn-use-photo">
                            <i class="fa-solid fa-check me-2"></i>Gunakan Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ====== END MODAL KAMERA ====== --}}

@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.js"></script>
@endpush

@push('script')
    {{-- ====== SCRIPT KAMERA ====== --}}
    <script>
        (() => {
            let stream        = null;
            let capturedBlob  = null;

            const video            = document.getElementById('camera-video');
            const canvas           = document.getElementById('camera-canvas');
            const btnCapture       = document.getElementById('btn-capture');
            const btnRetake        = document.getElementById('btn-retake');
            const btnUsePhoto      = document.getElementById('btn-use-photo');
            const btnHapusFoto     = document.getElementById('btn-hapus-foto');
            const btnBatal         = document.getElementById('btn-batal');
            const capturePreview   = document.getElementById('capture-preview-wrap');
            const captureImg       = document.getElementById('capture-preview-img');
            const cameraError      = document.getElementById('camera-error');
            const cameraErrorMsg   = document.getElementById('camera-error-msg');
            const fotoBase64Input  = document.getElementById('foto_base64');
            const fotoPreviewImg   = document.getElementById('foto-preview-img');
            const fotoPlaceholder  = document.getElementById('foto-placeholder');
            const modalEl          = document.getElementById('modalKamera');
            const bsModal          = new bootstrap.Modal(modalEl);
            const btnUploadFoto    = document.getElementById('btn-upload-foto');
            const inputUploadFoto  = document.getElementById('input-upload-foto');

            /** Mulai stream kamera */
            async function startCamera() {
                cameraError.classList.add('d-none');
                capturePreview.classList.add('d-none');
                btnCapture.classList.remove('d-none');
                btnRetake.style.display = 'none !important';
                btnRetake.classList.add('d-none');
                btnUsePhoto.classList.add('d-none');
                video.classList.remove('d-none');

                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 720 } },
                        audio: false
                    });
                    video.srcObject = stream;
                } catch (err) {
                    cameraErrorMsg.textContent = 'Tidak dapat mengakses kamera: ' + err.message;
                    cameraError.classList.remove('d-none');
                    video.classList.add('d-none');
                }
            }

            /** Hentikan stream kamera */
            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(t => t.stop());
                    stream = null;
                }
                video.srcObject = null;
            }

            /** Capture frame dari video */
            function capturePhoto() {
                if (!stream) return;
                canvas.width  = video.videoWidth  || 640;
                canvas.height = video.videoHeight || 480;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

                const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                captureImg.src = dataUrl;
                capturePreview.classList.remove('d-none');

                // Tampilkan tombol retake & gunakan, sembunyikan capture
                btnCapture.classList.add('d-none');
                btnRetake.style.display = '';
                btnRetake.classList.remove('d-none');
                btnUsePhoto.classList.remove('d-none');

                // Pause video (stream tetap aktif agar retake cepat)
                video.pause();
                capturedBlob = dataUrl;
            }

            /** Ulangi capture */
            function retakePhoto() {
                capturePreview.classList.add('d-none');
                btnCapture.classList.remove('d-none');
                btnRetake.style.display = 'none !important';
                btnRetake.classList.add('d-none');
                btnUsePhoto.classList.add('d-none');
                capturedBlob = null;
                video.play();
            }

            /** Gunakan foto hasil capture */
            function usePhoto() {
                if (!capturedBlob) return;
                fotoBase64Input.value = capturedBlob;
                fotoPreviewImg.src    = capturedBlob;
                fotoPreviewImg.classList.remove('d-none');
                fotoPlaceholder.classList.add('d-none');
                btnHapusFoto.classList.remove('d-none');
                stopCamera();
                bsModal.hide();
            }

            /** Hapus foto yang sudah dipilih */
            function hapusFoto() {
                fotoBase64Input.value = '';
                fotoPreviewImg.src    = '';
                fotoPreviewImg.classList.add('d-none');
                fotoPlaceholder.classList.remove('d-none');
                btnHapusFoto.classList.add('d-none');
                capturedBlob = null;
            }

            // Event Listeners — Kamera
            modalEl.addEventListener('show.bs.modal',   startCamera);
            modalEl.addEventListener('hide.bs.modal',   stopCamera);
            btnCapture.addEventListener('click',         capturePhoto);
            btnRetake.addEventListener('click',          retakePhoto);
            btnUsePhoto.addEventListener('click',        usePhoto);
            btnHapusFoto.addEventListener('click',       hapusFoto);

            // Event Listeners — Upload dari file explorer
            btnUploadFoto.addEventListener('click', () => inputUploadFoto.click());

            inputUploadFoto.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                // Validasi: hanya gambar, maks 5 MB
                if (!file.type.startsWith('image/')) {
                    alert('File yang dipilih bukan gambar. Pilih file gambar (JPG, PNG, WEBP, dll).');
                    this.value = '';
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 5 MB.');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    const dataUrl = e.target.result;
                    fotoBase64Input.value = dataUrl;
                    fotoPreviewImg.src    = dataUrl;
                    fotoPreviewImg.classList.remove('d-none');
                    fotoPlaceholder.classList.add('d-none');
                    btnHapusFoto.classList.remove('d-none');
                    // Bersihkan nilai input file agar onChange terpicu lagi jika pilih file sama
                    inputUploadFoto.value = '';
                };
                reader.readAsDataURL(file);
            });

            // Reset foto saat tombol Batal form ditekan
            btnBatal.addEventListener('click', () => {
                hapusFoto();
            });
        })();
    </script>
    {{-- ====== END SCRIPT KAMERA ====== --}}
@endpush

@push('script')
    <!-- Sama persis layaknya di view.blade.php (Axios style dengan Ajax jQuery) -->
    <script>
        $(document).ready(function () {

            ['#select_provinsi', '#select_kota', '#select_kecamatan', '#select_kelurahan'].forEach(id => (new SlimSelect({ select: id })))

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
                    console.error(err)
                }
            })

            // Level 1: Pilih Prov Load Kota
            prov_select.change(function (e) {
                let load_opt = $("<option>", { text: '-- Loading... --', value: '0' })
                if (this.value != '0') kota_select.html(load_opt)

                if (this.value == '0') {
                    let def_opt = $("<option>", { text: '-- Pilih Provinsi Dahulu --', value: '0' })
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
                        let kota_list = response.data.kota
                        if (kota_list.length > 0) {
                            let def_opt = $("<option>", { text: '-- Pilih Kota --', value: '0' })
                            kota_select.html(def_opt)
                            kota_list.forEach((k) => {
                                let opt = $("<option>", { text: k.name, value: k.id })
                                opt.appendTo(kota_select)
                            })
                        }
                    },
                    error: function (err) { console.error(err) }
                })
            })

            // Level 2: Pilih Kota Load Kecamatan
            kota_select.change(function (e) {
                let load_opt = $("<option>", { text: '-- Loading... --', value: '0' })
                if (this.value != '0') kecamatan_select.html(load_opt)

                if (this.value == '0') {
                    let def_opt = $("<option>", { text: '-- Pilih Kota Dahulu --', value: '0' })
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
                        let kecamatan_list = response.data.kecamatan
                        if (kecamatan_list.length > 0) {
                            let def_opt = $("<option>", { text: '-- Pilih Kecamatan --', value: '0' })
                            kecamatan_select.html(def_opt)
                        }
                        kecamatan_list.forEach((k) => {
                            let opt = $("<option>", { text: k.name, value: k.id })
                            opt.appendTo(kecamatan_select)
                        })
                    },
                    error: function (err) { console.error(err) }
                })
            })

            // Level 3: Pilih Kecamatan Load Kelurahan
            kecamatan_select.change(function (e) {
                let load_opt = $("<option>", { text: '-- Loading... --', value: '0' })
                if (this.value != '0') kelurahan_select.html(load_opt)

                if (this.value == '0') {
                    let def_opt = $("<option>", { text: '-- Pilih Kecamatan Dahulu --', value: '0' })
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
                        let kelurahan_list = response.data.kelurahan
                        if (kelurahan_list.length > 0) {
                            let def_opt = $("<option>", { text: '-- Pilih Kelurahan --', value: '0' })
                            kelurahan_select.html(def_opt)
                        }
                        kelurahan_list.forEach((k) => {
                            let opt = $("<option>", { text: k.name, value: k.id })
                            opt.appendTo(kelurahan_select)
                        })
                    },
                    error: function (err) { console.error(err) }
                })
            })
        });
    </script>
@endpush

@push('page_style')
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet" />
    <style>
        .text-primary { color: #7e22ce !important; }
        .bg-primary { background-color: #a855f7 !important; }
        .btn-primary { background-color: #a855f7 !important; border-color: #a855f7 !important; }
        .btn-primary:hover { background-color: #9333ea !important; border-color: #9333ea !important; }
        .form-control:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 0.25rem rgba(168, 85, 247, 0.25);
        }
        .card.shadow-sm { box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.05) !important; }
    </style>
@endpush