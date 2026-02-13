<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Riwayat Parkir</title>

    <style>
        body {
            font-family: monospace;
            background: #f3f4f6;
            padding: 20px;
        }

        .wrapper {
            display: flex;
            justify-content: center;
        }

        .card {
            width: 320px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,.12);
            overflow: hidden;
            font-size: 12px;
        }

        .card-header {
            background: #2563eb;
            color: #fff;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .card-body {
            padding: 14px;
            text-align: center;
        }

        .card-body p {
            margin: 4px 0;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
        }

        .card-footer {
            padding: 12px;
            display: flex;
            gap: 8px;
            background: #f9fafb;
        }

        .btn {
            flex: 1;
            padding: 6px;
            font-size: 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .btn-print {
            background: #2563eb;
            color: #fff;
        }

        .btn-back {
            background: #e5e7eb;
            color: #111827;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .card {
                box-shadow: none;
                border-radius: 0;
            }

            .card-footer {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="wrapper">
    <div class="card">

        <div class="card-header">
            DETAIL RIWAYAT PARKIR
        </div>

        <div class="card-body">
            <p>Plat : {{ $transaksi->dataKendaraan->plat_nomor }}</p>
            <p>Tipe : {{ $transaksi->dataKendaraan->tipeKendaraan->tipe_kendaraan }}</p>
            <p>Area : {{ $transaksi->areaParkir->nama_area }}</p>

            <hr>

            <p>Waktu Masuk : {{ $transaksi->waktu_masuk->format('d M Y H:i') }}</p>
            <p>Waktu Keluar :
                {{ $transaksi->waktu_keluar ? $transaksi->waktu_keluar->format('d M Y H:i') : '-' }}
            </p>

            @php
                if ($transaksi->waktu_keluar) {
                    $menit = $transaksi->waktu_masuk->diffInMinutes($transaksi->waktu_keluar);
                    $jam = intdiv($menit, 60);
                    $sisa = $menit % 60;
                }
            @endphp

            <p>
                Durasi :
                @if($transaksi->waktu_keluar)
                    {{ $jam }} jam {{ $sisa }} menit
                @else
                    -
                @endif
            </p>

            <hr>

            <p>Tarif Dasar :
                Rp {{ number_format($transaksi->biaya,0,',','.') }}
            </p>
            @php
                $diskonMember = $transaksi->diskon_member ?? 0;
                $diskonManual = $transaksi->diskon_manual ?? 0;
                $totalDiskonPersen = min($diskonMember + $diskonManual, 100);
                $diskonRupiah = ($totalDiskonPersen / 100) * $transaksi->biaya;
            @endphp

            @if($totalDiskonPersen > 0)
                @if($diskonMember > 0)
                    <p>Diskon Member ({{ $diskonMember }}%)</p>
                @endif

                @if($diskonManual > 0)
                    <p>Diskon Manual ({{ $diskonManual }}%)</p>
                @endif

                <p>Total Diskon ({{ $totalDiskonPersen }}%) :
                    - Rp {{ number_format($diskonRupiah,0,',','.') }}
                </p>
            @endif

            @if($transaksi->biaya_total == 0)
                <p><strong>FREE ENTRY</strong></p>
            @endif
            <hr>

            <p class="total">TOTAL BAYAR</p>
            <p class="total">
                Rp {{ number_format($transaksi->biaya_total,0,',','.') }}
            </p>

            <p>Metode : {{ $transaksi->metodePembayaran->metode_pembayaran ?? '-' }}</p>
            <p>Tanggal : {{ $transaksi->updated_at->format('d-m-Y') }}</p>

            <hr>

            <p><strong>Nomor Struk</strong></p>
            <p>{{ $transaksi->kode_tiket }}</p>

            <br>

            <img
                src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($transaksi->kode_tiket) }}"
                alt="QR Code"
            >
        </div>

        <div class="card-footer">
            <button onclick="window.print()" class="btn btn-print">Print</button>
            <a href="{{ route('transaksi.riwayat') }}" class="btn btn-back">Kembali</a>
        </div>

    </div>
</div>

</body>
</html>
