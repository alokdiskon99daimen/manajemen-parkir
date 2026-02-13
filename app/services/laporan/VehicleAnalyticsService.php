<?php

namespace App\Services\Laporan;

use App\Models\Transaksi;

class VehicleAnalyticsService
{
    public function distribution()
    {
        return Transaksi::where('status', 'keluar')
            ->join('tb_data_kendaraan', 'tb_data_kendaraan.id', '=', 'tb_transaksi.id_data_kendaraan')
            ->join('tb_tipe_kendaraan', 'tb_tipe_kendaraan.id', '=', 'tb_data_kendaraan.id_tipe_kendaraan')
            ->selectRaw('
                tb_tipe_kendaraan.tipe_kendaraan as label,
                COUNT(tb_transaksi.id) as total
            ')
            ->groupBy('label')
            ->get();
    }
}
