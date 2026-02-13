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
    <p>Waktu Masuk : {{ $transaksi->waktu_masuk->format('d M Y H:i') }}</p>
    <p>Waktu Keluar : {{ $transaksi->waktu_keluar->format('d M Y H:i') }}</p>

    @php
        $menit = $transaksi->waktu_masuk->diffInMinutes($transaksi->waktu_keluar);
        $jam = intdiv($menit, 60);
        $sisa = $menit % 60;
    @endphp

    <p>Durasi : {{ $jam }} jam {{ $sisa }} menit</p>

    <hr>

    <p>Tarif Dasar : Rp {{ number_format($transaksi->biaya,0,',','.') }}</p>
    @php
        $diskonMember = $transaksi->diskon_member ?? 0;
        $diskonManual = $transaksi->diskon_manual ?? 0;
        $totalDiskonPersen = min($diskonMember + $diskonManual, 100);
        $diskonRupiah = ($totalDiskonPersen / 100) * $transaksi->biaya;
    @endphp

    @if($memberInfo && $memberInfo['is_free_entry'])
        <p><strong>FREE ENTRY TERPAKAI</strong></p>
        <p>Sisa Free Entry : {{ $memberInfo['sisa_free_entry'] }}</p>
    @elseif($totalDiskonPersen > 0)
        @if($diskonMember > 0)
            <p>Diskon Member ({{ $diskonMember }}%) : 
                - Rp {{ number_format($diskonRupiah * ($diskonMember / $totalDiskonPersen),0,',','.') }}
            </p>
        @endif

        @if($diskonManual > 0)
            <p>Diskon Manual ({{ $diskonManual }}%) : 
                - Rp {{ number_format($diskonRupiah * ($diskonManual / $totalDiskonPersen),0,',','.') }}</p>
        @endif

        <p>Total Diskon ({{ $totalDiskonPersen }}%) :
            - Rp {{ number_format($diskonRupiah,0,',','.') }}
        </p>
    @endif


    <hr>

    <p><strong>TOTAL BAYAR</strong></p>
    <p><strong>Rp {{ number_format($transaksi->biaya_total,0,',','.') }}</strong></p>

    <p>Metode : {{ $transaksi->metodePembayaran->metode_pembayaran ?? '-' }}</p>
    <p>Tanggal : {{ now()->format('d-m-Y') }}</p>
    <p>Operator : {{ $transaksi->user->name ?? '-' }}</p>

    <hr>

    <p><strong>Nomor Struk</strong></p>
    <p>{{ $transaksi->kode_tiket }}</p>

    <br>

    @php
        $qrData = json_encode([
            'kode_tiket' => $transaksi->kode_tiket,
            'plat_nomor' => $transaksi->dataKendaraan->plat_nomor,
        ]);
    @endphp

    <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrData) }}"
        alt="QR Code"
    />
</div>

</body>
</html>
