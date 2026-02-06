<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Masuk</title>
    <style>
        body {
            font-family: monospace;
            text-align: center;
        }
        .struk {
            width: 280px;
            margin: auto;
        }
        hr {
            border: none;
            border-top: 1px dashed #000;
        }
    </style>
</head>
<body onload="window.print(); setTimeout(() => window.location.href='{{ route('transaksi.index') }}', 1500)">

<div class="struk">
    <h3>STRUK MASUK PARKIR</h3>
    <hr>

    <p>Area : {{ $transaksi->areaParkir->nama_area }}</p>
    <p>Jam Masuk : {{ $transaksi->waktu_masuk->format('H:i') }}</p>
    <p>Plat : {{ $transaksi->dataKendaraan->plat_nomor }}</p>
    <p>Tipe : {{ $transaksi->dataKendaraan->tipeKendaraan->tipe_kendaraan }}</p>

    <hr>

    <p><strong>Nomor Struk</strong></p>
    <p>{{ $transaksi->kode_tiket }}</p>

    <br>

    {{-- QR CODE (SOLUSI 3) --}}
    <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($transaksi->kode_tiket) }}"
        alt="QR Code"
    >
</div>

</body>
</html>
