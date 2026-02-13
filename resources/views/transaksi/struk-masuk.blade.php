<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Masuk</title>

    <style>
        body {
            font-family: monospace;
            text-align: center;
            padding: 20px;
        }
        .struk-wrapper {
            display: flex;
            justify-content: center;
        }

        .struk {
            width: 300px;
            background: #fff;
            padding: 16px;
            font-size: 12px;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,.1);
            text-align: center;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .btn {
            margin-top: 12px;
            display: flex;
            gap: 8px;
        }

        .btn a,
        .btn button {
            flex: 1;
            padding: 6px;
            font-size: 12px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
            text-decoration: none;
        }

        .btn-print {
            background: #2563eb;
            color: white;
        }

        .btn-back {
            background: #e5e7eb;
            color: #111827;
        }

        /* PRINT MODE */
        @media print {
            body {
                background: none;
                padding: 0;
            }

            .btn {
                display: none !important;
            }

            .struk {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>

<div class="struk-wrapper">
    <div class="struk">
        <h3>STRUK MASUK PARKIR</h3>
        <hr>

        <p>Area : {{ $transaksi->areaParkir->nama_area }}</p>
        <p>Waktu Masuk : {{ $transaksi->waktu_masuk->format('d M Y H:i') }}</p>
        <p>Plat : {{ $transaksi->dataKendaraan->plat_nomor }}</p>
        <p>Tipe : {{ $transaksi->dataKendaraan->tipeKendaraan->tipe_kendaraan }}</p>

        <hr>

        <p><strong>Nomor Struk</strong></p>
        <p>{{ $transaksi->kode_tiket }}</p>

        <br>

        <img
            src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($transaksi->kode_tiket) }}"
            alt="QR Code"
        >

        {{-- TOMBOL --}}
        <div class="btn">
            <button onclick="window.print()" class="btn-print">
                Print
            </button>

            <a href="{{ route('transaksi.aktif') }}" class="btn-back">
                Kembali
            </a>
        </div>
    </div>
</div>

</body>
</html>
