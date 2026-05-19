@extends('mpp.layouts.dashboard')

@section('db-page-title', 'Dashboard')
@section('icon-page')
    <i class="fa-solid fa-table-cells-large"></i>
@endsection

{{-- Page Style --}}
@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dashboard-container {
            background-color: #f3f4f6;
            /* Abu terang */
            padding: 1.5rem;
            min-height: calc(100vh - 60px);
            overflow-y: auto;
            border-radius: 0.625rem;
        }

        .dot-connected {
            width: 10px;
            height: 10px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 5px #10b981;
        }

        .dot-disconnected {
            width: 10px;
            height: 10px;
            background-color: #b91010;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 5px #b91010;
        }

        .dot-waiting {
            width: 10px;
            height: 10px;
            background-color: #e4e71a;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 5px #a2b30b;
        }

        /* Current Called Card */
        .card-called {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fde68a;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .called-number {
            font-size: 3.5rem;
            font-weight: 800;
            color: #78350f;
            /* Coklat tua */
            line-height: 1;
        }

        .btn-call-next {
            background-color: #f97316;
            border-color: #ea580c;
        }

        .btn-call-next:hover {
            background-color: rgb(202, 71, 0);
        }

        .badge-called {
            background-color: #f59e0b;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 50rem;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-block;
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-icon {
            position: absolute;
            top: 1rem;
            left: 1rem;
            font-size: 1.5rem;
            opacity: 0.5;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-top: 1rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 500;
            opacity: 0.9;
        }

        .bg-gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .bg-gradient-orange {
            background: linear-gradient(135deg, #f59e0b 0%, #c2410c 100%);
        }

        .bg-gradient-red {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        }

        .bg-gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        }

        /* Table */
        .table-custom tbody {
            display: block;
            max-height: 878px;
            overflow-y: auto;
        }

        .table-custom thead,
        .table-custom tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .table-custom th {
            background-color: #1e3a8a;
            color: white;
            font-weight: 600;
            border: none;
        }

        .table-custom td {
            vertical-align: middle;
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-2 bg-white px-3 py-1 rounded-pill shadow-sm border"
                id="terhubung-text">
                <span class="dot-waiting"></span>
                <span class="small fw-bold text-warning">Memuat...</span>
            </div>
        </div>


        <div class="row mb-4">
            <div class="d-flex flex-column gap-3">
                <button id="btn-call-next"
                    class="btn-call-next  text-white fw-bold py-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-bullhorn"></i> Panggil Berikutnya
                </button>
                <button id="btn-reset-status"
                    class="btn btn-outline-danger bg-white fw-bold py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-arrow-rotate-right"></i> Reset Antrian Hari ini
                </button>
                <a class="btn btn-outline-primary bg-white fw-bold py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2"
                    href="{{ route('mpp-monitor-antree') }}">
                    <i class="fa-solid fa-desktop"></i> Buka Papan Antrian
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div>

                <!-- Current Called -->
                <div id="current-called" class="mb-4 hidden">
                    <div class="text-uppercase small text-muted fw-bold mb-2" style="letter-spacing: 0.1em;">Sedang
                        Dipanggil</div>
                    <div class="card-called d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="called-number">001</div>
                        <div
                            class="text-center px-2 px-md-4 border-md-start border-md-end border-warning border-opacity-50 mx-md-2 flex-grow-1">
                            <div class="fs-4 fw-bold text-dark">Budi Hermawan</div>
                            <div class="small text-muted">Layanan Umum</div>
                        </div>
                        <div class="text-end">
                            <span class="badge-called shadow-sm">
                                <i class="fa-solid fa-microphone-lines me-1"></i> Dipanggil
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card bg-gradient-blue">
                            <i class="fa-solid fa-users stat-icon"></i>
                            <div class="stat-value" id="stat-waiting">1</div>
                            <div class="stat-label">Menunggu</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card bg-gradient-orange">
                            <i class="fa-solid fa-headset stat-icon"></i>
                            <div class="stat-value" id="stat-called">1</div>
                            <div class="stat-label">Dipanggil</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card bg-gradient-red">
                            <i class="fa-solid fa-clock-rotate-left stat-icon"></i>
                            <div class="stat-value" id="stat-late">0</div>
                            <div class="stat-label">Terlambat</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card bg-gradient-green">
                            <i class="fa-solid fa-check-circle stat-icon"></i>
                            <div class="stat-value" id="stat-done">0</div>
                            <div class="stat-label">Selesai</div>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Daftar Antrian Hari Ini <span
                                    class="badge bg-primary ms-2 rounded-pill">{{ is_array($antrians) || $antrians instanceof \Countable ? count($antrians) : 0 }}</span>
                            </h5>
                        </div>

                        {{-- <x-logger-str object="{{ $antrians }}" /> --}}

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Loket</th>
                                        <th>Layanan</th>
                                        <th>Jam Daftar</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($antrians as $antrian)
                                        <tr>
                                            <td class="fw-bold">{{ str_pad($antrian->no_urut, 3, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $antrian->nama }}</td>
                                            <td>{{ $antrian->layanan?->kategori_layanan?->nama_kat ?? 'Loket' }}</td>
                                            <td>{{ $antrian->layanan?->nama ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($antrian->waktu_daftar)->format('H:i:s') }}</td>
                                            <td>
                                                @if($antrian->status == 'waiting')
                                                    <span class="badge bg-secondary">Menunggu</span>
                                                @elseif($antrian->status == 'called')
                                                    <span class="badge bg-warning text-dark">Dipanggil</span>
                                                @elseif($antrian->status == 'done')
                                                    <span class="badge bg-success">Selesai</span>
                                                @elseif($antrian->status == 'late')
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-light text-dark">{{ $antrian->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary btn-call" title="Panggil"
                                                        data-id-antrian="{{ $antrian->id }}"><i
                                                            class="fa-solid fa-bullhorn"></i></button>
                                                    <button class="btn btn-outline-success btn-done"
                                                        data-id-antrian="{{ $antrian->id }}" title="Selesai"><i
                                                            class="fa-solid fa-check"></i></button>
                                                    <button class="btn btn-outline-danger btn-cancel"
                                                        data-id-antrian="{{ $antrian->id }}" title="Batal"><i
                                                            class="fa-solid fa-business-time"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Belum ada antrian hari ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

{{-- CDNs --}}
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

{{-- scripts --}}
@push('script')
    <script>
        const terhubungUI = document.getElementById('terhubung-text');
        const tableBody = document.querySelector('.table-custom tbody');
        const tableBadgeCount = document.querySelector('h5 .badge.bg-primary');
        const btnCallNext = document.getElementById('btn-call-next');
        const btnResetStatus = document.getElementById('btn-reset-status');

        let nextAntrian

        // Membuka koneksi SSE di JavaScript
        const source = new EventSource('/mpp/sse/antrian');

        // Event Antrian 
        source.addEventListener('antrian-update', function (event) {
            const sse_data = JSON.parse(event.data);

            // Filter antrian dengan status "waiting"
            const waitingList = sse_data.filter(item => item.status === "waiting");

            // Ambil antrian berikutnya (misalnya urutan terkecil)
            if (waitingList.length > 0) {
                nextAntrian = waitingList[0];
            } else {
                nextAntrian = null;
            }

            // Update UI status terhubung
            terhubungUI.innerHTML = `
                     <span class="dot-connected"></span>
                     <span class="small fw-bold text-success">Terhubung</span>
                 `;

            // Update badge jumlah antrian
            if (tableBadgeCount) {
                tableBadgeCount.textContent = sse_data.length;
            }

            // Update tabel
            let tableHtml = '';

            if (sse_data.length === 0) {
                tableHtml = `
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada antrian hari ini.</td>
                        </tr>
                    `;
            } else {
                sse_data.forEach(item => {
                    const noUrut = String(item.no_urut).padStart(3, '0');
                    const nama = item.nama;
                    const loket = item.layanan?.kategori_layanan?.nama_kat || 'Loket';
                    const layanan = item.layanan?.nama || '-';
                    const waktuDaftar = item.waktu_daftar ? item.waktu_daftar.split(' ')[1] : '-';

                    let statusHtml = '';
                    let actionHtml = '';

                    // Format status & tombol aksi
                    if (item.status === 'waiting') {
                        statusHtml = '<span class="badge bg-secondary">Menunggu</span>';
                        actionHtml += `<button class="btn btn-outline-primary" title="Panggil"><i class="fa-solid fa-bullhorn btn-call" data-id-antrian="${item.id}"></i></button> <button class="btn btn-outline-success btn-done" data-id-antrian="${item.id}" title="Selesai"><i class="fa-solid fa-check"></i></button>`;
                        actionHtml += `<button class="btn btn-outline-danger btn-cancel" data-id-antrian="${item.id}" title="Batal"><i class="fa-solid fa-business-time"></i></button>`;
                    } else if (item.status === 'called') {
                        statusHtml = '<span class="badge bg-warning text-dark">Dipanggil</span>';
                        actionHtml += `<button class="btn btn-outline-primary" title="Panggil"><i class="fa-solid fa-bullhorn btn-call" data-id-antrian="${item.id}"></i></button>` 
                        actionHtml += `<button class="btn btn-outline-success btn-done" data-id-antrian="${item.id}" title="Selesai"><i class="fa-solid fa-check"></i></button>`;
                        actionHtml += `<button class="btn btn-outline-danger btn-cancel" data-id-antrian="${item.id}" title="Batal"><i class="fa-solid fa-business-time"></i></button>`;
                    } else if (item.status === 'done') {
                        statusHtml = '<span class="badge bg-success">Selesai</span>';
                        actionHtml += `Selesai <i class="fa-solid fa-check text-success px-1"></i>`;
                    } else if (item.status === 'late') {
                        statusHtml = '<span class="badge bg-danger">Terlambat</span>';
                        actionHtml += `<button class="btn btn-outline-primary" title="Panggil"><i class="fa-solid fa-bullhorn btn-call" data-id-antrian="${item.id}"></i></button>` 
                        actionHtml += `<button class="btn btn-outline-success btn-done" data-id-antrian="${item.id}" title="Selesai"><i class="fa-solid fa-check"></i></button>`;
                    } else {
                        statusHtml = `<span class="badge bg-light text-dark">${item.status}</span>`;
                        actionHtml += `Error <i class="fa-solid fa-xmark text-danger px-1"></i>`;
                    }

                    tableHtml += `
                            <tr>
                                <td class="fw-bold">${noUrut}</td>
                                <td>${nama}</td>
                                <td>${loket}</td>
                                <td>${layanan}</td>
                                <td>${waktuDaftar}</td>
                                <td>${statusHtml}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        ${actionHtml}
                                    </div>
                                </td>
                            </tr>
                        `;
                });
            }

            if (tableBody) {
                tableBody.innerHTML = tableHtml;
            }

            console.log("Antrian updated via SSE:", sse_data);
            
            // =======================
            // SETTING TOMBOL PER BARIS 
            // =======================
            const btnCallTable = document.querySelectorAll('.btn-call');
            const btnDoneTable = document.querySelectorAll('.btn-done');
            const btnCancelTable = document.querySelectorAll('.btn-cancel');

            // Panggil Lewat Tombol Tabel
            btnCallTable.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    const idAntrian = e.currentTarget.dataset.idAntrian

                    // Nonaktifkan tombol untuk mencegah spam klik
                    const originalContent = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = ''
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

                    $.ajax({
                        url: `/ticket/panggil/${idAntrian}`,
                        type: 'POST',
                        data: {
                            status: 'called',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log("Response Panggil Lewat Tabel:", response);
                        },
                        error: function (xhr) {
                            console.error("Error Panggil Lewat Tabel:", xhr);
                        },
                        complete: function () {
                            // Aktifkan kembali tombol setelah menerima response (berhasil/gagal)
                            btn.disabled = false;
                            btn.innerHTML = originalContent;
                        }
                    });
                })
            })

            // Done Lewat Tombol Tabel
            btnDoneTable.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    const idAntrian = e.currentTarget.dataset.idAntrian

                    // Nonaktifkan tombol untuk mencegah spam klik
                    const originalContent = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = ''
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

                    $.ajax({
                        url: `/ticket/done/${idAntrian}`,
                        type: 'POST',
                        data: {
                            status: 'done',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log("Response Done Lewat Tabel:", response);
                        },
                        error: function (xhr) {
                            console.error("Error Done Lewat Tabel:", xhr);
                        },
                        complete: function () {
                            // Aktifkan kembali tombol setelah menerima response (berhasil/gagal)
                            btn.disabled = false;
                            btn.innerHTML = originalContent;
                        }
                    });
                })
            })

            // Telat Lewat Tombol Tabel
            btnCancelTable.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    const idAntrian = e.currentTarget.dataset.idAntrian

                    // Nonaktifkan tombol untuk mencegah spam klik
                    const originalContent = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = ''
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

                    $.ajax({
                        url: `/ticket/telat/${idAntrian}`,
                        type: 'POST',
                        data: {
                            status: 'late',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log("Response Telat Lewat Tabel:", response);
                        },
                        error: function (xhr) {
                            console.error("Error Telat Lewat Tabel:", xhr);
                        },
                        complete: function () {
                            // Aktifkan kembali tombol setelah menerima response (berhasil/gagal)
                            btn.disabled = false;
                            btn.innerHTML = originalContent;
                        }
                    });
                })
            })
        });

        // Event Statistic
        source.addEventListener('antrian-statistic', function (e) {
            const sse_data = JSON.parse(e.data); // Fixed e.data instead of event.data

            const statWaiting = document.getElementById('stat-waiting');
            const statCalled = document.getElementById('stat-called');
            const statLate = document.getElementById('stat-late');
            const statDone = document.getElementById('stat-done');

            if (statWaiting) statWaiting.textContent = sse_data.waiting || 0;
            if (statCalled) statCalled.textContent = sse_data.called || 0;
            if (statLate) statLate.textContent = sse_data.late || 0;
            if (statDone) statDone.textContent = sse_data.done || 0;

            console.log("Statistic updated via SSE:", sse_data);
        });

        // Event Panggilan
        source.addEventListener('antrian-called', function (e) {
            const sse_data = JSON.parse(e.data);

            // Update UI
            const currentCalled = document.getElementById('current-called');
            if (currentCalled && sse_data) {
                const noUrut = String(sse_data.antrian_called.no_urut).padStart(3, '0');
                const nama = sse_data.antrian_called.nama;
                const layanan = sse_data.antrian_called.layanan?.nama || '-';

                currentCalled.querySelector('.called-number').textContent = noUrut;
                currentCalled.querySelector('.fs-4.fw-bold.text-dark').textContent = nama;
                currentCalled.querySelector('.flex-grow-1 .small.text-muted').textContent = layanan;

                currentCalled.classList.remove('hidden');
            } else {
                if (currentCalled) {
                    currentCalled.querySelector('.called-number').textContent = '';
                    currentCalled.querySelector('.fs-4.fw-bold.text-dark').textContent = '';
                    currentCalled.querySelector('.flex-grow-1 .small.text-muted').textContent = '';

                    currentCalled.classList.add('hidden');
                }
            }

            console.log("Dipanggil updated via SSE:", sse_data);
        });

        // Handler error & disconnect
        source.onerror = function (error) {
            if (source.readyState === EventSource.CLOSED) {
                // Status benar-benar mati total
                terhubungUI.innerHTML = `
                        <span class="dot-disconnected"></span>
                        <span class="small fw-bold text-danger">Terputus</span>
                    `;
                console.error("Koneksi SSE terputus/ditutup.");
            }
        };
        
        // Tutup saat tab / browser ditutup atau reload
        window.addEventListener('beforeunload', () => {
            source.close();
        });
        window.addEventListener('pagehide', () => {
            source.close();
        });

        // Handle Panggil
        // Panggil Berikutnya
        btnCallNext.addEventListener('click', (e) => {
            if (!nextAntrian) {
                Swal.fire('Info', 'Tidak ada antrian yang menunggu.', 'info');
                return;
            }

            // Nonaktifkan tombol untuk mencegah spam klik
            const originalContent = btnCallNext.innerHTML;
            btnCallNext.disabled = true;
            btnCallNext.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

            $.ajax({
                url: `/ticket/panggil/${nextAntrian.id}`,
                type: 'POST',
                data: {
                    status: 'called',
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log("Response Panggil Berikutnya:", response);
                },
                error: function (xhr) {
                    console.error("Error Panggil Berikutnya:", xhr);
                },
                complete: function () {
                    // Aktifkan kembali tombol setelah menerima response (berhasil/gagal)
                    btnCallNext.disabled = false;
                    btnCallNext.innerHTML = originalContent;
                }
            });
        });
        
        // Handle Reset Status
        btnResetStatus.addEventListener('click', (e) => {
            // Nonaktifkan tombol untuk mencegah spam klik
            const originalContent = btnResetStatus.innerHTML;
            btnResetStatus.disabled = true;
            btnResetStatus.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

            $.ajax({
                url: `/ticket/reset-status`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log("Response Reset Status:", response);
                },
                error: function (xhr) {
                    console.error("Response Reset Status", xhr);
                },
                complete: function () {
                    btnResetStatus.disabled = false;
                    btnResetStatus.innerHTML = originalContent;
                }
            });
        })

    </script>
@endpush