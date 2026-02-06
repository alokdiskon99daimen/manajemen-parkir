<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Keluar Parkir</title>
    <style>
        body {
            font-family: monospace;
            text-align: center;
        }
        .struk {
            width: 280px;
            margin: auto;
            font-size: 12px;
        }
        hr {
            border: none;
            border-top: 1px dashed #000;
        }
    </style>
</head>

<body onload="window.print(); setTimeout(() => window.location.href='{{ route('transaksi.index') }}', 1500)">

<div class="struk">
    <h3>STRUK KELUAR PARKIR</h3>
    <hr>

    <p>Plat : {{ $transaksi->dataKendaraan->plat_nomor }}</p>
    <p>Jam Masuk : {{ $transaksi->waktu_masuk->format('H:i') }}</p>
    <p>Jam Keluar : {{ $transaksi->waktu_keluar->format('H:i') }}</p>

    @php
        $menit = $transaksi->waktu_masuk->diffInMinutes($transaksi->waktu_keluar);
        $jam = intdiv($menit, 60);
        $sisa = $menit % 60;
    @endphp

    <p>Durasi : {{ $jam }} jam {{ $sisa }} menit</p>

    <hr>

    <p>Tarif Dasar : Rp {{ number_format($transaksi->biaya,0,',','.') }}</p>
    <p>Diskon Member :
        - Rp {{ number_format($transaksi->biaya - $transaksi->biaya_total,0,',','.') }}
    </p>

    <hr>

    <p><strong>TOTAL BAYAR</strong></p>
    <p><strong>Rp {{ number_format($transaksi->biaya_total,0,',','.') }}</strong></p>

    <p>Metode : Tunai</p>
    <p>Tanggal : {{ now()->format('d-m-Y') }}</p>
    <p>Operator : {{ $transaksi->user->name ?? '-' }}</p>

    <hr>

    <p><strong>Nomor Struk</strong></p>
    <p>{{ $transaksi->kode_tiket }}</p>

    <br>

    {{-- QR CODE (SOLUSI 3 - TANPA PACKAGE) --}}
    <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($transaksi->kode_tiket) }}"
        alt="QR Code"
    >
</div>

</body>
</html>
