<?php

namespace App\Services\Laporan;

use App\Models\Transaksi;
use Carbon\Carbon;

class RevenueAnalyticsService
{
    public function perHari($start = null, $end = null)
    {
        $start = $start ? Carbon::parse($start)->startOfDay() : now()->subDays(6);
        $end   = $end   ? Carbon::parse($end)->endOfDay()   : now();

        return Transaksi::where('status', 'keluar')
            ->whereBetween('waktu_masuk', [$start, $end])
            ->selectRaw('DATE(waktu_masuk) as tanggal, SUM(biaya_total) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    }

    public function byTipeKendaraan()
    {
        return Transaksi::where('status', 'keluar')
            ->join('tb_data_kendaraan', 'tb_data_kendaraan.id', '=', 'tb_transaksi.id_data_kendaraan')
            ->join('tb_tipe_kendaraan', 'tb_tipe_kendaraan.id', '=', 'tb_data_kendaraan.id_tipe_kendaraan')
            ->selectRaw('
                tb_tipe_kendaraan.tipe_kendaraan as label,
                SUM(tb_transaksi.biaya_total) as total
            ')
            ->groupBy('label')
            ->get();
    }

    public function byArea()
    {
        return Transaksi::where('status', 'keluar')
            ->join('tb_area_parkir', 'tb_area_parkir.id', '=', 'tb_transaksi.id_area')
            ->selectRaw('
                tb_area_parkir.nama_area as label,
                SUM(tb_transaksi.biaya_total) as total
            ')
            ->groupBy('label')
            ->get();
    }
}
