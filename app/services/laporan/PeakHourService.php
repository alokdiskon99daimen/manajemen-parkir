<?php

namespace App\Services\Laporan;

use App\Models\Transaksi;

class PeakHourService
{
    public function traffic()
    {
        return Transaksi::where('status', 'keluar')
            ->selectRaw('HOUR(waktu_masuk) as jam, COUNT(*) as total')
            ->groupBy('jam')
            ->orderBy('total', 'desc')
            ->get();
    }

    public function averageDuration()
    {
        return Transaksi::where('status', 'keluar')
            ->selectRaw('HOUR(waktu_masuk) as jam, AVG(durasi_jam) as rata_durasi')
            ->groupBy('jam')
            ->orderBy('jam')
            ->get();
    }
}
