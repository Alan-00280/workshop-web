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
    const modalElem = document.getElementById('modalBarang');
    const myModal = new bootstrap.Modal(modalElem);

    let openCam = false

    const qrCodeSuccessCallback = async (decodedText, decodedResult) => {
        // console.log("Hasil Scan: ", decodedText);
        // alert("Barcode terdeteksi: " + decodedText);

        beepSound.play()
        openCam = false
        toggleCam(openCam, html5QrCode, qrCodeSuccessCallback, config)

        try {
            const response = await fetch('/barang/get', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id_barang: decodedText })
            });

            const result = await response.json();

            if (result.status === "success") {
                const barang = result.data.barang;

                document.getElementById('res_id_barang').innerText = barang.id_barang;
                document.getElementById('res_nama_barang').innerText = barang.nama;

                const hargaFormatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(barang.harga);

                document.getElementById('res_harga_barang').innerText = hargaFormatted;
                myModal.show();
            } else {
                throw new Error("Barang tidak ditemukan");
            }

        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Gagal",
                text: "Barang tidak terdaftar di sistem!"
            });
        }
    };

    const config = {
        fps: 15, // Ditingkatkan sedikit agar lebih responsif untuk barcode
        // Untuk Barcode (1D), buat kotak scan lebih lebar secara horizontal
        qrbox: { width: 450, height: 80 },
        aspectRatio: 1.777778, // Rasio 16:9 agar tampilan kamera lebih luas
        // Opsional: Batasi hanya format tertentu agar performa lebih cepat
        formatsToSupport: [
            Html5QrcodeSupportedFormats.CODE_128
        ]
    };

    if (document.getElementById('reader')) {
        toggleCamBtn.addEventListener('click', () => {
            openCam = !openCam
            toggleCam(openCam, html5QrCode, qrCodeSuccessCallback, config)
        })

        scanAgainBtn.addEventListener('click', () => {
            myModal.hide();

            modalElem.addEventListener('hidden.bs.modal', function handler() {
                openCam = true; 
                toggleCam(openCam, html5QrCode, qrCodeSuccessCallback, config);

                modalElem.removeEventListener('hidden.bs.modal', handler);
            });
        });
    }

});