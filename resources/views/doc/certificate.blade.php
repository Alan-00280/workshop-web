<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            text-align: center;
            padding: 60px;
        }
        .border {
            border: 12px solid #6f42c1;
            padding: 50px;
        }
        .title {
            font-size: 42px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 25px;
        }
        .subtitle {
            font-size: 18px;
        }
        .name {
            font-size: 34px;
            font-weight: bold;
            margin: 20px 0;
        }
        .event {
            font-size: 22px;
            margin: 15px 0;
        }
        .desc {
            font-size: 16px;
            max-width: 520px;
            margin: 20px auto;
        }
        .date {
            margin-top: 40px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="border">
        <div class="title">SERTIFIKAT</div>

        <div class="subtitle">Diberikan kepada</div>
        <div class="name">{{ $recipient_name }}</div>

        <div class="subtitle">Atas partisipasinya dalam kegiatan</div>
        <div class="event">{{ $event_name }}</div>

        <div class="desc">{{ $event_description }}</div>

        <div class="date">
            {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
        </div>
    </div>
</body>
</html>