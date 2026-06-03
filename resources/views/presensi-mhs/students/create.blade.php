@extends('layouts.app')

@section('db-page-title', 'Tambah Mahasiswa')
@section('icon-page')
    <i class="fa-solid fa-user-plus"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('show-students') }}">Daftar Mahasiswa</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Tambah</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container mt-1" style="padding-left:0">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h5 class="mb-0 font-weight-bold d-flex align-items-center">
                            <i class="fa-solid fa-address-card me-2"></i> Form Data Siswa Baru
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <!-- Alert Info / Warning support NFC -->
                        <div id="nfc-browser-status" class="alert alert-info d-flex align-items-center mb-4" role="alert">
                            <i class="fa-solid fa-circle-info fa-lg me-2 text-primary"></i>
                            <div>
                                Perangkat mendukung Web NFC. Anda dapat menempelkan kartu untuk mengisi UID secara otomatis.
                            </div>
                        </div>

                        <form id="form-student" action="{{ route('store-student') }}" method="POST" class="forms-sample">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="name" class="font-weight-medium text-dark">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap siswa" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="email" class="font-weight-medium text-dark">Alamat Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="siswa@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="no_hp" class="font-weight-medium text-dark">No. Handphone (Maksimal 12 Digit)</label>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" maxlength="12" required>
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="tanggal_lahir" class="font-weight-medium text-dark">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="program" class="font-weight-medium text-dark">Program Studi</label>
                                    <input type="text" class="form-control @error('program') is-invalid @enderror" id="program" name="program" value="{{ old('program') }}" placeholder="Teknik Informatika / Sistem Informasi" required>
                                    @error('program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="font-weight-medium text-muted">Password Akun (Autofill)</label>
                                <input type="text" class="form-control bg-light text-muted border-0" id="password" value="11223344" readonly disabled>
                                <small class="text-muted">Password sistem bawaan untuk login pertama kali.</small>
                            </div>

                            <!-- NFC UID input (hidden by default or shown for manual simulation) -->
                            <div class="form-group mb-4" id="nfc-uid-container">
                                <label for="nfc_uid" class="font-weight-bold text-dark d-flex align-items-center">
                                    NFC Card UID <span class="badge bg-primary ms-2" id="nfc-badge">Otomatis (NFC)</span>
                                </label>
                                <input type="hidden" class="form-control @error('nfc_uid') is-invalid @enderror" id="nfc_uid" name="nfc_uid" value="{{ old('nfc_uid') }}" required>
                                @error('nfc_uid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <a href="{{ route('show-students') }}" class="btn btn-outline-secondary btn-icon-text font-weight-medium shadow-sm">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="button" id="btn-submit-nfc" class="btn btn-gradient-primary btn-icon-text font-weight-bold shadow-sm">
                                    <i class="fa-solid fa-id-card me-1"></i> Scan NFC & Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- NFC Instructions Card -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0 font-weight-bold d-flex align-items-center">
                            <i class="fa-solid fa-circle-question me-2"></i> Panduan Registrasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-gradient-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold;">1</div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Isi Data Siswa</h6>
                                <p class="text-muted small">Lengkapi informasi pribadi siswa (Nama, Email, Program Studi, dll).</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-gradient-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold;">2</div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Scan Kartu NFC</h6>
                                <p class="text-muted small">Klik tombol <b>Scan NFC & Simpan</b> untuk memicu pembaca NFC, lalu dekatkan kartu mahasiswa ke bagian belakang perangkat.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="bg-gradient-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold;">3</div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Penyimpanan Berhasil</h6>
                                <p class="text-muted small">Setelah kartu terbaca, sistem akan mendaftarkan akun beserta UID NFC secara otomatis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            const hasNFC = 'NDEFReader' in window;
            const statusBox = $('#nfc-browser-status');
            const nfcUidInput = $('#nfc_uid');
            const nfcBadge = $('#nfc-badge');

            if (!hasNFC) {
                // If Web NFC is not supported on this browser/device
                statusBox.removeClass('alert-info').addClass('alert-warning');
                statusBox.html('<i class="fa-solid fa-triangle-exclamation fa-lg me-2 text-warning"></i><div>Perangkat/Browser ini tidak mendukung Web NFC. Anda harus mengisi NFC UID secara manual untuk pengujian.</div>');
                
                // Show input manual
                nfcUidInput.attr('type', 'text');
                nfcUidInput.attr('placeholder', 'Contoh: 04:A1:B2:C3:D4:E5:F6');
                nfcBadge.removeClass('bg-primary').addClass('bg-warning').text('Manual Input');
            }

            // Form Submit / NFC Scan trigger
            $('#btn-submit-nfc').on('click', async function() {
                // First validate standard fields
                const name = $('#name').val().trim();
                const email = $('#email').val().trim();
                const no_hp = $('#no_hp').val().trim();
                const tanggal_lahir = $('#tanggal_lahir').val();
                const program = $('#program').val().trim();

                if (!name || !email || !no_hp || !tanggal_lahir || !program) {
                    Swal.fire({
                        title: 'Form Belum Lengkap',
                        text: 'Silakan isi semua data siswa terlebih dahulu sebelum memindai kartu.',
                        icon: 'warning',
                        confirmButtonColor: '#fe7c96'
                    });
                    return;
                }

                if (!hasNFC) {
                    // Manual Flow (simulation)
                    const valUid = nfcUidInput.val().trim();
                    if (!valUid) {
                        Swal.fire({
                            title: 'UID NFC Kosong',
                            text: 'Harap isi kolom NFC UID secara manual sebelum menyimpan.',
                            icon: 'warning',
                            confirmButtonColor: '#fe7c96'
                        });
                        return;
                    }
                    // Submit form
                    $('#form-student').submit();
                    return;
                }

                // NFC Scanning Flow
                try {
                    const ndef = new NDEFReader();
                    await ndef.scan();

                    // Show beautiful scan modal
                    Swal.fire({
                        title: 'Menunggu Kartu NFC...',
                        text: 'Silakan dekatkan/tempelkan kartu NFC ke bagian sensor perangkat Anda.',
                        icon: 'info',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#343a40',
                        confirmButtonColor: '#b66dff',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.cancel) {
                            // Stop or ignore scanning
                        }
                    });

                    ndef.onreading = (event) => {
                        const serialNumber = event.serialNumber;
                        if (serialNumber) {
                            nfcUidInput.val(serialNumber);
                            
                            // Success dialog
                            Swal.fire({
                                title: '✓ Pemindaian Berhasil!',
                                text: `Kartu terdeteksi dengan UID: ${serialNumber}. Sedang menyimpan data siswa...`,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                didClose: () => {
                                    $('#form-student').submit();
                                }
                            });
                        }
                    };

                    ndef.onreadingerror = () => {
                        Swal.fire({
                            title: 'Gagal Membaca Kartu',
                            text: 'Format kartu tidak didukung atau posisi kurang tepat. Coba lagi.',
                            icon: 'error',
                            confirmButtonColor: '#fe7c96'
                        });
                    };

                } catch (err) {
                    Swal.fire({
                        title: 'NFC Error',
                        text: 'Terjadi kesalahan saat mengaktifkan sensor NFC: ' + err.message,
                        icon: 'error',
                        confirmButtonColor: '#fe7c96'
                    });
                }
            });
        });
    </script>
@endpush

@push('page_style')
    <style>
        .btn-gradient-primary {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            border: 0;
            color: #fff;
            transition: opacity 0.3s ease;
        }
        .btn-gradient-primary:hover {
            opacity: 0.9;
            color: #fff;
        }
        .card-header.bg-gradient-primary {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
        }
        .form-control:focus {
            border-color: #da8cff;
            box-shadow: 0 0 0 0.2rem rgba(218, 140, 255, 0.25);
        }
    </style>
@endpush
