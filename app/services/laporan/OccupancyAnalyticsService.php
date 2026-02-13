<?php

namespace App\Services\Laporan;

use Illuminate\Support\Facades\DB;

class OccupancyAnalyticsService
{
    public function rate()
    {
        return DB::table('tb_area_parkir_detail')
            ->join('tb_tipe_kendaraan', 'tb_tipe_kendaraan.id', '=', 'tb_area_parkir_detail.id_tipe_kendaraan')
            ->selectRaw('
                tb_tipe_kendaraan.tipe_kendaraan as label,
                SUM(tb_area_parkir_detail.terisi) / SUM(tb_area_parkir_detail.kapasitas) * 100 as occupancy_rate
            ')
            ->groupBy('label')
            ->get();
    }
}
