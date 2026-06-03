@extends('layouts.app')

@section('db-page-title', 'NFC Scanner (Sandbox)')
@section('icon-page')
    <i class="fa-solid fa-map-location-dot"></i> {{--TODO CHANGE ICON --}}
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>NFC Scanner</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container mt-1" style="padding-left:0">

        <h2>NFC Scanner</h2>

        <button onclick="startScan()">Aktifkan NFC</button>

        <p id="status">Belum aktif.</p>

        <div id="hasil"></div>

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
        async function startScan() {
            if (!('NDEFReader' in window)) {
                document.getElementById('status').textContent = 'Browser tidak mendukung Web NFC.';
                return;
            }

            try {
                const ndef = new NDEFReader();
                await ndef.scan();

                document.getElementById('status').textContent = 'NFC aktif. Dekatkan kartu...';
                document.getElementById('hasil').innerHTML = '<span style="color: blue;">[Sistem] Menunggu kartu ditempel...</span>';

                ndef.onreading = (event) => {
                    document.getElementById('hasil').innerHTML = '<span style="color: orange;">[Sistem] Kartu terdeteksi! Membaca data...</span>';

                    const serialNumber = event.serialNumber;
                    const message = event.message;
                    let isi = '';

                    try {
                        if (message && message.records) {
                            for (const record of message.records) {
                                if (record.data) {
                                    isi += new TextDecoder().decode(record.data);
                                }
                            }
                        }

                        // Tampilkan Hasil Akhir
                        document.getElementById('hasil').innerHTML =
                            '<p style="color: green;"><b>✓ Berhasil Membaca!</b></p>' +
                            '<p><b>Serial:</b> ' + (serialNumber || 'Tidak Diketahui') + '</p>' +
                            '<p><b>Isi Data (NDEF):</b> ' + (isi || '(Kosong / Bukan Teks)') + '</p>';

                    } catch (innerErr) {
                        document.getElementById('hasil').innerHTML = '<span style="color: red;">Error parsing data: ' + innerErr.message + '</span>';
                    }
                };

                ndef.onreadingerror = (err) => {
                    document.getElementById('hasil').innerHTML = `<span style="color: red;">[Error] Kartu terdeteksi, tapi format data tidak didukung (Bukan NDEF). ${JSON.stringify(err)}</span>`;
                };

            } catch (err) {
                document.getElementById('status').textContent = 'Error: ' + err.message;
            }
        }
    </script>
@endpush

{{-- Page Style --}}
@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush