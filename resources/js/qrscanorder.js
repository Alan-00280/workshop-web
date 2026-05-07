import { Html5Qrcode, Html5QrcodeSupportedFormats } from "html5-qrcode";


let isProcessing = false;
const beepSound = new Audio('/assets/sound/beep.mp3');

async function toggleCam(open, htmlQr, succesCb, config) {
    const toggleCamBtn = document.getElementById('btn-camera-toggle');
    const readerElem = document.getElementById('reader');

    if (isProcessing || !toggleCamBtn || !readerElem) return;

    isProcessing = true;
    toggleCamBtn.disabled = true;

    try {
        if (open) {
            toggleCamBtn.innerText = 'Starting Camera...';
            readerElem.innerText = "Loading camera stream...";

            await htmlQr.start(
                { facingMode: "environment" },
                config,
                succesCb
            );
            toggleCamBtn.innerText = 'Close Scanner';

            console.log("Camera started & canvas rendered.");
        } else {
            toggleCamBtn.innerText = 'Stopping...';
            await htmlQr.stop();

            toggleCamBtn.innerText = 'Open Scanner';
            console.log("Kamera berhenti.");
        }
    } catch (err) {
        console.error("Gagal start kamera:", err);
        alert("Gagal mengakses kamera. Pastikan izin diberikan dan gunakan HTTPS.");

        toggleCamBtn.innerText = 'Open Scanner';
    } finally {
        isProcessing = false;
        toggleCamBtn.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const html5QrCode = new Html5Qrcode("reader");
    const toggleCamBtn = document.getElementById('btn-camera-toggle')
    const scanAgainBtn = document.getElementById('btn-scan-again')
    const modalElem = document.getElementById('modalDetailJS');
    const modal = new bootstrap.Modal(modalElem)

    let openCam = false

    const qrCodeSuccessCallback = async (decodedText) => {

        beepSound.play()
        openCam = false
        toggleCam(openCam, html5QrCode, qrCodeSuccessCallback, config)
        
        const id = atob(decodedText)
        try {
            const response = await fetch(`/order/${id}`, { 
                    method: 'GET', 
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }
            );
            const result = await response.json();

            if (result.status === "success") {
                const { pesanan, detail, vendorTotal } = result.data;

                document.getElementById('md-order-id').innerText = pesanan.order_id;
                document.getElementById('md-nama').innerText = pesanan.nama;

                const badgeContainer = document.getElementById('md-status-badge');
                if (pesanan.status_bayar === 1) {
                    badgeContainer.innerHTML = `<span class="badge bg-success px-3 rounded-pill">LUNAS</span>`;
                } else {
                    badgeContainer.innerHTML = `<span class="badge bg-warning text-dark px-3 rounded-pill">BELUM LUNAS</span>`;
                }
                
                const tableBody = document.getElementById('md-table-body');
                tableBody.innerHTML = ''; // Kosongkan tabel dulu

                detail.forEach(item => {
                    const row = `
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">${item.nama_menu || 'Item #' + item.idmenu}</div>
                            ${item.catatan ? `<div class="text-muted small mt-1"><i class="fa-solid fa-quote-left me-1"></i>${item.catatan}</div>` : ''}
                        </td>
                        <td class="text-center">${formatRupiah(item.harga)}</td>
                        <td class="text-center">x ${item.jumlah}</td>
                        <td class="text-end fw-bold">${formatRupiah(item.subtotal)}</td>
                    </tr>
                `;
                    tableBody.innerHTML += row;
                });

                document.getElementById('md-total').innerText = formatRupiah(vendorTotal);
                modal.show();

            } else {
                throw new Error("Order tidak ditemukan");
            }

        } catch (error) {
            Swal.fire({ icon: "error", title: "Gagal", text: error.message });
        }
    };

    // Helper function biar ga nulis Intl.NumberFormat terus-menerus
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    const config = {
        fps: 15, // Ditingkatkan sedikit agar lebih responsif untuk barcode
        // Untuk Barcode (1D), buat kotak scan lebih lebar secara horizontal
        qrbox: { width: 200, height: 200 },
        aspectRatio: 1.777778, // Rasio 16:9 agar tampilan kamera lebih luas
        // Opsional: Batasi hanya format tertentu agar performa lebih cepat
        formatsToSupport: [
            Html5QrcodeSupportedFormats.EAN_13,
            Html5QrcodeSupportedFormats.CODE_128,
            Html5QrcodeSupportedFormats.QR_CODE
        ]
    };

    if (document.getElementById('reader')) {
        toggleCamBtn.addEventListener('click', () => {
            openCam = !openCam
            toggleCam(openCam, html5QrCode, qrCodeSuccessCallback, config)
        })

        scanAgainBtn.addEventListener('click', () => {
            modal.hide();

            modalElem.addEventListener('hidden.bs.modal', function handler() {
                openCam = true;
                toggleCam(openCam, html5QrCode, qrCodeSuccessCallback, config);

                modalElem.removeEventListener('hidden.bs.modal', handler);
            });
        });
    }

});