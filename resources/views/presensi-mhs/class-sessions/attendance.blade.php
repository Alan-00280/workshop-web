@extends('layouts.app')

@section('db-page-title', 'Presensi Sesi Kelas')
@section('icon-page')
    <i class="fa-solid fa-clipboard-user"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('show-class-sessions') }}">Sesi Kelas</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Presensi</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('show-class-sessions') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
        <button id="btn-scan-nfc-presensi" class="btn btn-gradient-primary btn-icon-text font-weight-bold shadow-sm">
            <i class="fa-solid fa-id-card me-2"></i> Mode Scan NFC
        </button>
    </div>

    <!-- Info Detail Sesi -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 bg-light rounded">
            <div class="row">
                <div class="col-md-6 border-right">
                    <span class="badge bg-primary text-white px-2.5 py-1 mb-2 font-weight-bold">
                        {{ $session->class->name ?? 'Kelas N/A' }}
                    </span>
                    <h4 class="font-weight-bold text-dark mb-1">
                        {{ $session->class->course->name ?? 'Mata Kuliah N/A' }}
                    </h4>
                    <small class="text-muted d-block mb-3">
                        <i class="fa-solid fa-code me-1 text-secondary"></i> Kode: {{ $session->class->course->course_code ?? '-' }}
                    </small>
                    <p class="mb-0 text-secondary">
                        <strong class="text-dark"><i class="fa-solid fa-book-open text-primary me-1"></i> Pembahasan Materi:</strong><br>
                        {{ $session->materi }}
                    </p>
                </div>
                <div class="col-md-6 ps-md-4 mt-3 mt-md-0 d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="text-dark font-weight-bold mb-2">
                            <i class="fa-regular fa-clock text-primary me-1"></i> Jadwal Sesi Pertemuan:
                        </h6>
                        <p class="text-secondary mb-1">
                            <strong>Tanggal:</strong> {{ $session->timestamp ? $session->timestamp->format('d F Y') : '-' }}
                        </p>
                        <p class="text-secondary mb-3">
                            <strong>Pukul:</strong> {{ $session->timestamp ? $session->timestamp->format('H:i') : '-' }} WIB
                        </p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <small class="text-muted d-block">Total Mahasiswa</small>
                            <span class="h4 font-weight-bold text-dark" id="total-students">{{ $session->attendances->count() }}</span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Telah Hadir</small>
                            <span class="h4 font-weight-bold text-success" id="present-students">{{ $session->attendances->where('status', 'PRESENT')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Siswa & Presensi -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h5 class="mb-0 font-weight-bold d-flex align-items-center">
                <i class="fa-solid fa-users me-2"></i> Daftar Hadir Mahasiswa
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="attendance-table">
                    <thead class="table-light text-secondary font-weight-bold">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>NIM / No. Induk</th>
                            <th>Nama Lengkap</th>
                            <th>Program Studi</th>
                            <th>Status Kehadiran</th>
                            <th class="pe-4 text-center">Aksi Manual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($session->attendances) > 0)
                            @foreach ($session->attendances as $attendance)
                                <tr id="row-attendance-{{ $attendance->id }}" data-student-id="{{ $attendance->student_id }}">
                                    <td class="ps-4 font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-dark px-2.5 py-1.5 font-weight-semibold">
                                            {{ $attendance->student->no_induk ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="font-weight-bold text-dark">
                                        {{ $attendance->student->userCampus->userSystem->name ?? '-' }}
                                    </td>
                                    <td class="text-muted">
                                        {{ $attendance->student->program ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="status-badge badge {{ $attendance->status === 'PRESENT' ? 'bg-success' : 'bg-danger' }} text-white px-2.5 py-1.5 rounded">
                                            <i class="fa-solid {{ $attendance->status === 'PRESENT' ? 'fa-check' : 'fa-xmark' }} me-1"></i>
                                            <span class="status-text">{{ $attendance->status === 'PRESENT' ? 'Hadir' : 'Absen' }}</span>
                                        </span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <button class="btn btn-sm btn-toggle-attendance {{ $attendance->status === 'PRESENT' ? 'btn-outline-danger' : 'btn-primary' }}" 
                                                data-id="{{ $attendance->id }}"
                                                data-url="{{ route('toggle-attendance', $attendance->id) }}">
                                            <i class="fa-solid {{ $attendance->status === 'PRESENT' ? 'fa-user-slash' : 'fa-user-check' }} me-1"></i>
                                            <span class="btn-text">{{ $attendance->status === 'PRESENT' ? 'Absenkan' : 'Hadirkan' }}</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-users-slash fa-3x mb-3 text-secondary d-block"></i>
                                    Belum ada daftar mahasiswa yang terdaftar di kelas sesi ini.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
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
            const beepSound = new Audio('/assets/sound/beep.mp3');

            // CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function playSuccessBeep(beepSound) {
                beepSound.play()
            }

            // AJAX Manual Attendance Toggle
            $('.btn-toggle-attendance').on('click', function(e) {
                e.preventDefault();
                const btn = $(this);
                const id = btn.data('id');
                const url = btn.data('url');

                btn.prop('disabled', true);

                $.post(url, function(res) {
                    btn.prop('disabled', false);
                    if (res.success) {
                        // Update table row status badge
                        const row = $(`#row-attendance-${id}`);
                        const badge = row.find('.status-badge');
                        const statusText = row.find('.status-text');

                        if (res.status === 'PRESENT') {
                            badge.removeClass('bg-danger').addClass('bg-success');
                            badge.find('i').removeClass('fa-xmark').addClass('fa-check');
                            statusText.text('Hadir');

                            btn.removeClass('btn-primary').addClass('btn-outline-danger');
                            btn.find('i').removeClass('fa-user-check').addClass('fa-user-slash');
                            btn.find('.btn-text').text('Absenkan');
                        } else {
                            badge.removeClass('bg-success').addClass('bg-danger');
                            badge.find('i').removeClass('fa-check').addClass('fa-xmark');
                            statusText.text('Absen');

                            btn.removeClass('btn-outline-danger').addClass('btn-primary');
                            btn.find('i').removeClass('fa-user-slash').addClass('fa-user-check');
                            btn.find('.btn-text').text('Hadirkan');
                        }

                        // Update counts
                        let presentCount = parseInt($('#present-students').text());
                        if (res.status === 'PRESENT') {
                            presentCount++;
                        } else {
                            presentCount--;
                        }
                        $('#present-students').text(presentCount);

                        // Success toast
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }).fail(function() {
                    btn.prop('disabled', false);
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem saat memproses permintaan manual.',
                        icon: 'error',
                        confirmButtonColor: '#fe7c96'
                    });
                });
            });

            // NFC Scanner Setup
            const hasNFC = 'NDEFReader' in window;

            $('#btn-scan-nfc-presensi').on('click', async function() {
                if (!hasNFC) {
                    // Manual Simulation Fallback for testing
                    Swal.fire({
                        title: 'Simulasi NFC Card Scan',
                        text: 'Browser/perangkat Anda tidak mendukung Web NFC. Silakan masukkan NFC UID siswa secara manual untuk simulasi.',
                        input: 'text',
                        inputPlaceholder: 'Contoh: Scanned NFC UID (e.g. A1B2C3D4)',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Simulasikan Scan',
                        confirmButtonColor: '#b66dff',
                        cancelButtonColor: '#343a40',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'NFC UID tidak boleh kosong!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            sendNFCTag(result.value);
                        }
                    });
                    return;
                }

                // Real Web NFC Scanning
                try {
                    const ndef = new NDEFReader();
                    await ndef.scan();

                    Swal.fire({
                        title: 'Mode Scan NFC Aktif',
                        text: 'Silakan dekatkan kartu NFC siswa Anda ke sensor perangkat untuk pencatatan presensi.',
                        icon: 'info',
                        showCancelButton: true,
                        cancelButtonText: 'Nonaktifkan',
                        cancelButtonColor: '#343a40',
                        confirmButtonColor: '#b66dff',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.cancel) {
                            // Stop or cancel scanning status
                        }
                    });

                    ndef.onreading = (event) => {
                        const serialNumber = event.serialNumber;
                        if (serialNumber) {
                            Swal.close();
                            sendNFCTag(serialNumber);
                        }
                    };

                    ndef.onreadingerror = () => {
                        Swal.fire({
                            title: 'Error Pemindaian',
                            text: 'Gagal mendeteksi data kartu. Harap coba tempelkan kembali.',
                            icon: 'warning',
                            confirmButtonColor: '#fe7c96'
                        });
                    };

                } catch (err) {
                    Swal.fire({
                        title: 'NFC Error',
                        text: 'Gagal menginisialisasi modul NFC: ' + err.message,
                        icon: 'error',
                        confirmButtonColor: '#fe7c96'
                    });
                }
            });

            // Send AJAX POST for NFC scan
            function sendNFCTag(uid) {
                const url = "{{ route('nfc-attendance', $session->id) }}";

                Swal.fire({
                    title: 'Memproses Presensi...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.post(url, { nfc_uid: uid }, function(res) {
                    Swal.close();
                    if (res.success) {
                        playSuccessBeep(beepSound);

                        if (res.already_present) {
                            Swal.fire({
                                title: 'Siswa Sudah Hadir',
                                text: res.message,
                                icon: 'info',
                                confirmButtonColor: '#b66dff',
                                timer: 2000
                            });
                        } else {
                            // Dynamic Update Row if they are on page
                            Swal.fire({
                                title: '✓ Presensi Sukses!',
                                text: res.message,
                                icon: 'success',
                                confirmButtonColor: '#b66dff',
                                timer: 1500,
                                didClose: () => {
                                    // Reload to update stats and listings correctly
                                    window.location.reload();
                                }
                            });
                        }
                    }
                }).fail(function(xhr) {
                    Swal.close();
                    const errMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Kesalahan sistem saat memproses scan kartu.';
                    Swal.fire({
                        title: 'Presensi Gagal',
                        text: errMsg,
                        icon: 'error',
                        confirmButtonColor: '#fe7c96'
                    });
                });
            }
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
        .border-right {
            border-right: 1px solid #e9ecef;
        }
        @media (max-width: 768px) {
            .border-right {
                border-right: none !important;
            }
        }
    </style>
@endpush