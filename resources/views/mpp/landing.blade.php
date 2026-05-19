@extends('mpp.layouts.app')

@push('style_page')
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            padding: 100px 0;
        }

        .section-padding {
            padding: 80px 0;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(75, 108, 183, 0.1);
            color: #4b6cb7;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .bg-light-blue {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('nav')
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
        <div class="container">
            <a class="nav-left text-decoration-none" href="/mpp">
                <h2 class="fw-bold mb-0 text-primary">MPP Kita</h2>
                <p class="mb-0 text-muted small">Sistem Antrian Digital</p>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('mpp-show-create-ticket') }}">Daftar Antrian</a></li>
                    <li class="nav-item"><a class="nav-link" href="#informasi">Informasi</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-2" href="/login">Masuk</a></li>
                </ul>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <!-- Hero Section -->
        <section class="hero-section text-center">
            <div class="container">
                <h1 class="display-4 fw-bold mb-4">Mall Pelayanan Publik</h1>
                <p class="lead mb-5">Akses berbagai layanan publik dalam satu tempat dengan mudah dan cepat.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#antrian" class="btn btn-light btn-lg px-4">Ambil Antrian</a>
                    <a href="#layanan" class="btn btn-outline-light btn-lg px-4">Lihat Layanan</a>
                </div>
            </div>
        </section>

        <!-- Statistic Section -->
        <section class="section-padding bg-white">
            <div class="container text-center">
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <h2 class="fw-bold text-primary">150+</h2>
                        <p class="text-muted">Total Layanan</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <h2 class="fw-bold text-primary">15</h2>
                        <p class="text-muted">Kategori Instansi</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <h2 class="fw-bold text-primary">342</h2>
                        <p class="text-muted">Antrian Hari Ini</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <h2 class="fw-bold text-primary">15 Menit</h2>
                        <p class="text-muted">Rata-rata Waktu</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fitur Unggulan -->
        <section class="section-padding bg-light-blue">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Fitur Unggulan</h2>
                    <p class="text-muted">Kemudahan yang Anda dapatkan di Mall Pelayanan Publik</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="card h-100 border-0 shadow-sm card-hover text-center p-4">
                            <div class="d-flex justify-content-center">
                                <div class="icon-box"><i class="fas fa-users"></i></div>
                            </div>
                            <h5 class="fw-bold">Antrian Online</h5>
                            <p class="text-muted small">Atur antrian dari rumah tanpa harus datang lebih awal.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 border-0 shadow-sm card-hover text-center p-4">
                            <div class="d-flex justify-content-center">
                                <div class="icon-box"><i class="fas fa-clock"></i></div>
                            </div>
                            <h5 class="fw-bold">Tracking Real-time</h5>
                            <p class="text-muted small">Pantau posisi antrian Anda secara langsung.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 border-0 shadow-sm card-hover text-center p-4">
                            <div class="d-flex justify-content-center">
                                <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                            </div>
                            <h5 class="fw-bold">Lokasi & Jam</h5>
                            <p class="text-muted small">Informasi lengkap lokasi dan jam buka layanan.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 border-0 shadow-sm card-hover text-center p-4">
                            <div class="d-flex justify-content-center">
                                <div class="icon-box"><i class="fas fa-file-alt"></i></div>
                            </div>
                            <h5 class="fw-bold">Persyaratan</h5>
                            <p class="text-muted small">Ketahui dokumen apa saja yang diperlukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kategori Layanan -->
        <section class="section-padding bg-white" id="layanan">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Kategori Layanan</h2>
                    <p class="text-muted">Pilih instansi atau kategori layanan yang Anda butuhkan</p>
                </div>
                <div class="row g-4">
                    <!-- Mockup Items -->
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm card-hover p-3 text-center">
                            <i class="fas fa-id-card fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold">Kependudukan</h6>
                            <p class="small text-muted mb-0">KTP, KK, Akta</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm card-hover p-3 text-center">
                            <i class="fas fa-car fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold">Samsat</h6>
                            <p class="small text-muted mb-0">Pajak Kendaraan</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm card-hover p-3 text-center">
                            <i class="fas fa-building fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold">Perizinan</h6>
                            <p class="small text-muted mb-0">SIUP, IMB</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm card-hover p-3 text-center">
                            <i class="fas fa-passport fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold">Imigrasi</h6>
                            <p class="small text-muted mb-0">Paspor, Visa</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Layanan Populer -->
        <section class="section-padding bg-light-blue">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h2 class="fw-bold">Daftar Layanan</h2>
                        <p class="text-muted mb-0">Layanan yang tersedia di MPP</p>
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="Cari layanan...">
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm card-hover h-100">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">Kependudukan</span>
                                <h5 class="card-title fw-bold">Pembuatan e-KTP Baru</h5>
                                <p class="card-text text-muted small">Layanan pembuatan KTP elektronik untuk warga yang baru
                                    berusia 17 tahun atau belum memiliki.</p>
                                <ul class="list-unstyled small mb-0">
                                    <li><i class="far fa-clock me-2"></i> Estimasi: 1 Hari</li>
                                    <li><i class="fas fa-wallet me-2"></i> Gratis</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-white border-0 text-end">
                                <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm card-hover h-100">
                            <div class="card-body">
                                <span class="badge bg-success mb-2">Samsat</span>
                                <h5 class="card-title fw-bold">Perpanjangan STNK</h5>
                                <p class="card-text text-muted small">Layanan perpanjangan Surat Tanda Nomor Kendaraan
                                    tahunan.</p>
                                <ul class="list-unstyled small mb-0">
                                    <li><i class="far fa-clock me-2"></i> Estimasi: 2 Jam</li>
                                    <li><i class="fas fa-wallet me-2"></i> Sesuai Pajak</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-white border-0 text-end">
                                <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm card-hover h-100">
                            <div class="card-body">
                                <span class="badge bg-warning text-dark mb-2">Imigrasi</span>
                                <h5 class="card-title fw-bold">Pembuatan Paspor</h5>
                                <p class="card-text text-muted small">Layanan pembuatan paspor baru untuk keperluan
                                    perjalanan ke luar negeri.</p>
                                <ul class="list-unstyled small mb-0">
                                    <li><i class="far fa-clock me-2"></i> Estimasi: 3 Hari</li>
                                    <li><i class="fas fa-wallet me-2"></i> Rp 350.000</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-white border-0 text-end">
                                <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-primary">Lihat Semua Layanan</a>
                </div>
            </div>
        </section>

        <!-- Antrian Section -->
        <section class="section-padding bg-white" id="antrian">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <h2 class="fw-bold">Informasi Antrian</h2>
                        <p class="text-muted mb-4">Ambil antrian lebih awal dan pantau status antrian Anda secara real-time
                            dari mana saja.</p>

                        <div class="card border-0 shadow bg-light-blue p-4 rounded-3 mb-4">
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <p class="text-muted mb-1 small">Antrian Saat Ini</p>
                                    <h3 class="fw-bold text-primary">A-024</h3>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">Antrian Anda</p>
                                    <h3 class="fw-bold text-success">A-042</h3>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <p class="small text-muted mb-0"><i class="fas fa-clock me-1"></i> Estimasi waktu tunggu: 45
                                    Menit</p>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg w-100">Ambil Antrian Sekarang</button>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800"
                            alt="Queue" class="img-fluid rounded-4 shadow">
                    </div>
                </div>
            </div>
        </section>

        <!-- Persyaratan & Alur -->
        <section class="section-padding bg-dark text-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <h3 class="fw-bold mb-4">Persyaratan Dokumen</h3>
                        <ul class="list-group list-group-flush rounded-3">
                            <li class="list-group-item bg-dark text-white border-secondary d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i> Kartu Tanda Penduduk (KTP) Asli &
                                Fotokopi
                            </li>
                            <li class="list-group-item bg-dark text-white border-secondary d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i> Kartu Keluarga (KK) Asli & Fotokopi
                            </li>
                            <li class="list-group-item bg-dark text-white border-secondary d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i> Dokumen pendukung sesuai layanan
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3 class="fw-bold mb-4">Alur Pengurusan</h3>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <span class="badge bg-primary rounded-circle p-2">1</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold">Ambil Antrian</h6>
                                <p class="small text-light opacity-75">Melalui website atau mesin antrian di lokasi</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <span class="badge bg-primary rounded-circle p-2">2</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold">Verifikasi Berkas</h6>
                                <p class="small text-light opacity-75">Petugas akan memeriksa kelengkapan dokumen</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <span class="badge bg-primary rounded-circle p-2">3</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold">Proses Layanan</h6>
                                <p class="small text-light opacity-75">Tunggu proses sesuai estimasi waktu layanan</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <span class="badge bg-success rounded-circle p-2">4</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold">Selesai</h6>
                                <p class="small text-light opacity-75">Dokumen atau hasil layanan diserahkan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Informasi & FAQ -->
        <section class="section-padding bg-light-blue" id="informasi">
            <div class="container">
                <div class="row">
                    <!-- Info -->
                    <div class="col-md-5 mb-5 mb-md-0">
                        <h3 class="fw-bold mb-4">Informasi Lengkap</h3>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-clock fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Jam Operasional</h6>
                                    <p class="small text-muted mb-0">Senin - Jumat: 08.00 - 15.00 WIB</p>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-calendar-times fa-2x text-danger me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Hari Libur</h6>
                                    <p class="small text-muted mb-0">Sabtu, Minggu & Hari Libur Nasional Tutup</p>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-map-marked-alt fa-2x text-success me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Lokasi</h6>
                                    <p class="small text-muted mb-0">Jl. Pahlawan No. 1, Kota Pusat</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ -->
                    <div class="col-md-7">
                        <h3 class="fw-bold mb-4">Pertanyaan Umum</h3>
                        <div class="accordion shadow-sm" id="accordionFAQ">
                            <div class="accordion-item border-0 border-bottom">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne">
                                        Bagaimana cara mengambil antrian online?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body text-muted small">
                                        Anda dapat mengklik tombol "Ambil Antrian" di halaman utama, kemudian pilih layanan
                                        yang dituju dan isi data diri. Anda akan mendapatkan nomor antrian digital.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-0 border-bottom">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed fw-bold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        Apakah saya harus membawa dokumen asli?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body text-muted small">
                                        Ya, sebagian besar layanan mewajibkan Anda untuk membawa dokumen asli untuk
                                        keperluan verifikasi berkas.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed fw-bold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        Berapa lama estimasi waktu pelayanan?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body text-muted small">
                                        Estimasi waktu pelayanan bervariasi tergantung jenis layanan. Anda dapat melihat
                                        detail estimasi pada daftar layanan.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial & Promo -->
        <section class="section-padding bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <h3 class="fw-bold mb-4">Testimoni Pengguna</h3>
                        <div class="card border-0 bg-light p-4 rounded-4 position-relative">
                            <i
                                class="fas fa-quote-left fa-3x text-primary opacity-25 position-absolute top-0 start-0 mt-3 ms-3"></i>
                            <div class="position-relative z-1 pt-3">
                                <p class="fst-italic text-muted mb-4">"Pelayanan sangat cepat dan terpadu. Antrian online
                                    sangat membantu saya agar tidak perlu menunggu lama di lokasi."</p>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center fw-bold me-3"
                                        style="width: 50px; height: 50px;">B</div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Budi Santoso</h6>
                                        <div class="text-warning small">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="fw-bold mb-4">Promo & Berita</h3>
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="row g-0">
                                <div
                                    class="col-4 bg-primary text-white d-flex align-items-center justify-content-center p-3 text-center">
                                    <div>
                                        <h4 class="fw-bold mb-0">INFO</h4>
                                        <small>Terbaru</small>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">Pemutihan Pajak Kendaraan</h5>
                                        <p class="card-text small text-muted">Dapatkan pembebasan denda pajak kendaraan
                                            bermotor hingga akhir bulan ini di loket Samsat MPP.</p>
                                        <a href="#" class="text-primary text-decoration-none small fw-bold">Baca
                                            Selengkapnya &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="py-5 bg-primary text-white text-center">
            <div class="container">
                <h3 class="fw-bold mb-3">Berlangganan Newsletter</h3>
                <p class="mb-4 opacity-75">Dapatkan informasi terbaru mengenai layanan publik dan pengumuman penting
                    lainnya.</p>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form class="d-flex bg-white rounded-pill p-1">
                            <input type="email" class="form-control border-0 rounded-pill px-4"
                                placeholder="Masukkan email Anda" required>
                            <button class="btn btn-dark rounded-pill px-4" type="submit">Langganan</button>
                        </form>
                        <div class="form-check mt-3 text-start d-inline-block">
                            <input class="form-check-input" type="checkbox" id="flexCheckDefault" required>
                            <label class="form-check-label small opacity-75" for="flexCheckDefault">
                                Saya setuju menerima email notifikasi
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('script')
    
@endpush
