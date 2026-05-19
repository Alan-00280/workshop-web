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

    /* Navbar */
    .monitor-nav {
        background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
        padding: 0.625rem 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .dot-live {
        width: 12px;
        height: 12px;
        background-color: #10b981; /* green */
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 10px #10b981;
        animation: pulse 1.5s infinite;
    }

    .dot-waiting {
        width: 12px;
        height: 12px;
        background-color: #b6b910; /* green */
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 10px #b9ae10;
        animation: pulse 1.5s infinite;
    }

    .dot-disconnected {
        width: 12px;
        height: 12px;
        background-color: #b91010;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 5px #b91010;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
        100% { opacity: 1; transform: scale(1); }
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

    /* Card Called Number */
    .card-called {
        background: rgba(75, 108, 183, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 1rem;
        padding: 0.85rem;
        text-align: center;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin-bottom: 0.625rem;
    }

    .tracking-widest {
        letter-spacing: 0.2em;
    }

    .number-glow {
        font-size: 8rem;
        font-weight: 800;
        color: #fbbf24; /* yellow */
        text-shadow: 0 0 20px rgba(251, 191, 36, 0.5);
        line-height: 1;
        margin: 0.265rem 0;
    }

    .badge-speaker {
        background-color: #fbbf24;
        color: #000;
        font-weight: 600;
        padding: 0.3rem 0.6rem;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 50rem;
    }

    /* Queue Waiting */
    .queue-waiting {
        background: rgba(75, 108, 183, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 1rem;
        padding: 1rem;
    }

    .waiting-title {
        letter-spacing: 0.1em;
        color: #9ca3af;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .waiting-item {
        background: rgba(75, 108, 183, 0.25);
        border-radius: 0.75rem;
        padding: 0.25rem 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
        margin-bottom: 0.25rem;
        width: 99%;
    }

    .waiting-no {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fbbf24;
        min-width: 60px;
    }

    .waiting-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* .antrian-list {
        max-height: 240px;
    } */

    /* .antrian-list::-webkit-scrollbar {
        width: 8px;
    }

    .antrian-list::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.363);
        border-radius: 20px;
    }

    .antrian-list::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #4b6bb75b 0%, #18284881 100%);
        box-shadow: 
            inset -2px 2px 3px hsl(0deg 0% 100% / 25%),
            inset 1px -2px 3px rgb(0 0 0/25%);
        border-radius: 20px;
    } */
</style>
@endpush

@section('nav')
    <header class="monitor-nav d-flex justify-content-between align-items-center sticky-top">
        <a class="nav-left text-decoration-none" href="/mpp">
            <h2 class="fw-bold mb-0 text-white">MPP Kita</h2>
            <p class="mb-0 text-white-50 small">Sistem Antrian Digital</p>
        </a>
        <div class="nav-right text-end d-flex align-items-center gap-4">
            <div class="d-flex flex-column text-end">
                <span class="fs-4 fw-bold" id="live-time">11:13:26</span>
                <span class="text-white-50 small" id="live-date">13 May 2026</span>
            </div>
            <div class="d-flex align-items-center gap-2 bg-dark bg-opacity-25 px-3 py-1 rounded-pill border border-light border-opacity-10" id="live-text">
                <span class="dot-waiting"></span>
                <span class="fw-bold text-white small text-uppercase">Connecting...</span>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <!-- Main Container -->
    <main class="main-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <!-- Card Called Number -->
                <div id="current-called" class="card-called hidden">
                    <div class="text-uppercase small tracking-widest text-white-50 fw-bold">Nomor Dipanggil</div>
                    <div id="field-1" class="number-glow">001</div>
                    <div id="field-2" class="fs-2 fw-bold text-white mb-1">BUDI KUSUMA</div>
                    <div id="field-3" class="fs-5 text-white-50 mb-3">DISDUKCAPIL</div>
                    
                    <div class="badge-speaker shadow">
                        <i class="fas fa-bullhorn"></i>
                        Silakan Menuju Loket <span id="field-3-2"></span>
                    </div>
                </div>

                <!-- Queue Waiting -->
                <div class="queue-waiting mt-2" >
                    <div class="waiting-title text-left text-uppercase small">
                        <i class="fa-solid fa-list"></i> 
                        Antrian Menunggu
                        <span id="badge-count" class="rounded-pill p-2 bg-dark text-light">0</span>
                    </div>
                    
                    <div id="queue-list" class="row g-1 justify-content-start antrian-list">
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('script')
<script>
    const liveTextUI = document.getElementById('live-text')
    const badgeCount = document.getElementById('badge-count')
    const ding = new Audio('/assets/sound/ding.mp3')
    let lastAntrian

    function playSynthesisSound(text, ding) { 
        if (!('speechSynthesis' in window)) {
            console.warn('Browser tidak mendukung Web Speech API');
            return;
        }

        // Batalkan speech yang sedang berjalan
        window.speechSynthesis.cancel();
        
        // Suara notifikasi: ting-tong kemudian teks
        const pesan = new SpeechSynthesisUtterance(
            text
        );
        pesan.lang  = 'id-ID'; // Bahasa Indonesia
        pesan.rate  = 0.85;    // Kecepatan (0.1 - 10)
        pesan.pitch = 1.0;     // Nada (0 - 2)
        pesan.volume = 1.0;    // Volume (0 - 1)

        //panggilan pesan
        ding.play()
        ding.onended = function() {
            window.speechSynthesis.speak(pesan);
        };
    }

    // Membuka koneksi SSE di JavaScript
    const source = new EventSource('/mpp/sse/antrian');
    
    // Event Antrian
    source.addEventListener('antrian-update', function(event) {
        const sse_data = JSON.parse(event.data);
        
        // Update UI status terhubung
        liveTextUI.innerHTML = `
                <span class="dot-live"></span>
                <span class="fw-bold text-white small text-uppercase">Live</span>
            `;
            
        // Update badge jumlah antrian status=waiting
        if (badgeCount) {
            const totalWaiting = sse_data.filter(item => item.status === 'waiting').length;
            badgeCount.textContent = totalWaiting;
        }

        // Update List
        const queueList = document.getElementById('queue-list');
        if (queueList) {
            queueList.innerHTML = ''; // Kosongkan list sebelum diupdate
            
            let count = 0
            sse_data.forEach(item => {
                if (item.status == "waiting" && (count++) < 5) {
                    const no_urut = String(item.no_urut).padStart(3, '0');
                    const nama = item.nama;
                    const layanan = item.layanan && item.layanan.kategori_layanan ? item.layanan.kategori_layanan.nama_kat : (item.layanan ? item.layanan.nama : '-');
                    
                    queueList.innerHTML += `
                        <div class="waiting-item">
                            <div class="waiting-no">${no_urut}</div>
                            <div class="waiting-info text-start">
                                <span class="fw-bold text-white fs-6">${nama}</span>
                                <span class="text-white-50" style="font-size: 0.75rem;">${layanan}</span>
                            </div>
                        </div>
                    `;
                }
            });
        }

        console.log("Antrian updated via SSE:", sse_data);
    });

    // Event Panggilan
    source.addEventListener('antrian-called', function (e) {
        const sse_data = JSON.parse(e.data);
        const sse_data_antrian = sse_data.antrian_called;

        // Update UI
        const currentCalled = document.getElementById('current-called');
        if (sse_data) {
            if (currentCalled) {
                const noUrut = String(sse_data_antrian.no_urut).padStart(3, '0');
                const nama = sse_data_antrian.nama;
                const kategori = sse_data_antrian.layanan?.kategori_layanan?.nama_kat || 'err_kat_layanan';
                const layanan = sse_data_antrian.layanan?.nama || '-';

                currentCalled.querySelector('#field-1').textContent = noUrut;
                currentCalled.querySelector('#field-2').textContent = nama;
                currentCalled.querySelector('#field-3').textContent = layanan;
                currentCalled.querySelector('#field-3-2').textContent = kategori;

                currentCalled.classList.remove('hidden');
            }

            // Play the sound
            try {
                if (sse_data.time !== lastAntrian?.time) {
                    lastAntrian = sse_data

                    const noUrut = String(lastAntrian.antrian_called.no_urut).padStart(2, '0');
                    const pesanPanggilan = `Atas nama ${lastAntrian.antrian_called.nama} Antrian nomor urut ${noUrut} silakan menuju loket ${lastAntrian.antrian_called.layanan?.kategori_layanan?.nama_kat}`
                    
                    playSynthesisSound(pesanPanggilan, ding)
                }
            } catch (error) {
                console.error(error)
            }

        } else {
            if (currentCalled) {
                currentCalled.querySelector('#field-1').textContent = '';
                currentCalled.querySelector('#field-2').textContent = '';
                currentCalled.querySelector('#field-3').textContent = '';
                currentCalled.querySelector('#field-3-2').textContent = '';

                currentCalled.classList.add('hidden');
            }
        }

        console.log("Dipanggil updated via SSE:", sse_data);
    });

    // Handel Disconeccted
    source.onerror = function (error) {
        if (source.readyState === EventSource.CLOSED) {
            // Status benar-benar mati total
            terhubungUI.innerHTML = `
                    <span class="dot-disconnected"></span>
                    <span class="small fw-bold text-danger">Disconnected</span>
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

</script>
@endpush

{{-- Update Live Time --}}
@push('script')
    <script>
        function updateTime() {
            const now = new Date();
            
            // Format Time
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-time').textContent = `${hours}:${minutes}:${seconds}`;
            
            // Format Date
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('live-date').textContent = now.toLocaleDateString('en-GB', options);
        }
        
        setInterval(updateTime, 1000);
        updateTime();
    </script>
@endpush
