<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Undangan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 60px;
            color: #333;
        }
        .card {
            border: 2px solid #6f42c1;
            padding: 45px;
        }
        .title {
            text-align: center;
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }
        .section {
            font-size: 18px;
            margin-bottom: 16px;
            line-height: 1.6;
        }
        .label {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="title">UNDANGAN</div>

        <div class="section">
            Kepada Yth,<br>
            <span class="label">{{ $recipient_name }}</span>
        </div>

        <div class="section">
            Dengan hormat, kami mengundang Anda untuk menghadiri kegiatan:
        </div>

        <div class="section">
            <span class="label">Nama Kegiatan:</span><br>
            {{ $event_name }}
        </div>

        <div class="section">
            <span class="label">Deskripsi:</span><br>
            {{ $event_description }}
        </div>

        <div class="section">
            <span class="label">Tanggal:</span>
            {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
        </div>

        <div class="section">
            <span class="label">Waktu:</span>
            {{ $time }}
        </div>

        <div class="footer">
            Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Anda kami ucapkan terima kasih.
        </div>
    </div>
</body>
</html>